<?php

namespace App\Livewire\Admin;

use App\Models\Link;
use Livewire\Component;

class DashboardRecentLinks extends Component
{

    public $recentLinks;

    public function mount()
    {
        // Fetch the 5 most recent links
        $this->recentLinks = Link::latest()->take(5)->get();
    }
    public function render()
    {
        return view('livewire.admin.dashboard-recent-links');
    }
}
