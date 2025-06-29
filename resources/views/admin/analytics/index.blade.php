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
                    <input type="hidden" name="analytics_type" value="{{ $analyticsType }}">
                    <input type="hidden" name="analytics_id" value="{{ $analyticsId }}">
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

        <!-- Analytics Type Dropdown -->
        <div class="mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                   <h2 class="font-bold text-xl mb-4">Choose Analytics Type</h2>
            <div class="relative flex flex-col md:flex-row gap-4">
                <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-col md:flex-row gap-4 w-full" id="analyticsTypeForm">
                    <input type="hidden" name="from_date" value="{{ $fromDate }}">
                    <input type="hidden" name="to_date" value="{{ $toDate }}">
                    <input type="hidden" name="period" value="{{ $selectedPeriod }}">
                   <div class="flex flex-col">
                     <label for="analyticsType" class="block text-sm font-medium text-gray-700 mb-1">Analytics Type</label>
                    <select name="analytics_type" id="analyticsType" onchange="this.form.submit()"
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-md leading-tight focus:outline-none focus:ring-primary focus:border-primary">
                          <option value="" disabled>-- Select Analytics Type --</option>
                        <option value="denomination" {{ $analyticsType == 'denomination' ? 'selected' : '' }}>Denominations Analytics</option>
                        <option value="zone" {{ $analyticsType == 'zone' ? 'selected' : '' }}>Zones Analytics</option>
                    </select>
                   </div>

                    @if($analyticsType === 'denomination')
                      <div class="flex flex-col">
                        <label for="analyticsId" class=" text-sm font-medium text-gray-700 mb-1">Select Denomination</label>
                        <select name="analytics_id" id="analyticsId" onchange="this.form.submit()"
                            class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-md leading-tight focus:outline-none focus:ring-primary focus:border-primary">
                            <option value=""disabled >-- Select Denomination --</option>
                            @foreach($denominations as $denomination)
                                <option value="{{ $denomination->id }}" {{ $analyticsId == $denomination->id ? 'selected' : '' }}>{{ $denomination->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    @elseif($analyticsType === 'zone')
                      <div class="flex flex-col">
                        <label for="analyticsId" class="block text-sm font-medium text-gray-700 mb-1">Select Zone</label>
                        <select name="analytics_id" id="analyticsId" onchange="this.form.submit()"
                            class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-md leading-tight focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="" disabled>-- Select Zone --</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}" {{ $analyticsId == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    @endif
                </form>
            </div>
        </div>
        </div>

        <!-- Analytics Content Sections -->
        @if($showAnalytics && $analyticsType === 'denomination')
            <div id="denominationAnalytics" class="analytics-section">
                @include('admin.analytics.partials.denomination', [
                    'facebookClicks' => $facebookClicks,
                    'youtubeClicks' => $youtubeClicks,
                    'totalClicks' => $totalClicks,
                    'facebookChange' => $facebookChange,
                    'youtubeChange' => $youtubeChange,
                    'totalChange' => $totalChange,
                    'recentClicks' => $recentClicks,
                ])
            </div>
        @elseif($showAnalytics && $analyticsType === 'zone')
            <div id="zoneAnalytics" class="analytics-section">
                @include('admin.analytics.partials.zone', [
                    'facebookClicks' => $facebookClicks,
                    'youtubeClicks' => $youtubeClicks,
                    'totalClicks' => $totalClicks,
                    'facebookChange' => $facebookChange,
                    'youtubeChange' => $youtubeChange,
                    'totalChange' => $totalChange,
                    'recentClicks' => $recentClicks,
                ])
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
            const analyticsType = document.getElementById('analyticsType');
            const denominationSection = document.getElementById('denominationAnalytics');
            const zoneSection = document.getElementById('zoneAnalytics');

            // Handle analytics type selection
            analyticsType.addEventListener('change', function() {
                if (this.value === 'denomination') {
                    denominationSection.classList.remove('hidden');
                    zoneSection.classList.add('hidden');
                } else {
                    denominationSection.classList.add('hidden');
                    zoneSection.classList.remove('hidden');
                }
            });

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