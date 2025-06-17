<div class="m-0">
    <div class="bg-background p-6 rounded-md border mb-6">
        <h1 class="text-xl font-semibold mb-6">Create New Short Link</h1>

        @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-500/10 text-green-500 rounded-md text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('warning'))
        <div class="mb-6 p-4 bg-yellow-500/10 text-yellow-500 rounded-md text-sm">
            {{ session('warning') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-500/10 text-red-500 rounded-md text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if (session()->has('copied'))
        <div class="mb-6 p-4 bg-blue-500/10 text-blue-500 rounded-md text-sm">
            {{ session('copied') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 text-red-500 rounded-md text-sm">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form wire:submit="submit" class="space-y-6">
            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-muted-foreground">Original URL *</label>
                <input type="url" wire:model="original_url" id="original_url" placeholder="https://example.com"
                    class="w-full h-10 rounded-md border border-input bg-background px-4 py-2" />

                @error('original_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Title Field -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-muted-foreground">Label (opitonal)</label>
                <input type="text" wire:model="title" id="title" placeholder="My Awesome Link"
                    class="w-full h-10 rounded-md border border-input bg-background px-4 py-2" />
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- URL Field -->
            <div class="flex flex-col md:flex-row gap-4">
            </div>
            <!-- Denomination Selection -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-muted-foreground">Select Denomination(s) (optional)</label>

                <div x-data="{
                    open: false,
                    selectedCount: @entangle('denominations').length,
                    init() {
                        this.$watch('selectedCount', () => {
                            this.$refs.selectedCountText.textContent = this.selectedCount > 0 ?
                                `${this.selectedCount} selected` :
                                'Select denominations';
                        });
                    }
                }" class="relative">
                    <!-- Trigger Button -->
                    <button @click="open = !open" type="button"
                        class="w-full flex justify-between items-center h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        <span x-ref="selectedCountText">
                            @if (auth()->user()->denomination)
                            {{ auth()->user()->denomination->name }}
                            @else
                            Select denomination(s)
                            @endif
                        </span>
                        <x-heroicon-s-chevron-down class="h-4 w-4 transition-transform"
                            x-bind:class="{ 'rotate-180': open }" />
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute z-10 mt-1 w-full rounded-md border border-input bg-background shadow-lg max-h-60 overflow-auto">
                        <div class="space-y-1 p-1">
                            @foreach ($availableDenominations as $denomination)
                            <label class="flex items-center px-3 py-2 rounded hover:bg-accent hover:text-accent-foreground cursor-pointer">
                                <input type="checkbox" wire:model="denominations" value="{{ $denomination->id }}"
                                    class="h-4 w-4 rounded border-input text-primary focus:ring-primary">
                                <span class="ml-2 text-sm">{{ $denomination->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link Type Selection -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-muted-foreground">Select Link Type *</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($linkTypes as $type)
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="link_type_id" value="{{ $type->id }}" class="sr-only peer">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground peer-checked:bg-primary peer-checked:text-primary-foreground cursor-pointer hover:bg-muted/80">
                            {{ $type->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('link_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @error('denominations') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end flex-row">
                <div class="w-full md:w-auto">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex items-center justify-center text-sm text-primary-foreground bg-primary rounded-md hover:bg-primary/90 px-4 py-2 h-10 w-full md:w-32 disabled:opacity-50">
                        <span wire:loading.remove>Shorten</span>
                        <span wire:loading>Processing...</span>
                        <x-heroicon-o-arrow-right class="h-4 w-4 ml-2" wire:loading.remove />
                    </button>
                </div>
            </div>
        </form>

        @if ($showResults && $created_links && count($created_links) > 0)
        <div class="mt-8 pt-6 border-t">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Generated Links</h2>
                @if ($link_group)
                <span class="text-sm text-muted-foreground">Group: {{ $link_group->name }}</span>
                @endif
            </div>

            <div class="space-y-3">
                @foreach ($created_links as $linkData)
                <div class="p-4 bg-muted/50 rounded-md">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <x-heroicon-o-link class="h-4 w-4 text-muted-foreground" />
                                <span class="text-sm font-medium">{{ $linkData['denomination']->name }}:</span>
                                <a href="{{ $linkData['full_url'] }}" target="_blank"
                                    class="text-sm text-primary hover:underline">
                                    {{ $linkData['full_url'] }}
                                </a>
                            </div>
                            @if ($linkData['link']->description)
                            <p class="text-xs text-muted-foreground ml-6">{{ $linkData['link']->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 ml-6 mt-1">
                                <span class="text-xs text-muted-foreground">Clicks:
                                    {{ $linkData['link']->clicks }}</span>
                                <span class="text-xs text-muted-foreground">Created:
                                    {{ $linkData['link']->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="copyToClipboard('{{ $linkData['full_url'] }}')"
                                class="p-1 rounded-md hover:bg-accent hover:text-accent-foreground text-muted-foreground" title="Copy to clipboard">
                                <x-heroicon-o-clipboard class="h-4 w-4" />
                            </button>
                            <button wire:click="deleteLink({{ $linkData['link']->id }})"
                                wire:confirm="Are you sure you want to delete this link?"
                                class="p-1 rounded-md hover:bg-destructive hover:text-destructive-foreground text-destructive" title="Delete link">
                                <x-heroicon-o-trash class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- New Link Button -->
            <div class="mt-6">
                <button wire:click="createAnother"
                    class="inline-flex items-center text-sm text-primary hover:text-primary/80">
                    <x-heroicon-o-arrow-path class="h-4 w-4 mr-1" />
                    Create Another Link
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

@script
<script>
    $wire.on('copy-to-clipboard', (url) => {
        navigator.clipboard.writeText(url).then(() => {
            // Optional: You can add a toast notification here
        });
    });
</script>
@endscript