@extends('layouts.admin')

@section('title', 'Link Clicks')

@section('top-action')
@endsection

@section('content')
    <div class="">
        <!-- Top header with popup icon -->
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @elseif (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif

        <div class="m-0">
            <!-- Search and filters -->
            <div class="bg-background p-4 rounded-md border mb-6">
                <form method="GET" action="{{ route('admin.clicks') }}" id="searchForm">
                    <div class="flex flex-col gap-4">
                        <!-- Criteria Selection -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-48">
                                <label class="block text-sm font-medium mb-2">Search By:</label>
                                <select name="criteria" id="searchCriteria" class="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                                    <option value="">Select criteria...</option>
                                    <option value="denomination" {{ request('criteria') == 'denomination' ? 'selected' : '' }}>Denomination</option>
                                    <option value="date" {{ request('criteria') == 'date' ? 'selected' : '' }}>Date</option>
                                    <option value="device" {{ request('criteria') == 'device' ? 'selected' : '' }}>Device</option>
                                    <option value="country" {{ request('criteria') == 'country' ? 'selected' : '' }}>Country</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dynamic Search Section -->
                        <div id="searchSection" class="flex flex-col gap-4" style="{{ request('criteria') ? '' : 'display: none;' }}">
                            
                            <!-- Text Search Input -->
                            <div id="textSearch" class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-muted-foreground" />
                                </div>
                                <input 
                                    type="text" 
                                    name="search"
                                    id="searchInput"
                                    value="{{ request('search') }}"
                                    placeholder="Search..."
                                    class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2" 
                                />
                            </div>

                            <!-- Country Dropdown Options -->
                            <div id="countryOptions" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2" style="display: none;">
                                <label class="block text-sm font-medium mb-2 col-span-full">Or select from available countries:</label>
                                @foreach($countries as $country)
                                    <label class="flex items-center space-x-2 p-2 rounded border hover:bg-muted/50 cursor-pointer">
                                        <input type="radio" name="country_filter" value="{{ $country }}" 
                                               {{ request('country_filter') == $country ? 'checked' : '' }}
                                               class="text-primary">
                                        <span class="text-sm">{{ $country }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Device Dropdown Options -->
                            <div id="deviceOptions" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2" style="display: none;">
                                <label class="block text-sm font-medium mb-2 col-span-full">Or select from available devices:</label>
                                @foreach($devices as $device)
                                    <label class="flex items-center space-x-2 p-2 rounded border hover:bg-muted/50 cursor-pointer">
                                        <input type="radio" name="device_filter" value="{{ $device }}" 
                                               {{ request('device_filter') == $device ? 'checked' : '' }}
                                               class="text-primary">
                                        <span class="text-sm">{{ $device }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Denomination Dropdown Options -->
                            <div id="denominationOptions" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2" style="display: none;">
                                <label class="block text-sm font-medium mb-2 col-span-full">Or select from available denominations:</label>
                                @foreach($denominations as $denomination)
                                    <label class="flex items-center space-x-2 p-2 rounded border hover:bg-muted/50 cursor-pointer">
                                        <input type="radio" name="denomination_filter" value="{{ $denomination }}" 
                                               {{ request('denomination_filter') == $denomination ? 'checked' : '' }}
                                               class="text-primary">
                                        <span class="text-sm">{{ $denomination }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Search Actions -->
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-primary text-primary-foreground rounded-md hover:bg-primary/90">
                                    Search
                                </button>
                                @if(request()->hasAny(['search', 'criteria', 'country_filter', 'device_filter', 'denomination_filter']))
                                    <a href="{{ route('admin.clicks') }}" class="px-4 py-2 bg-muted text-muted-foreground rounded-md hover:bg-muted/80">
                                        Clear All
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if ($clicks->isEmpty())
                <!-- Empty state -->
                <div class="p-8 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-grey-200">
                        <x-heroicon-o-rectangle-group class="h-10 w-10 text-muted-foreground" />
                    </div>
                    <h3 class="mt-4 text-sm font-medium text-foreground">
                        {{ request()->hasAny(['search', 'criteria', 'country_filter', 'device_filter', 'denomination_filter']) ? 'No clicks found' : 'No clicks available' }}
                    </h3>
                    <p class="mt-1 text-sm text-muted-foreground">
                        {{ request()->hasAny(['search', 'criteria', 'country_filter', 'device_filter', 'denomination_filter']) ? 'Try adjusting your search criteria.' : 'Get started by creating one.' }}
                    </p>
                </div>
            @else
                <!-- Results info -->
                <div class="mb-4 text-sm text-muted-foreground">
                    Showing {{ $clicks->firstItem() }}-{{ $clicks->lastItem() }} of {{ $clicks->total() }} results
                    @if(request('search'))
                        for "{{ request('search') }}"
                    @endif
                    @if(request('criteria'))
                        in {{ ucfirst(request('criteria')) }}
                    @endif
                </div>

                <!-- Categories Table -->
                <div class="bg-background rounded-md border overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-muted/50">
                                <tr>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Link</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Date</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Link Type</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Denomination</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">IP</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Country</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Device</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Platform</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Browser</th>
                                    <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-sm">
                                @foreach ($clicks as $click)
                                    <tr class="hover:bg-muted/20">
                                        <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                                            <x-heroicon-o-globe-alt class="h-4 w-4 text-gray-500" />
                                            {{ $click->id }}
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->created_at->format('M d, Y H:i') }}</td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->link_type->name ?? 'None' }}</td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->denomination->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                                {{ $click->ip_address ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->country_code ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->device_type ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->platform ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-muted-foreground">{{ $click->browser ?? 'N/A' }}</td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center space-x-2">
                                                <!-- Edit -->
                                                <a href="{{ route('admin.clicks.edit', $click->id) }}"
                                                    class="p-1 rounded-md hover:bg-muted" title="Edit">
                                                    <x-heroicon-c-pencil class="h-4 w-4" />
                                                </a>

                                                <!-- Delete -->
                                                <form method="POST"
                                                    action="{{ route('admin.clicks.destroy', $click->id) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this link click?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 rounded-md hover:bg-muted text-red-500"
                                                        title="Delete">
                                                        <x-heroicon-o-trash class="h-4 w-4" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $clicks->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const criteriaSelect = document.getElementById('searchCriteria');
            const searchSection = document.getElementById('searchSection');
            const searchInput = document.getElementById('searchInput');
            const countryOptions = document.getElementById('countryOptions');
            const deviceOptions = document.getElementById('deviceOptions');
            const denominationOptions = document.getElementById('denominationOptions');

            function updateSearchInterface() {
                const selectedCriteria = criteriaSelect.value;
                
                if (selectedCriteria) {
                    searchSection.style.display = 'block';
                    
                    // Hide all option panels first
                    countryOptions.style.display = 'none';
                    deviceOptions.style.display = 'none';
                    denominationOptions.style.display = 'none';
                    
                    // Clear radio buttons from other categories
                    if (selectedCriteria !== 'country') {
                        document.querySelectorAll('input[name="country_filter"]').forEach(input => input.checked = false);
                    }
                    if (selectedCriteria !== 'device') {
                        document.querySelectorAll('input[name="device_filter"]').forEach(input => input.checked = false);
                    }
                    if (selectedCriteria !== 'denomination') {
                        document.querySelectorAll('input[name="denomination_filter"]').forEach(input => input.checked = false);
                    }
                    
                    // Update placeholder and show relevant options
                    switch (selectedCriteria) {
                        case 'denomination':
                            searchInput.placeholder = 'Search denomination names...';
                            denominationOptions.style.display = 'grid';
                            break;
                        case 'country':
                            searchInput.placeholder = 'Search country codes...';
                            countryOptions.style.display = 'grid';
                            break;
                        case 'device':
                            searchInput.placeholder = 'Search device types...';
                            deviceOptions.style.display = 'grid';
                            break;
                        case 'date':
                            searchInput.placeholder = 'Search dates (YYYY-MM-DD, YYYY-MM, or YYYY)...';
                            break;
                        default:
                            searchInput.placeholder = 'Search...';
                    }
                } else {
                    searchSection.style.display = 'none';
                }
            }

            // Initialize on page load
            updateSearchInterface();

            // Update when criteria changes
            criteriaSelect.addEventListener('change', function() {
                updateSearchInterface();
                // Clear search input when criteria changes
                searchInput.value = '';
            });

            // Auto-submit when radio button is selected
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Clear text search when radio is selected
                    searchInput.value = '';
                    // Submit form
                    document.getElementById('searchForm').submit();
                });
            });
        });
    </script>
@endsection