<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkClick;
use App\Models\LinkGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Handle date range input
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $period = $request->input('period', 30); // Default to 30 days
    $analyticsType = $request->input('analytics_type', 'denomination');
    $analyticsId = $request->input('analytics_id');

    // Set date ranges based on input
    if ($fromDate && $toDate) {
        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();
        if ($endDate->lt($startDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
            $fromDate = $startDate->format('Y-m-d');
            $toDate = $endDate->format('Y-m-d');
        }
        $daysDifference = $startDate->diffInDays($endDate) + 1;
    } else {
        $endDate = now();
        $startDate = now()->subDays($period);
        $daysDifference = $period;
        $fromDate = $startDate->format('Y-m-d');
        $toDate = $endDate->format('Y-m-d');
    }

    // Get all denominations and zones for dropdowns
    $denominations = \App\Models\Denomination::orderBy('name')->get();
    $zones = \App\Models\Zone::orderBy('name')->get();

    // Only show analytics if a denomination or zone is selected
    $showAnalytics = $analyticsId !== null && $analyticsId !== '';

    // Default values
    $facebookClicks = $youtubeClicks = $totalClicks = 0;
    $facebookChange = $youtubeChange = $totalChange = 0;
    $recentClicks = collect();

    if ($showAnalytics) {
        if ($analyticsType === 'denomination') {
            $denomination = \App\Models\Denomination::find($analyticsId);
            if ($denomination) {
                $clicksQuery = $denomination->clicks()->whereBetween('created_at', [$startDate, $endDate]);
                $facebookClicks = $denomination->facebook_clicks()->whereBetween('created_at', [$startDate, $endDate])->count();
                $youtubeClicks = $denomination->youtube_clicks()->whereBetween('created_at', [$startDate, $endDate])->count();
                $totalClicks = $clicksQuery->count();
                $recentClicks = $clicksQuery->with(['link', 'link_type', 'denomination'])->orderBy('created_at', 'desc')->get();

                // Previous period
                $previousEndDate = $startDate->copy()->subDay()->endOfDay();
                $previousStartDate = $previousEndDate->copy()->subDays($daysDifference - 1)->startOfDay();
                $prevFacebookClicks = $denomination->facebook_clicks()->whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
                $prevYoutubeClicks = $denomination->youtube_clicks()->whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
                $prevTotalClicks = $denomination->clicks()->whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

                $facebookChange = $prevFacebookClicks > 0 ? (($facebookClicks - $prevFacebookClicks) / $prevFacebookClicks) * 100 : ($facebookClicks > 0 ? 100 : 0);
                $youtubeChange = $prevYoutubeClicks > 0 ? (($youtubeClicks - $prevYoutubeClicks) / $prevYoutubeClicks) * 100 : ($youtubeClicks > 0 ? 100 : 0);
                $totalChange = $prevTotalClicks > 0 ? (($totalClicks - $prevTotalClicks) / $prevTotalClicks) * 100 : ($totalClicks > 0 ? 100 : 0);
            }
        } elseif ($analyticsType === 'zone') {
            $zone = \App\Models\Zone::find($analyticsId);
            if ($zone) {
                // Base query for this zone and date range
                $baseClicksQuery = $zone->clicks()->whereBetween('link_clicks.created_at', [$startDate, $endDate]);

                // Total clicks (no link_type filter)
                $totalClicks = (clone $baseClicksQuery)->count();

                // Facebook clicks
                $facebookClicks = (clone $baseClicksQuery)
                    ->whereHas('link_type', function ($q) { $q->where('name', 'facebook'); })
                    ->count();

                // YouTube clicks
                $youtubeClicks = (clone $baseClicksQuery)
                    ->whereHas('link_type', function ($q) { $q->where('name', 'youtube'); })
                    ->count();

                // Recent clicks (for device breakdown)
                $recentClicks = (clone $baseClicksQuery)
                    ->with(['link', 'link_type', 'denomination'])
                    ->orderBy('link_clicks.created_at', 'desc')
                    ->take(50)
                    ->get();

                // Previous period
                $previousEndDate = $startDate->copy()->subDay()->endOfDay();
                $previousStartDate = $previousEndDate->copy()->subDays($daysDifference - 1)->startOfDay();
                $prevBaseClicksQuery = $zone->clicks()->whereBetween('link_clicks.created_at', [$previousStartDate, $previousEndDate]);

                $prevTotalClicks = (clone $prevBaseClicksQuery)->count();
                $prevFacebookClicks = (clone $prevBaseClicksQuery)
                    ->whereHas('link_type', function ($q) { $q->where('name', 'facebook'); })
                    ->count();
                $prevYoutubeClicks = (clone $prevBaseClicksQuery)
                    ->whereHas('link_type', function ($q) { $q->where('name', 'youtube'); })
                    ->count();

                $facebookChange = $prevFacebookClicks > 0 ? (($facebookClicks - $prevFacebookClicks) / $prevFacebookClicks) * 100 : ($facebookClicks > 0 ? 100 : 0);
                $youtubeChange = $prevYoutubeClicks > 0 ? (($youtubeClicks - $prevYoutubeClicks) / $prevYoutubeClicks) * 100 : ($youtubeClicks > 0 ? 100 : 0);
                $totalChange = $prevTotalClicks > 0 ? (($totalClicks - $prevTotalClicks) / $prevTotalClicks) * 100 : ($totalClicks > 0 ? 100 : 0);
            }
        }
    }

    return view('admin.analytics.index', [
        'facebookClicks' => $facebookClicks,
        'youtubeClicks' => $youtubeClicks,
        'totalClicks' => $totalClicks,
        'facebookChange' => $facebookChange,
        'youtubeChange' => $youtubeChange,
        'totalChange' => $totalChange,
        'recentClicks' => $recentClicks,
        'selectedPeriod' => $period,
        'fromDate' => $fromDate,
        'toDate' => $toDate,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
        'analyticsType' => $analyticsType,
        'analyticsId' => $analyticsId,
        'denominations' => $denominations,
        'zones' => $zones,
        'showAnalytics' => $showAnalytics,
    ]);
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

}
