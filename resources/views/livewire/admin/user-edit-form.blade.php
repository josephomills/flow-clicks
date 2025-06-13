<div>
    <div class="mb-6">
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @elseif (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif
    </div>
    <form wire:submit.prevent="save" class="flex space-x-6">
        <div class="flex flex-col gap-6 mb-6 bg-background rounded-md border p-6 w-full max-w-md">

            {{-- User ID field --}}
            {{-- First Name field --}}
            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium">
                    First Name
                </label>
                <input type="text" id="first_name" wire:model.defer="first_name"
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                    required placeholder="e.g. Enter First Name..." />
                @error('first_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Last Name field --}}
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium">
                    Last Name
                </label>
                <input type="text" id="last_name" wire:model.defer="last_name"
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                    required placeholder="e.g. Enter Last Name..." />
                @error('last_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email field --}}
            <div>
                <label for="email" class="block mb-2 text-sm font-medium">
                    Email
                </label>
                <input type="email" id="email" wire:model.defer="email"
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                    required placeholder="e.g. Enter Email..." />
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Primary Denomination field --}}
            <div>
                <label for="denomination" class="block mb-2 text-sm font-medium">
                    Primary Denomination
                </label>
                <select id="denomination" wire:model.defer="denomination"
    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required>
    <option value="">Select a denomination</option>
    @foreach ($denominations as $denomination)
        <option value="{{ $denomination->id }}"
            {{ optional($user->defaultDenomination)->id == $denomination->id ? 'selected' : '' }}>
            {{ $denomination->name }}
        </option>
    @endforeach
</select>

                @error('denomination')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Is Admin Toggle --}}
<div class="mb-4">
    <label for="is_admin" class="block mb-2 text-sm font-medium text-gray-700">
        Is Admin
    </label>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" id="is_admin" wire:model="role" class="sr-only peer">
        <div
            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
        </div>
        <span class="ml-3 text-sm font-medium text-gray-900">
            {{ $role ? 'Yes' : 'No' }}
        </span>
    </label>
</div>
        </div>

        {{-- Multi-Select Denominations Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6 w-full max-w-md">
    <h1 class="text-xl font-semibold text-gray-800 mb-4">Assign Denominations</h1>

    {{-- Selected Denominations Pills --}}
    @if (!empty($assigned_denominations))
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <label class="block text-sm font-medium text-gray-700 mb-2">Selected Denominations</label>
                @if (!empty($assigned_denomination_names))
                    <button type="button" wire:click="clearAllDenominations"
                        class="text-xs text-red-600 hover:text-red-800 font-medium">
                        Clear All
                    </button>
                @endif
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach ($assigned_denomination_names as $id => $name)
                    <span
                        class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $name }}
                        <button type="button" wire:click="removeDenomination({{ $id }})"
                            class="ml-2 text-blue-600 hover:text-blue-800 font-bold">
                            &times;
                        </button>
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Multi-Select Search Component --}}
    <div class="relative" x-data="{ open: @entangle('show_dropdown') }">
        <label class="block text-sm font-medium text-gray-700 mb-2">Search & Select Denominations</label>

        {{-- Search Input --}}
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="denomination_search" wire:focus="showDropdown"
                placeholder="Search denominations..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

            {{-- Clear button --}}
            @if ($denomination_search)
                <button type="button" wire:click="clearSearch"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            @endif
        </div>

        {{-- Dropdown Results --}}
        @if ($show_dropdown && !empty($search_results))
            <div
                class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                {{-- Select All option --}}
                <div wire:click="selectAllVisible"
                    class="px-4 py-2 hover:bg-gray-50 cursor-pointer flex items-center justify-between border-b border-gray-100 bg-gray-50">
                    <span class="text-sm font-medium text-gray-900">Select All</span>
                    @if ($allVisibleSelected)
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <div class="w-4 h-4 border border-gray-300 rounded"></div>
                    @endif
                </div>
                
                @foreach ($search_results as $result)
                    <div wire:click="toggleDenomination({{ $result['id'] }})"
                        class="px-4 py-2 hover:bg-gray-50 cursor-pointer flex items-center justify-between border-b border-gray-100 last:border-b-0">
                        <span class="text-sm text-gray-900">{{ $result['name'] }}</span>
                        @if ($result['selected'])
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <div class="w-4 h-4 border border-gray-300 rounded"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if ($show_dropdown && empty($search_results) && strlen($denomination_search) >= 1)
            <div class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg">
                <div class="px-4 py-2 text-sm text-gray-500">
                    No denominations found
                </div>
            </div>
        @endif
    </div>
</div>

        {{-- Form Actions --}}
        <div class="flex gap-4 items-start">
            <button type="button" wire:click="cancel"
                class="flex items-center px-4 py-2 rounded-md border hover:bg-muted">
                Cancel
            </button>
            <button type="submit"
                class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 disabled:opacity-50">
                Save
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = event.target.closest('[x-data]');
            if (!dropdown) {
                @this.hideDropdown();
            }
        });
    </script>
@endpush
