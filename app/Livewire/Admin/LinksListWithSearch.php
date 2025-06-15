<?php
namespace App\Livewire\Admin;

use App\Models\Link;
use App\Models\LinkType;
use App\Models\LinkGroup;
use Livewire\Component;
use Livewire\WithPagination;

class LinksListWithSearch extends Component
{
  use WithPagination;

  public $search = '';
  public $selectedType = '';
  public $selectedGroup = '';

  protected $queryString = ['search', 'selectedType', 'selectedGroup'];

  public function updatingSearch()
  {
    $this->resetPage();
  }

  public function updatingSelectedType()
  {
    $this->resetPage();
  }

  public function updatingSelectedGroup()
  {
    $this->resetPage();
  }

  public function render()
  {
    $domain = env('APP_URL'). '/click';
    $linkTypes = LinkType::all();
    $linkGroups = LinkGroup::where('user_id', auth()->id())->get();

    // Get links with filtering
    $linksQuery = Link::with(['link_type', 'link_group'])
      // ->where('user_id', auth()->id())
      ->when($this->search, function ($query) {
        $query->where(function ($q) {
          $q->where('short_url', 'like', '%' . $this->search . '%')
            ->orWhere('original_url', 'like', '%' . $this->search . '%')
            ->orWhere('title', 'like', '%' . $this->search . '%');
        });
      })
      ->when($this->selectedType, function ($query) {
        $query->where('link_type_id', $this->selectedType);
      })
      ->when($this->selectedGroup !== '', function ($query) {
        if ($this->selectedGroup === 'ungrouped') {
          $query->whereNull('link_group_id');
        } else {
          $query->where('link_group_id', $this->selectedGroup);
        }
      })
      ->orderBy('created_at', 'desc');

    $links = $linksQuery->paginate(20);

    // Group links by link_group for display
    $groupedLinks = $links->getCollection()->groupBy(function ($link) {
      return $link->link_group_id ?? 'ungrouped';
    });

    // Get group names for the grouped links
    $groupNames = [];
    foreach ($groupedLinks as $groupId => $groupLinks) {
      if ($groupId === 'ungrouped') {
        $groupNames[$groupId] = 'Ungrouped Links';
      } else {
        $group = LinkGroup::find($groupId);
        $groupNames[$groupId] = $group ? $group->name : 'Unknown Group';
      }
    }

    return view('livewire.admin.links-list-with-search', compact([
      'links',
      'linkTypes',
      'linkGroups',
      'domain',
      'groupedLinks',
      'groupNames'
    ]));
  }
}