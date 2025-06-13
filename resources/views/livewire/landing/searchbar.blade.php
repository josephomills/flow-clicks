<div>
    <form wire:submit.prevent="processLink">
        <label
            class="mx-auto mt-8 relative bg-white min-w-sm max-w-2xl flex flex-col md:flex-row items-center justify-center border py-2 px-2 rounded-2xl gap-2 shadow-2xl focus-within:border-gray-300"
            for="link-input">

            <input 
                id="link-input" 
                placeholder="https://facebook.com/...." 
                wire:model.live.debounce.500ms="linkUrl"
                class="px-6 py-2 w-full rounded-md flex-1 outline-none bg-white" 
                required
                type="url"
            >
            
            <button 
                type="submit"
                class="w-full md:w-auto px-6 py-3 bg-kanik-brown-300 border-kanik-brown-500 text-white fill-white active:scale-95 duration-100 border will-change-transform overflow-hidden relative rounded-lg transition-all disabled:opacity-75"
                wire:loading.attr="disabled"
            >
                <div class="flex items-center transition-all opacity-1">
                    <span class="text-sm font-semibold whitespace-nowrap truncate mx-auto">
                        <span wire:loading>{{$isSubmitted ? 'Shortened!' : 'Shorten'}}</span>
                    </span>
                </div>
            </button>
        </label>
    </form>

    @if ($isSubmitted)
        <div class="mt-4 text-center text-gray-600">
            Processing link: {{ $linkUrl }}
        </div>
    @endif
</div>