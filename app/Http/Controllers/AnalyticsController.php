<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;
use App\Models\LinkGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $period = $request->input('period', 30); // Default to 30 days

        // Calculate date ranges
        $endDate = now();
        $startDate = now()->subDays($period);
        $previousStartDate = now()->subDays($period * 2);
        $previousEndDate = $startDate->copy()->subDay();

        // Get click counts for current period
        $facebookClicks = LinkClick::whereHas('link_type', function ($query) {
            $query->where('name', 'facebook');
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $youtubeClicks = LinkClick::whereHas('link_type', function ($query) {
            $query->where('name', 'youtube');
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalClicks = LinkClick::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Get click counts for previous period for comparison
        $prevFacebookClicks = LinkClick::whereHas('link_type', function ($query) {
            $query->where('name', 'facebook');
        })
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $prevYoutubeClicks = LinkClick::whereHas('link_type', function ($query) {
            $query->where('name', 'youtube');
        })
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $prevTotalClicks = LinkClick::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        // Calculate percentage changes with protection against division by zero
        $facebookChange = $prevFacebookClicks > 0
            ? (($facebookClicks - $prevFacebookClicks) / $prevFacebookClicks) * 100
            : ($facebookClicks > 0 ? 100 : 0);

        $youtubeChange = $prevYoutubeClicks > 0
            ? (($youtubeClicks - $prevYoutubeClicks) / $prevYoutubeClicks) * 100
            : ($youtubeClicks > 0 ? 100 : 0);

        $totalChange = $prevTotalClicks > 0
            ? (($totalClicks - $prevTotalClicks) / $prevTotalClicks) * 100
            : ($totalClicks > 0 ? 100 : 0);

        // Get recent clicks with their associated link (if still needed)
        $recentClicks = LinkClick::with(['link']) // Only include if you still have a link relationship
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return view('admin.analytics.index', [
            'facebookClicks' => $facebookClicks,
            'youtubeClicks' => $youtubeClicks,
            'totalClicks' => $totalClicks,
            'facebookChange' => $facebookChange,
            'youtubeChange' => $youtubeChange,
            'totalChange' => $totalChange,
            'recentClicks' => $recentClicks,
            'selectedPeriod' => $period,
        ]);
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
        $group = LinkGroup::findOrFail($id);
        $linkIds = $group->links->pluck('id');

        // Get total clicks for all links in the group
        $totalClicks = $group->links->sum(function ($link) {
            return $link->clicks;
        });

        // Get clicks by specific device types
        $mobileClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'like', '%mobile%')
            ->count();

        $desktopClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'like', '%desktop%')
            ->count();

        $tabletClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'like', '%tablet%')
            ->count();

        return view('admin.analytics.show', [
            'group' => $group,
            'totalClicks' => $totalClicks,
            'mobileClicks' => $mobileClicks,
            'desktopClicks' => $desktopClicks,
            'tabletClicks' => $tabletClicks,
        ]);
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
