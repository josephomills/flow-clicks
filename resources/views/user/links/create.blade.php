@extends('layouts.user')

@section('title', 'Create New Link')

@section('top-action')
<a href="{{ route('user.links') }}" class="flex items-center bg-primary text-primary-foreground py-2 px-4 rounded-md hover:bg-primary/90 text-sm">
    <x-heroicon-s-arrow-left class="h-4 w-4 mr-1" />
    Back to Links
</a>
@endsection

@section('content')
<div class="m-0">
    <div class="bg-background p-6 rounded-md border mb-6">
        
        @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md text-sm">
            Link created successfully!
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md text-sm">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('user.links.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Title Field -->
            <div class="space-y-2">
                <label for="title" class="text-sm font-semibold text-muted-foreground">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    placeholder="My Awesome Link"
                    class="w-full h-10 rounded-md border border-input bg-background px-4 py-2"
                    value="{{ old('title') }}"
                />
            </div>

            <!-- URL Field -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input
                        type="url"
                        name="original_url"
                        id="original_url"
                        placeholder="https://example.com"
                        class="w-full h-10 rounded-md border border-input bg-background px-4 py-2"
                        value="{{ old('original_url', 'https://') }}"
                        required
                    />
                </div>
                <div class="w-full md:w-auto">
                    <button 
                        type="submit" 
                        class="flex items-center justify-center text-sm text-white bg-primary rounded-md hover:bg-primary/90 px-4 py-2 h-10 w-full md:w-32"
                    >
                        Shorten
                        <x-heroicon-o-arrow-right class="h-4 w-4 ml-2" />
                    </button>
                </div>
            </div>

            @if (auth()->user()->allow_multi_denomination_links)
                     <!-- Denomination Selection -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-muted-foreground">Select Denominations (Optional)</label>

                    <div x-data="{
                        open: false,
                        selected: {{ json_encode([auth()->user()->denomination_id]) }},
                        init() {
                            // Initialize selected count display
                            this.$refs.selectedCount.textContent = this.selected.length ?
                                `${this.selected.length} selected` :
                                'Select denominations';
                    
                            // Watch for changes
                            this.$watch('selected', () => {
                                this.$refs.selectedCount.textContent = this.selected.length ?
                                    `${this.selected.length} selected` :
                                    'Select denominations';
                            });
                        }
                    }" class="relative">
                        <!-- Trigger Button -->
                        <button @click="open = !open" type="button"
                            class="w-full flex justify-between items-center h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            <span x-ref="selectedCount">
                                @if (auth()->user()->denomination)
                                    {{ auth()->user()->denomination->name }}
                                @else
                                    Select denominations
                                @endif
                            </span>
                            <x-heroicon-s-chevron-down class="h-4 w-4 transition-transform"
                                x-bind:class="{ 'rotate-180': open }" />
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" @click.outside="open = false"
                            class="absolute z-10 mt-1 w-full rounded-md border border-input bg-background shadow-lg max-h-60 overflow-auto">
                            <div class="space-y-1 p-1">
                                @foreach ($denominations as $denomination)
                                    <label class="flex items-center px-3 py-2 rounded hover:bg-muted cursor-pointer">
                                        <input type="checkbox" name="denominations[]" value="{{ $denomination->id }}"
                                            x-model="selected"
                                            class="h-4 w-4 rounded border-input text-primary focus:ring-primary"
                                            {{ auth()->user()->denomination_id == $denomination->id ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">{{ $denomination->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Link Type Selection -->
            <div class="space-y-2">
                <label class="text-sm font-semibold text-muted-foreground">Select Link Type</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($link_types as $type)
                    <label class="inline-flex items-center">
                        <input 
                            type="radio" 
                            name="link_type_id" 
                            value="{{ $type->id }}"
                            class="sr-only peer"
                            {{ old('link_type_id') == $type->id ? 'checked' : '' }}
                            {{ $loop->first && !old('link_type_id') ? 'checked' : '' }}
                        >
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground peer-checked:bg-primary peer-checked:text-primary-foreground cursor-pointer hover:bg-muted/80">
                            {{ $type->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </form>

        @if(session('short_url'))
        <div class="mt-8 pt-6 border-t">
            <h2 class="text-lg font-semibold mb-4">Generated Links</h2>
            
            <!-- Base Link -->
            <div class="mb-4 p-4 bg-muted/50 rounded-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-link class="h-4 w-4 text-muted-foreground" />
                        <span class="text-sm font-medium">Default:</span>
                        <a href="{{ session('short_url') }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                            {{ session('short_url') }}
                        </a>
                    </div>
                    <button 
                        onclick="navigator.clipboard.writeText('{{ session('short_url') }}')"
                        class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                        title="Copy to clipboard"
                    >
                        <x-heroicon-o-clipboard class="h-4 w-4" />
                    </button>
                </div>
            </div>
            
            {{-- @session('success')
            <!-- Denomination Links -->
            <div class="space-y-3">
                @foreach($denominations as $denomination)
                <div class="p-4 bg-muted/50 rounded-md">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-link class="h-4 w-4 text-muted-foreground" />
                            <span class="text-sm font-medium">{{ $denomination->name }}:</span>
                            <a href="{{ session('short_url') }}/{{ $denomination->slug }}" 
                               target="_blank" 
                               class="text-sm text-blue-600 hover:underline">
                                {{ session('short_url') }}/{{ $denomination->slug }}
                            </a>
                        </div>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ session('short_url') }}/{{ $denomination->slug }}')"
                            class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                            title="Copy to clipboard"
                        >
                            <x-heroicon-o-clipboard class="h-4 w-4" />
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endsession --}}
            
            <!-- New Link Button -->
            <div class="mt-6">
                <a 
                    href="{{ route('admin.links.create') }}" 
                    class="inline-flex items-center text-sm text-primary hover:text-primary/80"
                >
                    <x-heroicon-o-arrow-path class="h-4 w-4 mr-1" />
                    Create Another Link
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection