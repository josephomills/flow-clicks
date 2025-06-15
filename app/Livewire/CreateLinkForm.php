<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\LinkType;
use App\Models\Link;
use App\Models\LinkGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateLinkForm extends Component
{
    public $title;
    public $original_url = 'https://';
    public $description;
    public $denominations = [];
    public $link_type_id;
    public $created_links = [];
    public $link_group;
    public $showResults = false;
    public $domain;
    


    protected $rules = [
        'title' => 'required|string|max:255',
        'original_url' => 'required|url',
        'description' => 'nullable|string|max:1000',
        'link_type_id' => 'required|exists:link_types,id',
        'denominations' => 'required|array|min:1',
        'denominations.*' => 'exists:denominations,id',
    ];

    protected $messages = [
        'title.required' => 'The title field is required.',
        'original_url.required' => 'The URL field is required.',
        'original_url.url' => 'Please enter a valid URL.',
        'link_type_id.required' => 'Please select a link type.',
        'denominations.required' => 'Please select at least one denomination.',
        'denominations.min' => 'Please select at least one denomination.',
    ];

    public function mount()
    {
         $this->domain = env('APP_URL');
        // Set default denomination if user has one
        if (Auth::user()->denomination_id) {
            $this->denominations = [Auth::user()->denomination_id];
        }

        // Set default link type to first available
        $firstLinkType = LinkType::first();
        if ($firstLinkType) {
            $this->link_type_id = $firstLinkType->id;
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create link group
            $this->link_group = LinkGroup::create([
                'user_id' => Auth::id(),
                'name' => $this->title,
                'original_url' => $this->original_url,
                'description' => $this->description,
            ]);

            $this->created_links = [];

            // Create individual links for each selected denomination
            foreach ($this->denominations as $denominationId) {
                $denomination = Denomination::find($denominationId);

                // Check if user already has a link for this URL and denomination
                $existingLink = Link::where('user_id', Auth::id())
                    ->where('original_url', $this->original_url)
                    ->where('denomination_id', $denominationId)
                    ->first();

                if ($existingLink) {
                    // Skip if link already exists for this denomination
                    continue;
                }

                // Generate unique short URL for this user
                $shortUrl = $this->generateUniqueShortUrl();

                $link = Link::create([
                    'user_id' => Auth::id(),
                    'link_type_id' => $this->link_type_id,
                    'link_group_id' => $this->link_group->id,
                    'denomination_id' => $denominationId,
                    'original_url' => $this->original_url,
                    'short_url' => $shortUrl,
                    'title' => $this->title,
                    'description' => $this->description,
                ]);

                $this->created_links[] = [
                    'link' => $link,
                    'denomination' => $denomination,
                    'full_url' => $this->domain . '/click/' . $shortUrl . '/'. Denomination::find($denominationId)->slug,
                ];
            }

            DB::commit();

            if (empty($this->created_links)) {
                session()->flash('warning', 'All selected denominations already have links for this URL.');
                return;
            }

            $this->showResults = true;
            session()->flash('success', 'Short links created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            session()->flash('error', 'An error occurred while creating the links. Please try again.');
            \Log::error('Link creation error: ' . $e->getMessage());
        }
    }

    private function generateUniqueShortUrl($length = 6)
    {
        $userId = Auth::id();

        do {
            $shortCode = Str::random($length);
            $shortUrl = $shortCode;
        } while (Link::where('user_id', $userId)->where('short_url', $shortUrl)->exists());

        return $shortUrl;
    }

    public function createAnother()
    {
        $this->reset([
            'title',
            'original_url',
            'description',
            'created_links',
            'link_group',
            'showResults'
        ]);

        $this->original_url = 'https://';

        // Reset to user's default denomination
        if (Auth::user()->denomination_id) {
            $this->denominations = [Auth::user()->denomination_id];
        } else {
            $this->denominations = [];
        }
    }

    public function copyToClipboard($url)
    {
        $this->dispatch('copy-to-clipboard', $url);
        session()->flash('copied', 'Link copied to clipboard!');
    }

    public function deleteLink($linkId)
    {
        try {
            $link = Link::where('id', $linkId)
                ->where('user_id', Auth::id())
                ->first();

            if ($link) {
                $link->delete();

                // Remove from created_links array
                $this->created_links = array_filter($this->created_links, function ($item) use ($linkId) {
                    return $item['link']->id !== $linkId;
                });

                // If no more links in group, delete the group
                if (empty($this->created_links) && $this->link_group) {
                    $remainingLinks = Link::where('link_group_id', $this->link_group->id)->count();
                    if ($remainingLinks === 0) {
                        $this->link_group->delete();
                        $this->showResults = false;
                    }
                }

                session()->flash('success', 'Link deleted successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete link.');
        }
    }

    public function getDenominationName($denominationId)
    {
        return Denomination::find($denominationId)?->name ?? 'Unknown';
    }

    public function render()
    {
        return view('livewire.create-link-form', [
            'availableDenominations' => Denomination::all(),
            'linkTypes' => LinkType::all(),
        ]);
    }
}