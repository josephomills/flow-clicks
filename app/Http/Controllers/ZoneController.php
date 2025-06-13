<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $zones = Zone::query()
            ->withCount('denominations') // Eager load zones count
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

        return view('admin.zones.index', [
            'zones' => $zones,
            'searchQuery' => $request->search,
            'filterStatus' => $request->status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // verify
    try {
        // dd($request);
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:zones',
            'country' => 'nullable|string|max:255',
  
        ]);

        // Create the new department
        zone::create($validatedData);
        

        // Redirect back with a success message
        return redirect()->route('admin.zones')->with('success', 'zone created successfully!');
    } catch (\Exception $e) {
        // Log the error message (optional)
        \Log::error($e->getMessage());

        session()->flash("error",'Something went wrong while creating the zone. Please try again.' . $e);
        // Redirect back with an error message
        return redirect()->back()->withInput();
    }


    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        //
    }
}
