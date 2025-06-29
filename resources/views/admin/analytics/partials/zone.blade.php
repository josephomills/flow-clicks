@php
    // Use the same device breakdown and analytics cards as before, but for zones
@endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Facebook Clicks -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Facebook Clicks</p>
                <h3 class="text-2xl font-bold mt-1">{{ number_format($facebookClicks) }}</h3>
            </div>
            <div class="p-2 rounded-md">
                <!-- Facebook Icon -->
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
                <!-- YouTube Icon -->
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
                <!-- Total Icon -->
            </div>
        </div>
    </div>
</div>
@include('admin.analytics.partials.device_breakdown', ['recentClicks' => $recentClicks, 'totalClicks' => $totalClicks, 'totalChange' => $totalChange])
