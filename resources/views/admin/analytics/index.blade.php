@extends('layouts.admin')
@section('title', 'Analytics Dashboard')

@section('top-action')
    <a href="{{ url()->previous() }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    {{-- <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
        <p class="text-gray-600 mt-2">Track the performance of your links</p>
    </div> --}}

    <!-- Period Selection -->
    <div class="mb-8">
        <div class="flex space-x-2">
            <a href="{{ route('admin.analytics.index', ['period' => 1]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium  {{ $selectedPeriod == 1 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Today
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 7]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium  {{ $selectedPeriod == 7 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Last 7 days
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 30]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium  {{ $selectedPeriod == 30 ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
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
                <a href="#" class="border-b-2 border-blue-500 py-2 px-1 text-sm font-medium text-blue-600">
                    Denominations Analytics
                </a>
                <a href="#" class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Zones Analytics
                </a>
            </nav>
        </div>
    </div>

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
                <div class="p-2 rounded-md">
                    <svg class="w-8 h-8 text-red-600" width="800px" height="800px" viewBox="0 -3 20 20" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000">
                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                    <path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Clicks -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Clicks</p>
                    <h3 class="text-2xl font-bold mt-1">{{ number_format($totalClicks) }}</h3>
                    
                </div>
                  <div class="bg-green-100 p-2 rounded-md">
                        <x-heroicon-s-chart-bar class="h-5 w-5 text-green-600" />
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
</div>
@endsection