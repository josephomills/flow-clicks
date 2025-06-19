<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denomination;
use App\Models\Link;
use App\Models\LinkType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index()
    {
        return view('admin.links.index');
    }
    public function create()
    {
        $denominations = Denomination::all();
        $link_types = LinkType::all();
        return view('admin.links.create', compact(['link_types', 'denominations']));
    }
    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'original_url' => 'required|url|max:2048',
                'link_type_id' => 'required|exists:link_types,id',
                'title' => 'nullable|string',
                'denominations' => 'nullable|array',
                'denominations.*' => 'exists:denominations,id'
            ]);

            $userId = auth()->id();
            $originalUrl = $validated['original_url'];
            $linkTypeId = $validated['link_type_id'];
            $title = $validated['title'] ?? null;
            $selectedDenominations = $validated['denominations'] ?? [];

            // Check for existing link with the same type
            if ($existingLink = $this->checkForExistingLink($userId, $originalUrl, $linkTypeId)) {
                return redirect()->back()
                    ->with('error', 'You already have a short link for this URL with the selected type')
                    ->with('existing_short_url', url('/' . $existingLink->short_url))
                    ->withInput();
            }

            // Create new link with type
            $link = $this->createNewShortLink($userId, $originalUrl, $linkTypeId, $title);

            // Get only the selected denominations
            $denominationsToReturn = empty($selectedDenominations)
                ? collect()
                : Denomination::whereIn('id', $selectedDenominations)->get();

            return redirect()->route('admin.links.create')
                ->with('success', 'Link created successfully!')
                ->with('short_url', url('/'. 'click/' . $link->short_url))
                ->with('selected_denominations', $denominationsToReturn) // Only selected denominations
                ->with('link_type', $link->link_type);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Link creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => auth()->id(),
                'url' => $request->original_url ?? null,
                'link_type_id' => $request->link_type_id ?? null
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create short link. Please try again.')
                ->withInput();
        }
    }

    public function edit($id){
        return view('admin.links.edit', [
            'link' => Link::findOrFail($id),
            'denominations' => Denomination::all(),
            'link_types' => LinkType::all()
        ]);
    }
    /**
     * Delete a short link
     */
    public function destroy($id)
    {
        try {
            $link = Link::findOrFail($id);

            // Authorization check - ensure user owns the link
            if ($link->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action');
            }

            $link->delete();

            return redirect()->route('admin.links.index')
                ->with('delete-success', 'Link deleted successfully!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Link not found for deletion: ' . $e->getMessage(), [
                'link_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.links.index')
                ->with('error', 'Link not found');

        } catch (\Exception $e) {
            // Only log and show error if it's NOT a redirect exception
            if (!$e instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
                Log::error('Link deletion failed: ' . $e->getMessage(), [
                    'exception' => $e,
                    'link_id' => $id,
                    'user_id' => auth()->id()
                ]);


                return redirect()->back()
                    ->with('error', 'Failed to delete link. Please try again.');
            }
            throw $e; // Re-throw redirect exceptions
        }
    }

    /**
     * Check if user already has a short link for this URL
     */
    protected function checkForExistingLink($userId, $originalUrl, $linkTypeId)
    {
        return Link::where('user_id', $userId)
            ->where('original_url', $originalUrl)
            ->where('link_type_id', $linkTypeId)
            ->first();
    }

    /**
     * Response when duplicate link is found
     */
    protected function existingLinkResponse($existingLink)
    {
        return redirect()->back()->with([
            'error' => 'You already have a short link for this URL',
            'existing_short_url' => url('/' . $existingLink->short_url),
            'original_url' => $existingLink->original_url
        ])->withInput();
    }

    /**
     * Create a new short link record
     */
    protected function createNewShortLink($userId, $originalUrl, $linkTypeId, $link_title)
    {
        $domain = parse_url($originalUrl, PHP_URL_HOST);
        if (!$domain) {
            throw new Exception('Could not parse URL domain');
        }
        if ($link_title) {
            $title = $link_title;
        } else {

            $title = str_replace('www.', '', $domain);
        }

        return Link::create([
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'short_url' => $this->generateUniqueShortCode(),
            'title' => $title,
            'description' => now()->toDateTimeString(),
            'is_custom' => false,
            'is_private' => false,
            'link_type_id' => $linkTypeId,
            'expires_at' => Carbon::now()->addDays(20),
            'clicks' => 0
        ]);
    }

    /**
     * Log link creation errors
     */
    protected function logLinkCreationError(Exception $e, Request $request)
    {
        Log::error('Link creation failed: ' . $e->getMessage(), [
            'exception' => $e,
            'user_id' => auth()->id(),
            'url' => $request->original_url ?? null
        ]);
    }

    /**
     * Generate a unique short code
     */
    protected function generateUniqueShortCode($length = 6)
    {
        $maxAttempts = 10;
        $attempts = 0;

        do {
            $shortCode = Str::random($length);
            $attempts++;

            if ($attempts > $maxAttempts) {
                throw new Exception('Failed to generate unique short code after ' . $maxAttempts . ' attempts');
            }

        } while (Link::where('short_url', $shortCode)->exists());

        return $shortCode;
    }
}
