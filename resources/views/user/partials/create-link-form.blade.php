<div class="bg-slate-100 p-6 rounded-md border mb-8">
    <div class="flex flex-row justify-between items-center">
        <h2 class="text-xl font-semibold mb-4">Create new link</h2>
       
    </div>
    
    <form action="{{ route('links.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-row gap-4">
            <input
                type="text"
                name="original_url"
                id="original_url"
                placeholder="Paste your long URL here"
                class="w-full h-12 rounded-md border border-input bg-background px-4 py-2 pr-32"
                value="{{ session('short_url') ?? old('original_url', 'https://') }}"
                required
            />
            <div class="inset-y-0 right-0 flex w-2/5 items-center pr-3">
                @if(session('success'))
                <div class="flex items-center gap-3 w-full">
                    <button 
                        type="button" 
                        class="flex items-center text-sm bg-green-500 rounded-md text-white hover:bg-green-600 px-4 py-3 flex-1 justify-center"
                        onclick="navigator.clipboard.writeText('{{ session('short_url') }}')"
                    >
                        <x-heroicon-o-clipboard class="h-4 w-4 mr-1" />
                        Copy
                    </button>
                    <button 
                        type="button" 
                        class="flex items-center text-sm border border-green-500 rounded-md hover:bg-green-50 px-4 py-3 flex-1 justify-center"
                        onclick="document.getElementById('original_url').value = 'https://'; document.getElementById('original_url').focus()"
                    >
                        <x-heroicon-o-arrow-path class="h-4 w-4 mr-1" />
                        New Link
                    </button>
                </div>
                @else
                <button type="submit" class="flex items-center text-sm text-primary bg-green-500 rounded-md text-white hover:bg-green-600 px-4 py-3 w-full justify-center"> 
                    Shorten
                    <x-heroicon-o-arrow-right class="h-4 w-4 ml-2 font-bold" />
                </button>
                @endif
            </div>
        </div>
        
        @if(session('success'))
        <div class="flex items-center bg-muted/50 rounded-md p-4 justify-between">
            <span class="font-mono text-sm">{{ session('short_url') }}</span>
            <div class="flex gap-3">
                <button 
                    type="button" 
                    class="flex items-center text-sm text-primary hover:text-primary/80"
                    onclick="navigator.clipboard.writeText('{{ session('short_url') }}')"
                >
                    <x-heroicon-o-clipboard class="h-4 w-4 mr-1" />
                    Copy
                </button>
                <button 
                    type="button" 
                    class="flex items-center text-sm text-primary hover:text-primary/80"
                    onclick="document.getElementById('original_url').value = 'https://'; document.getElementById('original_url').focus()"
                >
                    <x-heroicon-o-arrow-path class="h-4 w-4 mr-1" />
                    Shorten Another
                </button>
            </div>
        </div>
        @endif
    </form>

    
</div>