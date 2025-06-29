@php
    $deviceData = [];
    foreach ($recentClicks as $click) {
        $deviceType = 'Unknown';
        if (stripos($click->device_type, 'mobile') !== false) {
            $deviceType = 'Mobile';
        } elseif (stripos($click->device_type, 'desktop') !== false) {
            $deviceType = 'Desktop';
        } elseif (stripos($click->device_type, 'tablet') !== false) {
            $deviceType = 'Tablet';
        }
        if (!isset($deviceData[$deviceType])) {
            $deviceData[$deviceType] = 0;
        }
        $deviceData[$deviceType]++;
    }
    $totalDeviceClicks = array_sum($deviceData);
    $desktopPercentage = $totalDeviceClicks > 0 ? round((($deviceData['Desktop'] ?? 0) / $totalDeviceClicks) * 100) : 0;
    $mobilePercentage = $totalDeviceClicks > 0 ? round((($deviceData['Mobile'] ?? 0) / $totalDeviceClicks) * 100) : 0;
    $tabletPercentage = $totalDeviceClicks > 0 ? round((($deviceData['Tablet'] ?? 0) / $totalDeviceClicks) * 100) : 0;
@endphp
<div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Clicks by Device Type</h3>
    </div>
    <div class="mb-6">
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalClicks) }}</p>
        <p class="text-sm {{ $totalChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $totalChange >= 0 ? '+' : '' }}{{ number_format($totalChange, 1) }}% vs previous period
        </p>
    </div>
    <div class="space-y-6">
        <!-- Desktop -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 w-24">
                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H8v2h8v-2h-2v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/></svg>
                <span class="text-sm font-medium text-gray-700">Desktop</span>
            </div>
            <div class="flex-1 mx-6 max-w-xs">
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-500 h-4 rounded-full transition-all duration-300 ease-in-out" style="width: {{ $desktopPercentage }}%"></div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $desktopPercentage }}%</span>
                <span class="text-sm text-gray-500 w-16 text-right">{{ number_format($deviceData['Desktop'] ?? 0) }} clicks</span>
            </div>
        </div>
        <!-- Mobile -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 w-24">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M15.5 1h-8A2.5 2.5 0 0 0 5 3.5v17A2.5 2.5 0 0 0 7.5 23h8a2.5 2.5 0 0 0 2.5-2.5v-17A2.5 2.5 0 0 0 15.5 1zm-4 21c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4.5-4H7V4h9v14z"/></svg>
                <span class="text-sm font-medium text-gray-700">Mobile</span>
            </div>
            <div class="flex-1 mx-6 max-w-xs">
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-green-500 h-4 rounded-full transition-all duration-300 ease-in-out" style="width: {{ $mobilePercentage }}%"></div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $mobilePercentage }}%</span>
                <span class="text-sm text-gray-500 w-16 text-right">{{ number_format($deviceData['Mobile'] ?? 0) }} clicks</span>
            </div>
        </div>
        <!-- Tablet -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 w-24">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 16c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm3-4H7V5h10v10z"/></svg>
                <span class="text-sm font-medium text-gray-700">Tablet</span>
            </div>
            <div class="flex-1 mx-6 max-w-xs">
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-yellow-500 h-4 rounded-full transition-all duration-300 ease-in-out" style="width: {{ $tabletPercentage }}%"></div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $tabletPercentage }}%</span>
                <span class="text-sm text-gray-500 w-16 text-right">{{ number_format($deviceData['Tablet'] ?? 0) }} clicks</span>
            </div>
        </div>
    </div>
</div>
