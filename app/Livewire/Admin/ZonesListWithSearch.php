<?php

namespace App\Livewire\Admin;

use App\Models\Zone;
use Livewire\Component;

class ZonesListWithSearch extends Component
{
    public function render()
    {
        $zones = Zone::query()
            ->withCount('denominations') // Eager load clicks count
            
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserve filters in pagination links
        
        return view('livewire.admin.zones-list-with-search', compact(['zones']));
    }
}
