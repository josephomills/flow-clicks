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
use Illuminate\Support\Facades\Log;

class CreateLinkForm extends Component
{
    public $title;
    public $original_url = '';
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
        'denominations' => 'nullable|array',
        'denominations.*' => 'exists:denominations,id',
    ];

    protected $messages = [
        'title.required' => 'The title field is required.',
        'original_url.required' => 'The URL field is required.',
        'original_url.url' => 'Please enter a valid URL.',
        'link_type_id.required' => 'Please select a link type.',
    ];

    public function mount()
    {
        $this->domain = env('APP_URL');
        // Don't set default denomination - let user choose explicitly
        $this->denominations = [];

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

            // If no denominations selected, create a single link without denomination
            if (empty($this->denominations)) {
                // Check if user already has a link for this URL without denomination
                $existingLink = Link::where('user_id', Auth::id())
                    ->where('original_url', $this->original_url)
                    ->whereNull('denomination_id')
                    ->first();

                if (!$existingLink) {
                    // Generate unique short URL for this user
                    $shortUrl = $this->generateUniqueShortUrl();

                    $link = Link::create([
                        'user_id' => Auth::id(),
                        'link_type_id' => $this->link_type_id,
                        'link_group_id' => $this->link_group->id,
                        'denomination_id' => null,
                        'original_url' => $this->original_url,
                        'short_url' => $shortUrl,
                        'title' => $this->title,
                        'description' => $this->description,
                    ]);

                    $this->created_links[] = [
                        'link' => $link,
                        'denomination' => null,
                        'full_url' => $this->domain . '/click/' . $shortUrl,
                    ];
                }
            } else {
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
                        'full_url' => $this->domain . '/click/' . $shortUrl . '/' . $denomination->slug,
                    ];
                }
            }

            DB::commit();

            if (empty($this->created_links)) {
                session()->flash('warning', 'Link already exists for this URL.');
                return;
            }

            session()->flash('success', 'Short links created successfully!');
             // Redirect to the analytics page of the created link group
            return redirect()->route('link-group.show', ['linkGroup' => $this->link_group->id]);

            // Show results instead of redirecting
            // $this->showResults = true;
        } catch (\Exception $e) {
            DB::rollBack();
           if(env('APP_ENV')=='local'){
             dd($e);
           }
            session()->flash('error', 'An error occurred while creating the links. Please try again.');
            Log::error('Link creation error: ' . $e->getMessage());
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

        // Reset denominations to empty - don't auto-select user's denomination
        $this->denominations = [];
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
            'availableDenominations' => Auth::user()->denominations,
            'linkTypes' => LinkType::all(),
        ]);
    }
}