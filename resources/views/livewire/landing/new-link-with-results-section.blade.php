<div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">

    @if (!$isSubmitted)
        @include('home.partials.pill-announcement')
        <div class="text-center">
            <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl animate-slide-up">
                Shorten your next link
            </h1>
        </div>
    @endif

    {{-- Searchbar --}}
    <form wire:submit.prevent="processLink">
        <label class="mx-auto mt-8 relative bg-white min-w-sm max-w-2xl flex flex-col md:flex-row items-center justify-center border py-2 px-2 rounded-2xl gap-2 shadow-2xl"
               for="link-input">
    
            <input id="link-input" placeholder="https://facebook.com/...."
                   wire:model.live="linkUrl"
                   class="px-6 py-2 w-full rounded-md flex-1 outline-none bg-white"
                   required type="url">
    
            <button type="submit"
                    class="w-full md:w-auto px-6 py-3 bg-kanik-brown-300 text-white rounded-lg transition-all disabled:opacity-75 relative">
                <!-- Default state -->
                <span >Shorten</span>
                
                <!-- Loading state -->
                <span wire:loading class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-opacity="0.25" stroke-width="4"></circle>
                        <path d="M4 12a8 8 0 0 1 16 0" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></path>
                    </svg>
                </span>
            </button>
        </label>
        <span class="mt-2 text-sm text-gray-600 animate-pulse" wire:loading.flex>Processing...</span>
    </form>

    @if ($isSubmitted)
        <div class="mt-6 text-center text-gray-600">
            <p class="mb-4">Choose a denomination to generate your short link:</p>
            <div class="flex items-center justify-center flex-wrap gap-2">
                @foreach ($denominations as $denomination)
                    <x-pill-button wire:click="addCustomSlug('{{ $denomination->slug }}')">
                        {{ $denomination->name }}
                    </x-pill-button>
                @endforeach
            </div>

            @if ($generatedLinks)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Generated Links</h3>
                    <ul class="text-sm space-y-1">
                        @foreach ($generatedLinks as $item)
                            <li>
                                <span class="font-medium">{{ $item['denomination'] }}:</span>
                                <a href="{{ $item['link'] }}" class="text-blue-600 hover:underline" target="_blank">{{ $item['link'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    @if ($error)
    <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
        {{ $error }}
    </div>
@endif

@if ($success)
    <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
        {{ $success }}
    </div>
@endif
</div>
