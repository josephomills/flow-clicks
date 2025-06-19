<?php

namespace App\Livewire;

use App\Models\Link;
use App\Models\LinkGroup;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LinkGroupList extends Component
{
    public $linkGroups = [];

    public function mount()
    {
        $user = Auth::user();
        if ($user->can('viewAny', LinkGroup::class)) {
            $this->linkGroups = LinkGroup::with('user', 'links', 'links.denomination')->get();
        } else {
            $this->linkGroups = LinkGroup::with('user', 'links', 'links.denomination')
                ->where('user_id', $user->id)
                ->get();
        }
    }

    public function confirmDelete($linkId)
    {
        $link = Link::findOrFail($linkId);
        // Optional: Authorization check
       
        $link->delete();
        // Refresh the list
        $this->mount(); // reload groups
    }

    public function confirmDeleteGroup($groupId)
    {
        $group = LinkGroup::findOrFail($groupId);
        // Optional: Authorization check
       
        $group->delete();
        // Refresh the list
        $this->mount(); // reload groups
    }

    public function getShareData($linkId)
    {
        $link = Link::findOrFail($linkId);
        $shareUrl = env('APP_URL') . '/click/' . $link->short_url . ($link->denomination ? '/' . $link->denomination->slug : '');
        
        return [
            'title' => $link->title ?? 'Shared Link',
            'url' => $shareUrl,
            'text' => 'Check out this link: ' . ($link->title ?? 'Shared Link')
        ];
    }

    public function render()
    {
        return view('livewire.link-group-list', [
            'linkGroups' => $this->linkGroups,
        ]);
    }
}