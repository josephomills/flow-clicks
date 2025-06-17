<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkClick;
use Illuminate\Http\Request;

class ClicksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = LinkClick::query();

    // Get filter options for dropdowns
    $countries = LinkClick::whereNotNull('country_code')
        ->distinct()
        ->orderBy('country_code')
        ->pluck('country_code');

    $devices = LinkClick::whereNotNull('device_type')
        ->distinct()
        ->orderBy('device_type')
        ->pluck('device_type');

    $denominations = LinkClick::whereHas('denomination')
        ->with('denomination')
        ->get()
        ->pluck('denomination.name')
        ->unique()
        ->sort()
        ->values();

    // Apply search based on criteria
    if ($request->filled('search') && $request->filled('criteria')) {
        $searchTerm = $request->search;
        $criteria = $request->criteria;

        switch ($criteria) {
            case 'denomination':
                $query->whereHas('denomination', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                });
                break;
            case 'country':
                $query->where('country_code', 'like', "%{$searchTerm}%");
                break;
            case 'device':
                $query->where('device_type', 'like', "%{$searchTerm}%");
                break;
            case 'date':
                // Search by date range or specific date
                try {
                    $date = Carbon::parse($searchTerm);
                    $query->whereDate('created_at', $date);
                } catch (\Exception $e) {
                    // If not a valid date, search by month/year
                    $query->where(function($q) use ($searchTerm) {
                        $q->whereRaw('DATE_FORMAT(created_at, "%Y-%m") LIKE ?', ["%{$searchTerm}%"])
                          ->orWhereRaw('DATE_FORMAT(created_at, "%Y") LIKE ?', ["%{$searchTerm}%"])
                          ->orWhereRaw('DATE_FORMAT(created_at, "%M %Y") LIKE ?', ["%{$searchTerm}%"]);
                    });
                }
                break;
        }
    }

    // Apply dropdown filters (when user selects from dropdown)
    if ($request->filled('country_filter')) {
        $query->where('country_code', $request->country_filter);
    }

    if ($request->filled('device_filter')) {
        $query->where('device_type', $request->device_filter);
    }

    if ($request->filled('denomination_filter')) {
        $query->whereHas('denomination', function($q) use ($request) {
            $q->where('name', $request->denomination_filter);
        });
    }

    // Default ordering
    $query->orderBy('created_at', 'desc');

    $clicks = $query->paginate(10)->appends($request->query());

    return view("admin.clicks.index", compact("clicks", "countries", "devices", "denominations"));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
