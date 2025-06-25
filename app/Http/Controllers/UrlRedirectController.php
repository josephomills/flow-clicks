<?php

namespace App\Http\Controllers;

use App\Models\Denomination;
use App\Models\Link;
use App\Models\LinkClick;
use Detection\MobileDetect;
use Illuminate\Http\Request;


class UrlRedirectController extends Controller
{
    protected function getIpLocation($ipAddress)
    {
        $response = @file_get_contents("https://ipinfo.io/{$ipAddress}/json");

        if ($response) {
            $data = json_decode($response, true);

            // Handle bogon/private IPs (like 127.0.0.1 or local network IPs)
            if (isset($data['bogon']) && $data['bogon']) {
                return [
                    'city' => 'Private IP',
                    'region' => null,
                    'country' => null,
                    'lat' => null,
                    'lon' => null,
                ];
            }

            // Get lat/lon from 'loc' field (e.g. "37.3860,-122.0838")
            $lat = null;
            $lon = null;
            if (!empty($data['loc'])) {
                [$lat, $lon] = explode(',', $data['loc']);
            }

            return [
                'city' => $data['city'] ?? null,
                'region' => $data['region'] ?? null,
                'country' => $data['country'] ?? null,
                'lat' => $lat,
                'lon' => $lon,
            ];
        }

        return null;
    }

    protected function getDeviceType() {
        $detect = new MobileDetect();
        // $detect->setUserAgent(request()->header('User-Agent'));
        
        if ($detect->isTablet()) {
            return 'Tablet';
        } elseif ($detect->isMobile()) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    public function index(string $short_url, string $denomination = null)
    {
        // dd($this->getIpLocation(request()->ip()));
        
        $identified_denomination = null;
        
        // Try to get the denomination only if it's provided
        if ($denomination) {
            $identified_denomination = Denomination::where('slug', $denomination)->first();
            
            // If denomination is provided but not found, show error
            if (!$identified_denomination) {
                return view('redirecter', ['message' => 'Unknown Denomination']);
            }
        }

        // Try to get the link
        $identified_link = Link::where('short_url', $short_url)->first();

        // If link is not found, show redirecter
        if (!$identified_link) {
            return view('redirecter', ['message' => 'Link Not Found']);
        }

        $currentIp = request()->ip();

        // Check if this IP has already clicked this specific link
        $existingClick = LinkClick::where('link_id', $identified_link->id)
            ->where('ip_address', $currentIp)
            ->first();

        // Only log the click and increment counter if it's a new IP for this link
        if (!$existingClick) {
            // Sample user agent string
            $userAgent = request()->header('User-Agent');
            // Regular expression to capture the OS part (platform)
            $patternOS = '/\(([^)]+)\)/';
            
            // Extract the OS part (e.g., "Windows NT 10.0; Win64; x64")
            preg_match($patternOS, $userAgent, $matchesOS);
            
            // Extract the browser part using a regular expression to match common browsers
            $patternBrowser = '/(Chrome|Firefox|Safari|Opera|MSIE|Trident|Edge|Edg)/i';  // Add more as needed
            preg_match($patternBrowser, $userAgent, $matchesBrowser);
            
            // Now, $matchesOS[1] contains the OS and version part, e.g., "Windows NT 10.0; Win64; x64"
            if (isset($matchesOS[1])) {
                // Clean up the OS string to just extract the main OS (e.g., "Windows NT 10.0")
                $osParts = explode(';', $matchesOS[1]);
                $os = trim($osParts[0]); // Get the first part (the OS with version)
            } else {
                $os = 'Unknown'; // If no OS part is found
            }
            
            // Extract the browser from the User-Agent
            $browser = isset($matchesBrowser[1]) ? $matchesBrowser[1] : 'Unknown';  // Default to 'Unknown' if no match
            
            // You can then store these values in the platform and browser columns
            $platform = $os;
            $browserInfo = $browser;
            
            // Log the click with the real platform and browser
            $newClick = [
                'link_id' => $identified_link->id,
                'denomination_id' => $identified_denomination ? $identified_denomination->id : NULL, // Handle null denomination
                'link_type_id' => $identified_link->link_type->id,
                'device_type' => $this->getDeviceType(),
                'ip_address' => $currentIp,
                'referrer' => request()->header('referer') ?? 'Unknown',
                'country_code' => $this->getIpLocation($currentIp)['country'] ?? 'Unknown',
                'platform' => $platform, // Real OS data
                'browser' => $browserInfo, // Real Browser data
                'lon' => 76,          // Stub
                'lat' => 54           // Stub
            ];
            
            LinkClick::create($newClick);

            // update the click count of the identified link
            $identified_link->clicks += 1;
            $identified_link->save();  // Explicit save required
        }

        // Always redirect to original URL regardless of whether click was logged
        return redirect()->to($identified_link->original_url);
    }
}