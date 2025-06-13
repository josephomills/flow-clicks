<?php

namespace App\Livewire\User;

use App\Models\Link;
use Livewire\Component;

class DashboardRecentLinks extends Component
{

    public $recentLinks;

    public function mount()
    {
        // Fetch the 5 most recent links
        $this->recentLinks = Link::where('user_id', auth()->id())->latest()->take(5)->get();
    }
    public function render()
    {
        return view('livewire.user.dashboard-recent-links');
    }
}
