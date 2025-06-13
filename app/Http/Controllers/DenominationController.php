<?php

namespace App\Http\Controllers;

use App\Models\Denomination;
use App\Models\Zone;
use Illuminate\Http\Request;

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
        // dd($request);
        // verify
        try {
            // dd($request);
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:denominations',
                'country' => 'nullable|string|max:255',
                'city' => 'string',
                'population' => 'required',
                'zone_id' => 'exists:zones,id',
            ]);

            // Create the new department
            Denomination::create($validatedData);


            // Redirect back with a success message
            return redirect()->route('admin.denominations')->with('success', 'Denomination created successfully!');
        } catch (\Exception $e) {
            // Log the error message (optional)
            \Log::error($e->getMessage());

            session()->flash("error", 'Something went wrong while creating the denomination. Please try again.' . $e);
            // Redirect back with an error message
            return redirect()->back()->withInput();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denomination $denomination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denomination $denomination)
    {
        //
    }
}
