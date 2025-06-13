<button
    wire:click="{{ $attributes->get('wire:click') }}"
    class="border px-2 rounded-md bg-kanik-brown-100 text-kanik-brown-500 border-kanik-brown-500 hover:bg-kanik-brown-100/50 hover:animate-pulse">
    {{$slot}}
</button>
