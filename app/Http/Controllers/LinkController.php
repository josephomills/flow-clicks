<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Log;
use Exception;

class LinkController extends Controller
{


    public function index()
    {
        $links = Link::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.links', compact('links'));
    }
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
        ]);
        
        $userId = auth()->id();
        $originalUrl = $validated['original_url'];
        
        // Check for existing link for this user
        $existingLink = Link::where('user_id', $userId)
                          ->where('original_url', $originalUrl)
                          ->first();

        if ($existingLink) {
            return redirect()->back()->with([
                'error' => 'You already have a short link for this URL',
                'existing_short_url' => url('/'.$existingLink->short_url),
                'original_url' => $existingLink->original_url
            ])->withInput();
        }

        // Extract domain for title
        $domain = parse_url($originalUrl, PHP_URL_HOST);
        if (!$domain) {
            throw new Exception('Could not parse URL domain');
        }
        
        $title = str_replace('www.', '', $domain);

        // Generate link data
        $linkData = [
            'user_id' => $userId,
            'original_url' => $originalUrl,
            'short_url' => $this->generateUniqueShortCode(),
            'title' => $title,
            'description' => now()->toDateTimeString(),
            'is_custom' => false,
            'is_private' => false,
            'expires_at' => Carbon::now()->addDays(20),
            'clicks' => 0
        ];

        $link = Link::create($linkData);

        return redirect()->back()->with([
            'success' => 'Link shortened successfully!',
            'short_url' => url('/'.$link->short_url),
            'original_url' => $link->original_url
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e;
    } catch (Exception $e) {
        Log::error('Link creation failed: '.$e->getMessage(), [
            'exception' => $e,
            'user_id' => auth()->id(),
            'url' => $request->original_url ?? null
        ]);

        return redirect()->back()->with([
            'error' => 'Failed to create short link. Please try again.'
        ])->withInput();
    }
}

    protected function generateUniqueShortCode($length = 6)
    {
        try {
            $maxAttempts = 10;
            $attempts = 0;
            
            do {
                $shortCode = Str::random($length);
                $attempts++;
                
                if ($attempts > $maxAttempts) {
                    throw new Exception('Failed to generate unique short code after '.$maxAttempts.' attempts');
                }
                
            } while (Link::where('short_url', $shortCode)->exists());
            
            return $shortCode;
            
        } catch (Exception $e) {
            Log::error('Short code generation failed: '.$e->getMessage());
            dd('Short code generation failed: '.$e->getMessage());
            throw $e; // Re-throw to be caught by the main try-catch
        }
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->back()->with([
            'success' => 'Link deleted successfully!'
        ]);
    }

    public function update(Link $link, Request $request)
    {
        $validated = $request->validate([
            'short_url' => 'required|alpha_dash|min:3|max:32|unique:links,short_url',
        ]);

        $link->update([
            'short_url' => $validated['short_url'],
            'is_custom' => true
        ]);

        return redirect()->back()->with([
            'success' => 'Link updated successfully!'
        ]);
    }

    
}