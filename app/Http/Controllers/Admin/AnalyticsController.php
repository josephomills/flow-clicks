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
    
    // Set date ranges based on input
    if ($fromDate && $toDate) {
        // Custom date range - ensure start date is before end date
        $startDate = Carbon::parse($fromDate)->startOfDay();
        $endDate = Carbon::parse($toDate)->endOfDay();
        
        // If end date is before start date, swap them
        if ($endDate->lt($startDate)) {
            [$startDate, $endDate] = [$endDate, $startDate];
            // Update the request values to reflect the swap
            $fromDate = $startDate->format('Y-m-d');
            $toDate = $endDate->format('Y-m-d');
        }
        
        $daysDifference = $startDate->diffInDays($endDate) + 1;
    } else {
        // Predefined period
        $endDate = now();
        $startDate = now()->subDays($period);
        $daysDifference = $period;
        
        // Set default values for the date inputs
        $fromDate = $startDate->format('Y-m-d');
        $toDate = $endDate->format('Y-m-d');
    }
    
    // Calculate previous period for comparison (same duration)
    $previousEndDate = $startDate->copy()->subDay()->endOfDay();
    $previousStartDate = $previousEndDate->copy()->subDays($daysDifference - 1)->startOfDay();
    
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
    
    // Get recent clicks within the selected date range
    $recentClicks = LinkClick::with(['link', 'link_type', 'denomination'])
        ->whereBetween('created_at', [$startDate, $endDate])
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
        'fromDate' => $fromDate,
        'toDate' => $toDate,
        'startDate' => $startDate->format('Y-m-d'),
        'endDate' => $endDate->format('Y-m-d'),
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
