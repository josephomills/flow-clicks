<?php

namespace App\Livewire\Admin\Analytics;

use App\Models\LinkClick;
use Livewire\Component;

class ClicksByDate extends Component
{
    public function render()
    {
        $clicksByDate = LinkClick::selectRaw("DATE(created_at) as click_date, link_type_id")
            ->with('link_type')
            ->get()
            ->groupBy('click_date') // Use the aliased string field
            ->map(function ($clicks, $date) {
                $facebookClicks = $clicks->filter(fn ($click) => $click->link_type?->name === 'facebook')->count();
                $youtubeClicks = $clicks->filter(fn ($click) => $click->link_type?->name === 'youtube')->count();
                return [
                    'date' => $date,
                    'facebook_clicks' => $facebookClicks,
                    'youtube_clicks' => $youtubeClicks,
                    'total_clicks' => $facebookClicks + $youtubeClicks,
                ];
            })
            ->sortKeysDesc();

        return view('livewire.admin.analytics.clicks-by-date', [
            'clicksByDate' => $clicksByDate
        ]);
    }
}
