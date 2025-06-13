<?php

namespace App\Livewire\User;

use App\Models\Link;
use App\Models\LinkType;
use Livewire\Component;

class LinksListWithSearch extends Component
{
    public $search = '';
      // The short domain as a property
      public function render()
      
      {
        $shortDomain = 'http://click.localhost:8000';
        $linkTypes = LinkType::all();
        $links = Link::where('user_id', auth()->id())
        ->when($this->search, function ($query) {
            $query->where('short_url', 'like', '%'.$this->search.'%')
                  ->orWhere('original_url', 'like', '%'.$this->search.'%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('livewire.user.links-list-with-search', compact(['links', 'linkTypes', 'shortDomain']));
    }
}
