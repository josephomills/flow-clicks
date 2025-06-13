<?php

namespace App\Livewire\Admin\Analytics;

use App\Models\Denomination;
use App\Models\LinkClick;
use Livewire\Component;

class ClicksByDenominations extends Component
{
    public function render()
    {
        // Get all denominations
        $denominations = Denomination::all();

        // Get click counts for each denomination
        $denominationsWithClicks = $denominations->map(function ($denomination) {
            $facebookClicks = LinkClick::where('denomination_id', $denomination->id)
                ->whereHas('link_type', function ($query) {
                    $query->where('name', 'facebook');
                })
                ->count();

            $youtubeClicks = LinkClick::where('denomination_id', $denomination->id)
                ->whereHas('link_type', function ($query) {
                    $query->where('name', 'youtube');
                })
                ->count();

            return [
                'denomination' => $denomination,
                'facebook_clicks' => $facebookClicks,
                'youtube_clicks' => $youtubeClicks,
                'total_clicks' => $facebookClicks + $youtubeClicks
            ];
        })->sortByDesc('total_clicks');

        return view('livewire.admin.analytics.clicks-by-denominations', [
            'denominationsWithClicks' => $denominationsWithClicks
        ]);
    }
}