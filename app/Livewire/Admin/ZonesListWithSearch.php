<?php

namespace App\Livewire\Admin;

use App\Models\Zone;
use Livewire\Component;
use Livewire\WithPagination;

class ZonesListWithSearch extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search']; // to preserve search term in query string

    public function updatingSearch()
    {
        // dd('Search term updated:', $this->search);
        $this->resetPage(); // Reset to first page when search 

    }

    public function render()
    {

        logger()->debug('Searching for:', ['term' => $this->search]);
        $zones = Zone::query()
            ->withCount('denominations')
            ->when(
                $this->search,
                fn($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhere('country', 'like', '%' . $this->search . '%')
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('livewire.admin.zones-list-with-search', compact('zones'));
    }
}
