<?php

namespace App\Livewire\Admin;

use App\Models\Denomination;
use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Livewire\Component;

class DashboardStats extends Component
{

    public function render()
    {
        $linksCount = Link::all()->count();
        $clicksCount = LinkClick::all()->count();
        $registeredUsersCount = User::all()->count();
        $denominationsCount = Denomination::all()->count();
        return view('livewire.admin.dashboard-stats', compact(
            ['linksCount', 'clicksCount', 'registeredUsersCount', 'denominationsCount']));
    }
}
