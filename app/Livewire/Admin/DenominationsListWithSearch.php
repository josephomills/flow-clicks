<?php

namespace App\Livewire\Admin;

use App\Models\Denomination;
use Livewire\Component;

class DenominationsListWithSearch extends Component
{
    
    public function render()
    {
        $denominations = Denomination::query()
            ->withCount('clicks') // Eager load clicks count
            
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserve filters in pagination links
        
        return view('livewire.admin.denominations-list-with-search', compact(['denominations']));
    }
}
