<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view('admin.zones.index');
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

            session()->flash("error", 'Something went wrong while creating the zone. Please try again.' . $e);
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
        return view('admin.zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:zones,slug,' . $zone->id,
            'country' => 'required|string|max:255',
        ]);

        $zone->update($validated);

        return redirect()->route('admin.zones.edit', $zone)->with('success', 'Zone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();

        return redirect()
            ->route('admin.zones')
            ->with('success', 'zone deleted successfully.');
    }
}
