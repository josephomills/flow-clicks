<?php

namespace App\Livewire\Admin\Analytics;

use App\Models\Zone;
use App\Models\LinkClick;
use Livewire\Component;

class ClicksByZones extends Component
{
    public function render()
    {
        $zonesWithClicks = Zone::with('denominations')->get()->map(function ($zone) {
            $facebookClicks = 0;
            $youtubeClicks = 0;

            foreach ($zone->denominations as $denomination) {
                $facebookClicks += LinkClick::where('denomination_id', $denomination->id)
                    ->whereHas('link_type', function ($query) {
                        $query->where('name', 'facebook');
                    })
                    ->count();

                $youtubeClicks += LinkClick::where('denomination_id', $denomination->id)
                    ->whereHas('link_type', function ($query) {
                        $query->where('name', 'youtube');
                    })
                    ->count();
            }

            return [
                'zone' => $zone,
                'facebook_clicks' => $facebookClicks,
                'youtube_clicks' => $youtubeClicks,
                'total_clicks' => $facebookClicks + $youtubeClicks,
            ];
        })->sortByDesc('total_clicks');

        return view('livewire.admin.analytics.clicks-by-zones', [
            'zonesWithClicks' => $zonesWithClicks
        ]);
    }
}
