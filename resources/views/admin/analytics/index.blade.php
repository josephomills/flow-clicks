@extends('layouts.admin')
@section('title', 'Analytics Dashboard')

@section('top-action')
    <a href="{{ url()->previous() }}"
        class="flex items-center text-sm bg-primary text-white py-3 px-4 rounded-md hover:bg-primary/80">
        <svg class="mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Go Back
    </a>
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Period Selection Form -->
        <div class="mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="font-bold text-xl mb-4">Choose Date Range</h2>

                <form method="GET" action="{{ route('admin.analytics.index') }}" class="space-y-4" id="dateRangeForm">

                    <!-- Custom Date Range -->
                    <div class="pt-4">
                          <div id="from_date_error" class="text-red-500 text-sm mt-1 hidden"></div>
                          <div id="to_date_error" class="text-red-500 text-sm mt-1 hidden"></div>
                        <div class="flex flex-col sm:flex-row gap-4 items-end">
                            <!-- From Date -->
                            <div class="flex-1">
                                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                <input type="date" name="from_date" id="from_date" value="{{ $fromDate ?? '' }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                              
                            </div>
                            
                            <!-- To Date -->
                            <div class="flex-1">
                                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                <input type="date" name="to_date" id="to_date" value="{{ $toDate ?? '' }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                
                            </div>
                            
                            <!-- Submit Button -->
                            <div>
                                <button type="submit" id="submitBtn"
                                    class="px-6 py-2 bg-primary text-white rounded-md hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                    Apply Range
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Current Range Display -->
                @if (request('from_date') && request('to_date'))
                    <div class="mt-4 p-3 bg-blue-50 rounded-md">
                        <p class="text-sm text-blue-700">
                            <strong>Current Range:</strong>
                            {{ \Carbon\Carbon::parse(request('from_date'))->format('M j, Y') }} -
                            {{ \Carbon\Carbon::parse(request('to_date'))->format('M j, Y') }}
                        </p>
                    </div>
                @else
                    <div class="mt-4 p-3 bg-blue-50 rounded-md">
                        <p class="text-sm text-blue-700">
                            <strong>Current Range:</strong> Last {{ request('period', 30) }} days
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="#" class="border-b-2 border-blue-500 py-2 px-1 text-sm font-medium text-blue-600">
                        Denominations Analytics
                    </a>
                    <a href="#"
                        class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
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
                                    <path
                                        d="M225.638355,208 L202.649232,208 C201.185673,208 200,206.813592 200,205.350603 L200,162.649211 C200,161.18585 201.185859,160 202.649232,160 L245.350955,160 C246.813955,160 248,161.18585 248,162.649211 L248,205.350603 C248,206.813778 246.813769,208 245.350955,208 L233.119305,208 L233.119305,189.411755 L239.358521,189.411755 L240.292755,182.167586 L233.119305,182.167586 L233.119305,177.542641 C233.119305,175.445287 233.701712,174.01601 236.70929,174.01601 L240.545311,174.014333 L240.545311,167.535091 C239.881886,167.446808 237.604784,167.24957 234.955552,167.24957 C229.424834,167.24957 225.638355,170.625526 225.638355,176.825209 L225.638355,182.167586 L219.383122,182.167586 L219.383122,189.411755 L225.638355,189.411755 L225.638355,208 L225.638355,208 Z">
                                    </path>
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
                        <svg class="w-8 h-8" width="800px" height="800px" viewBox="0 -3 20 20" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)"
                                    fill="#ff0000">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path
                                            d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289">
                                        </path>
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
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012-2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
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
                    {{ $totalChange >= 0 ? '+' : '' }}{{ number_format($totalChange, 1) }}% vs previous period
                </p>
            </div>

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
                $desktopPercentage =
                    $totalDeviceClicks > 0 ? round((($deviceData['Desktop'] ?? 0) / $totalDeviceClicks) * 100) : 0;
                $mobilePercentage =
                    $totalDeviceClicks > 0 ? round((($deviceData['Mobile'] ?? 0) / $totalDeviceClicks) * 100) : 0;
                $tabletPercentage =
                    $totalDeviceClicks > 0 ? round((($deviceData['Tablet'] ?? 0) / $totalDeviceClicks) * 100) : 0;
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

        <!-- Recent Clicks Table -->
        @if ($recentClicks->count() > 0)
            <div class="mt-8 bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Clicks</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Device Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    IP Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentClicks->take(10) as $click)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $click->device_type ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $click->platform ?? 'N/A' }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');
            const fromDateError = document.getElementById('from_date_error');
            const toDateError = document.getElementById('to_date_error');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('dateRangeForm');

            function validateDates() {
                const fromDate = fromDateInput.value;
                const toDate = toDateInput.value;
                
                // Clear previous errors
                fromDateError.classList.add('hidden');
                toDateError.classList.add('hidden');
                fromDateInput.classList.remove('border-red-500');
                toDateInput.classList.remove('border-red-500');

                let isValid = true;

                // Check if both dates are provided
                if (fromDate && toDate) {
                    const fromDateObj = new Date(fromDate);
                    const toDateObj = new Date(toDate);

                    // Check if to date is before from date
                    if (toDateObj < fromDateObj) {
                        toDateError.textContent = 'End date cannot be before start date';
                        toDateError.classList.remove('hidden');
                        toDateInput.classList.add('border-red-500');
                        isValid = false;
                    }
                }

                // Enable/disable submit button
                submitBtn.disabled = !isValid;
                if (!isValid) {
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.remove('hover:bg-primary/80');
                } else {
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.add('hover:bg-primary/80');
                }

                return isValid;
            }

            // Add event listeners for real-time validation
            fromDateInput.addEventListener('change', validateDates);
            toDateInput.addEventListener('change', validateDates);

            // Prevent form submission if validation fails
            form.addEventListener('submit', function(e) {
                if (!validateDates()) {
                    e.preventDefault();
                }
            });

            // Set max date for from_date when to_date changes
            toDateInput.addEventListener('change', function() {
                if (this.value) {
                    fromDateInput.setAttribute('max', this.value);
                }
            });

            // Set min date for to_date when from_date changes
            fromDateInput.addEventListener('change', function() {
                if (this.value) {
                    toDateInput.setAttribute('min', this.value);
                }
            });

            // Initial validation on page load
            validateDates();
        });
    </script>
@endsection