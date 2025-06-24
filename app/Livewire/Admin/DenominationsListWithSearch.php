<?php

namespace App\Livewire\Admin;

use App\Models\Denomination;
use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class DenominationsListWithSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $zoneFilter = '';
    public $zones;

    public function mount()
    {
        $this->zones = Zone::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingZoneFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $denominations = Denomination::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->when($this->zoneFilter, function ($query) {
                $query->where('zone_id', $this->zoneFilter);
            })
            ->with('zone')
            ->withCount('clicks')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('livewire.admin.denominations-list-with-search', [
            'denominations' => $denominations,
            'zones' => $this->zones
        ]);
    }
}