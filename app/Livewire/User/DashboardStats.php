<?php

namespace App\Livewire\User;

use App\Models\Denomination;
use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        // Count of links where user_id is the authenticated user
        $linksCount = Link::where('user_id', auth()->id())->count();

        // Count of clicks where denomination_id matches the auth user's denomination
        $clicksCount = LinkClick::where('denomination_id', auth()->user()->denomination_id)->count();

        return view('livewire.user.dashboard-stats', compact(
            ['linksCount', 'clicksCount']
        ));
    }
}
