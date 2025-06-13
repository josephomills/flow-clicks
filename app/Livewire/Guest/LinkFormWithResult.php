<?php

namespace App\Livewire\Guest;

use App\Models\Link;
use App\Models\Denomination;
use Illuminate\Support\Str;
use Livewire\Component;

class LinkFormWithResult extends Component
{
    public string $linkUrl = '';
    public ?Link $createdLink = null;

    public function submit()
    {
        $this->validate([
            'linkUrl' => 'required|url'
        ]);

        // Always assign to user ID 1
        $userId = 1;

        // Generate a unique short URL across ALL users
        do {
            $short = Str::random(6);
        } while (Link::where('short_url', $short)->exists());

        // Save the new link
        $this->createdLink = Link::create([
            'user_id' => $userId,
            'original_url' => $this->linkUrl,
            'short_url' => $short,
            'is_custom' => false,
            'is_private' => false,
        ]);
    }

    public function render()
    {
        $denominations = Denomination::all();
        return view('livewire.guest.link-form-with-result', [
            'denominations' => $denominations
        ]);
    }
}
