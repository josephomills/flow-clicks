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
    <div class="bg-background rounded-md border p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold">Analytics Overview</h2>
            <div class="flex items-center space-x-2">
                <select id="timePeriod" class="rounded-md border border-input bg-background px-3 py-1 text-sm">
                    <option value="7">Last 7 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="90">Last 90 days</option>
                    <option value="365">Last year</option>
                </select>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Facebook Clicks Card -->
            <div class="bg-card rounded-md border p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-muted-foreground">Facebook Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($facebookClicks) }}</h3>
                        <p class="text-xs {{ $facebookChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                            @if($facebookChange >= 0)
                                ↑ {{ number_format($facebookChange, 1) }}% from last period
                            @else
                                ↓ {{ number_format(abs($facebookChange), 1) }}% from last period
                            @endif
                        </p>
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

            <!-- YouTube Clicks Card -->
            <div class="bg-card rounded-md border p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-muted-foreground">YouTube Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($youtubeClicks) }}</h3>
                        <p class="text-xs {{ $youtubeChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                            @if($youtubeChange >= 0)
                                ↑ {{ number_format($youtubeChange, 1) }}% from last period
                            @else
                                ↓ {{ number_format(abs($youtubeChange), 1) }}% from last period
                            @endif
                        </p>
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

            <!-- Total Clicks Card -->
            <div class="bg-card rounded-md border p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-muted-foreground">Total Clicks</p>
                        <h3 class="text-2xl font-bold mt-1">{{ number_format($totalClicks) }}</h3>
                        <p class="text-xs {{ $totalChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1">
                            @if($totalChange >= 0)
                                ↑ {{ number_format($totalChange, 1) }}% from last period
                            @else
                                ↓ {{ number_format(abs($totalChange), 1) }}% from last period
                            @endif
                        </p>
                    </div>
                    <div class="bg-green-100 p-2 rounded-md">
                        <x-heroicon-s-chart-bar class="h-5 w-5 text-green-600" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Clicks Table -->
        <div class="bg-background rounded-md border p-6">
            @include('admin.analytics.partials.clicks-table', ['clicks' => $recentClicks])
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('timePeriod').addEventListener('change', function() {
            const period = this.value;
            window.location.href = "{{ route('admin.analytics') }}?period=" + period;
        });
    </script>
    @endpush
@endsection