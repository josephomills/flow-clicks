<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denomination;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DenominationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $denominations = Denomination::query()
            ->withCount('clicks') // Eager load clicks count
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserve filters in pagination links

        return view('admin.denominations.index', [
            'denominations' => $denominations,
            'searchQuery' => $request->search,
            'filterStatus' => $request->status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all();
        return view('admin.denominations.create', compact(['zones']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:denominations',
                'country' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'avg_attendance' => 'nullable|integer|min:0',
                'zone_id' => 'required|exists:zones,id',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // 2MB max
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $this->uploadLogo($request->file('logo'), $validatedData['slug']);
                $validatedData['logo'] = $logoPath;
            }

            // Create the new denomination
            Denomination::create($validatedData);

            // Redirect back with a success message
            return redirect()->route('admin.denominations')->with('success', 'Denomination created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Denomination creation failed: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the denomination. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Denomination $denomination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Denomination $denomination)
    {
        $zones = Zone::all();
        return view('admin.denominations.edit', compact(['zones', 'denomination']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denomination $denomination)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:denominations,slug,' . $denomination->id,
                'avg_attendance' => 'nullable|integer|min:0',
                'country' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'zone_id' => 'required|exists:zones,id',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // 2MB max
            ]);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if it exists
                if ($denomination->logo && Storage::disk('public')->exists($denomination->logo)) {
                    Storage::disk('public')->delete($denomination->logo);
                }

                // Upload new logo
                $logoPath = $this->uploadLogo($request->file('logo'), $validated['slug']);
                $validated['logo'] = $logoPath;
            }

            // Update the model
            $denomination->update($validated);

            // Redirect with success message
            return redirect()
                ->route('admin.denominations.edit', $denomination)
                ->with('success', 'Denomination updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Denomination update failed: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the denomination. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denomination $denomination)
    {
        try {
            // Delete logo file if it exists
            if ($denomination->logo && Storage::disk('public')->exists($denomination->logo)) {
                Storage::disk('public')->delete($denomination->logo);
            }

            // Delete the denomination
            $denomination->delete();

            return redirect()
                ->route('admin.denominations')
                ->with('success', 'Denomination deleted successfully.');
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Denomination deletion failed: ' . $e->getMessage());

            return redirect()
                ->route('admin.denominations')
                ->with('error', 'Something went wrong while deleting the denomination. Please try again.');
        }
    }

    /**
     * Handle logo file upload
     */
    private function uploadLogo($file, $slug)
    {
        // Generate a unique filename
        $filename = $slug . '-' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store the file in the public disk under denominations folder
        $path = $file->storeAs('denominations/logos', $filename, 'public');
        
        return $path;
    }

    /**
     * Toggle denomination status (activate/deactivate)
     */
    public function toggleStatus(Denomination $denomination)
    {
        try {
            $denomination->update([
                'is_active' => !$denomination->is_active
            ]);

            $status = $denomination->is_active ? 'activated' : 'deactivated';
            
            return redirect()
                ->back()
                ->with('success', "Denomination {$status} successfully.");
        } catch (\Exception $e) {
            \Log::error('Denomination status toggle failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Something went wrong while updating the denomination status.');
        }
    }
}