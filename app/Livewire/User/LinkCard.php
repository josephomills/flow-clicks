<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Link;

class LinkCard extends Component
{
    public Link $link;
    public bool $editing = false;
    public string $editedShortCode = '';
    public bool $copied = false;

    protected $rules = [
        'editedShortCode' => 'required|alpha_dash|min:3|max:32|unique:links,short_url',
    ];

    public function mount()
    {
        $this->editedShortCode = $this->link->short_url;
    }

    public function editLink()
    {
        $this->editing = true;
    }

    public function saveLink()
    {
        $this->validate();

        $this->link->update([
            'short_url' => $this->editedShortCode,
            'is_custom' => true
        ]);

        $this->editing = false;
        $this->dispatch('link-updated');
    }

    public function deleteLink()
    {
        $this->link->delete();
        $this->dispatch('link-deleted');
    }
    public function cancelEdit()
    {
        $this->editing = false;
        $this->editedShortCode = $this->link->short_url;
    }

    public function copyToClipboard()
    {
        $this->copied = true;
        $this->dispatch('copied-to-clipboard', content: url('/'.$this->link->short_url));
        sleep(2);
        $this->copied = false;
    }

    public function render()
    {
        return view('livewire.user.link-card');
    }
}