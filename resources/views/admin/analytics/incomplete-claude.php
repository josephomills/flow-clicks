@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Period Selection -->
    <div class="mb-8">
        <div class="flex space-x-2">
            <a href="{{ route('admin.analytics.index', ['period' => 1, 'tab' => request('tab', 'denominations')]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ $selectedPeriod == 1 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Today
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 7, 'tab' => request('tab', 'denominations')]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ $selectedPeriod == 7 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Last 7 days
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 30, 'tab' => request('tab', 'denominations')]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ $selectedPeriod == 30 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Last 30 days
            </a>
            <button class="px-6 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
                Custom
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('admin.analytics.index', ['period' => $selectedPeriod, 'tab' => 'denominations']) }}" 
                   class="border-b-2 py-2 px-1 text-sm font-medium {{ request('tab', 'denominations') == 'denominations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Denominations Analytics
                </a>
                <a href="{{ route('admin.analytics.index', ['period' => $selectedPeriod, 'tab' => 'zones']) }}" 
                   class="border-b-2 py-2 px-1 text-sm font-medium {{ request('tab') == 'zones' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Zones Analytics
                </a>
            </nav>
        </div>
    </div>

    @if(request('tab') == 'zones')
        <!-- Zone Analytics Content -->
        <!-- Zone Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Zones -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Zones</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $totalZones }}</h3>
                    </div>
                    <div class="p-2 rounded-md bg-blue-50">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Zones -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Active Zones</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $activeZones }}</h3>
                    </div>
                    <div class="p-2 rounded-md bg-green-50">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Zone Clicks -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Zone Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($totalZoneClicks) }}</h3>
                        <p class="text-sm {{ $zoneClicksChange >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            {{ $zoneClicksChange >= 0 ? '+' : '' }}{{ number_format($zoneClicksChange, 1) }}%
                        </p>
                    </div>
                    <div class="p-2 rounded-md bg-purple-50">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Avg Clicks per Zone -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Avg Clicks/Zone</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $avgClicksPerZone }}</h3>
                    </div>
                    <div class="p-2 rounded-md bg-indigo-50">
                        <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Zones -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top Performing Zones</h3>
                <div class="text-sm text-gray-500">Last {{ $selectedPeriod }} days</div>
            </div>
            
            @if(count($topZones) > 0)
                <div class="space-y-4">
                    @foreach($topZones as $index => $zone)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : ($index == 1 ? 'bg-gray-100 text-gray-800' : ($index == 2 ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $zone->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $zone->description ?? 'No description' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($zone->clicks_count) }} clicks</div>
                                <div class="text-sm text-gray-500">
                                    {{ $totalZoneClicks > 0 ? number_format(($zone->clicks_count / $totalZoneClicks) * 100, 1) : 0 }}% of total
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 mb-2">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-gray-500">No zone data available</h3>
                    <p class="text-sm text-gray-400 mt-1">Zone analytics will appear here once you have zones with clicks.</p>
                </div>
            @endif
        </div>

        <!-- Zone Performance Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Zone Performance Distribution</h3>
            </div>
            
            @if(count($topZones) > 0)
                <div class="space-y-3">
                    @foreach($topZones->take(5) as $zone)
                        @php
                            $percentage = $totalZoneClicks > 0 ? ($zone->clicks_count / $totalZoneClicks) * 100 : 0;
                            $colors = ['bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-red-500'];
                            $color = $colors[$loop->index % count($colors)];
                        @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 flex-1">
                                <div class="w-4 h-4 {{ $color }} rounded"></div>
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $zone->name }}</span>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $color }} h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            <div class="text-right min-w-0">
                                <span class="text-sm font-medium text-gray-900">{{ number_format($zone->clicks_count) }}</span>
                                <span class="text-xs text-gray-500 ml-1">({{ number_format($percentage, 1) }}%)</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400">No performance data available</div>
                </div>
            @endif
        </div>

        <!-- Zone Details Table -->
        @if(count($zoneDetails) > 0)
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Zone Details</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Clicks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facebook Clicks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">YouTube Clicks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($zoneDetails as $zone)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $zone->name }}</div>
                                @if($zone->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($zone->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $zone->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $zone->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($zone->total_clicks ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($zone->facebook_clicks ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($zone->youtube_clicks ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $zone->last_activity ? $zone->last_activity->format('M j, Y') : 'No activity' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    @else
        <!-- Original Denominations Analytics Content -->
        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Facebook Clicks -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Facebook Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($facebookClicks) }}</h3>
                    </div>
                    <div class="p-2 rounded-md">
                        <svg class="w-8 h-8" width="800px" height="800px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Color-" transform="translate(-200.000000, -160.000000)" fill="#4460A0">
                                    <path d="M225.638355,208 L202.649232,208 C201.185673,208 200,206.813592 200,205.350603 L200,162.649211 C200,161.18585 201.185859,160 202.649232,160 L245.350955,160 C246.813955,160 248,161.18585 248,162.649211 L248,205.350603 C248,206.813778 246.813769,208 245.350955,208 L233.119305,208 L233.119305,189.411755 L239.358521,189.411755 L240.292755,182.167586 L233.119305,182.167586 L233.119305,177.542641 C233.119305,175.445287 233.701712,174.01601 236.70929,174.01601 L240.545311,174.014333 L240.545311,167.535091 C239.881886,167.446808 237.604784,167.24957 234.955552,167.24957 C229.424834,167.24957 225.638355,170.625526 225.638355,176.825209 L225.638355,182.167586 L219.383122,182.167586 L219.383122,189.411755 L225.638355,189.411755 L225.638355,208 L225.638355,208 Z"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- YouTube Clicks -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">YouTube Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($youtubeClicks) }}</h3>
                    </div>
                    <x-youtube-icon/>
                </div>
            </div>

            <!-- Total Clicks -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Total Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($totalClicks) }}</h3>
                    </div>
                    <div class="p-2 rounded-md">
                        <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clicks by Device Type (Detailed) -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Clicks by Device Type</h3>
            </div>
            <div class="mb-4">
                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalClicks) }}</p>
                <p class="text-sm {{ $totalChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Today {{ $totalChange >= 0 ? '+' : '' }}{{ number_format($totalChange, 1) }}%
                </p>
            </div>
            
            @php
                $deviceData = [];
                foreach($recentClicks as $click) {
                    $deviceType = 'Unknown';
                    if(stripos($click->device_type, 'mobile') !== false) {
                        $deviceType = 'Mobile';
                    } elseif(stripos($click->device_type, 'desktop') !== false) {
                        $deviceType = 'Desktop';
                    } elseif(stripos($click->device_type, 'tablet') !== false) {
                        $deviceType = 'Tablet';
                    }
                    
                    if(!isset($deviceData[$deviceType])) {
                        $deviceData[$deviceType] = 0;
                    }
                    $deviceData[$deviceType]++;
                }
                
                $totalDeviceClicks = array_sum($deviceData);
                $desktopPercentage = $totalDeviceClicks > 0 ? round(($deviceData['Desktop'] ?? 0) / $totalDeviceClicks * 100) : 0;
                $mobilePercentage = $totalDeviceClicks > 0 ? round(($deviceData['Mobile'] ?? 0) / $totalDeviceClicks * 100) : 0;
                $tabletPercentage = $totalDeviceClicks > 0 ? round(($deviceData['Tablet'] ?? 0) / $totalDeviceClicks * 100) : 0;
            @endphp
            
            <div class="space-y-4">
                <!-- Desktop -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-blue-500 rounded"></div>
                        <span class="text-sm font-medium text-gray-700">Desktop</span>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $desktopPercentage }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $desktopPercentage }}%</span>
                </div>
                
                <!-- Mobile -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <span class="text-sm font-medium text-gray-700">Mobile</span>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $mobilePercentage }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $mobilePercentage }}%</span>
                </div>
                
                <!-- Tablet -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                        <span class="text-sm font-medium text-gray-700">Tablet</span>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $tabletPercentage }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $tabletPercentage }}%</span>
                </div>
            </div>
        </div>

        <!-- Recent Clicks Table (Optional) -->
        @if($recentClicks->count() > 0)
        <div class="mt-8 bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Clicks</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentClicks->take(10) as $click)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $click->device_type ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $click->ip_address ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $click->created_at->format('M j, Y g:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection