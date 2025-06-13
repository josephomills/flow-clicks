<?php
namespace App\Livewire\Landing;

use App\Models\Denomination;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class NewLinkWithResultsSection extends Component
{
    public $linkUrl = 'https://';
    public $isSubmitted = false;
    public $generatedLinks = [];
    public $error = null;
    public $success = null;
    public $baseShortCode = null;

    public function processLink()
    {
        try {
            $this->validate([
                'linkUrl' => 'required|url|max:2048'
            ]);

            $userId = Auth::id() ?? 1; // Fallback to 1 if not authenticated (adjust as needed)

            // Check for existing link for this user
            $existingLink = Link::where('user_id', $userId)
                ->where('original_url', $this->linkUrl)
                ->first();

            if ($existingLink) {
                $this->error = 'You already have a short link for this URL';
                $this->generatedLinks = [
                    [
                        'denomination' => 'Default',
                        'link' => url('/' . $existingLink->short_url),
                    ]
                ];
                $this->isSubmitted = true;
                return;
            }

            // Extract domain for title
            $domain = parse_url($this->linkUrl, PHP_URL_HOST);
            if (!$domain) {
                throw new \Exception('Could not parse URL domain');
            }

            $title = str_replace('www.', '', $domain);

            // Generate base short code
            $this->baseShortCode = $this->generateUniqueShortCode();

            // Create the base link
            Link::create([
                'user_id' => $userId,
                'original_url' => $this->linkUrl,
                'short_url' => $this->baseShortCode,
                'title' => $title,
                'description' => now()->toDateTimeString(),
                'is_custom' => false,
                'is_private' => false,
                'expires_at' => Carbon::now()->addDays(20),
                'clicks' => 0
            ]);

            $this->success = 'Base link created successfully!';
            $this->isSubmitted = true;
            $this->error = null;

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Link creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'url' => $this->linkUrl
            ]);

            $this->error = 'Failed to create short link. Please try again.';
            $this->isSubmitted = false;
        }
    }

    public function addCustomSlug($slug)
    {
        if (!$this->baseShortCode)
            return;

        $denomination = Denomination::where('slug', $slug)->first();
        if (!$denomination)
            return;

        // Create the custom link with denomination
        $customShortUrl = $this->baseShortCode . '/' . $slug;


        // Add to generated links for display
       

        $this->generatedLinks[] = [
            'denomination' => $denomination->name,
            'link' => 'https://click.localhost/' . $customShortUrl, // Build dynamic subdomain and custom URL
        ];
    }

    protected function generateUniqueShortCode()
    {
        do {
            $code = Str::random(6);
        } while (Link::where('short_url', $code)->exists());

        return $code;
    }

    public function render()
    {
        $denominations = Denomination::all();
        return view('livewire.landing.new-link-with-results-section', compact('denominations'));
    }
}