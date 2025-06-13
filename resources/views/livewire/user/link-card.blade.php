<div>
    <div class="bg-background rounded-md border overflow-hidden animate-fade-in" x-data="{ showDropdown: false, showQrModal: false }">
        <div class="p-6">
            <div class="flex justify-between items-start relative">
                <div>
                    @if($editing)
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-gray-500">{{ config('app.url') }}/</span>
                        <input
                            wire:model="editedShortCode"
                            wire:keydown.enter="saveLink"
                            type="text"
                            class="font-mono text-sm rounded-md py-1 px-2 font-medium text-gray-700 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            autofocus
                        >
                        <button 
                            wire:click="saveLink" 
                            wire:loading.attr="disabled"
                            class="flex items-center gap-1 px-3 py-1 rounded-md text-sm border border-gray-300 bg-gray-700 text-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <span wire:loading wire:target="saveLink" class="hidden">
                                <x-heroicon-o-arrow-path class="h-4 w-4 animate-spin" />
                            </span>
                            <span wire:loading.remove wire:target="saveLink">
                                <x-heroicon-o-check class="h-4 w-4" />
                            </span>
                            <span>Save</span>
                        </button>
                        <button 
                            wire:click="cancelEdit" 
                            wire:loading.attr="disabled"
                            class="px-3 py-1 rounded-md text-sm border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        >
                            Cancel
                        </button>
                    </div>
                    @else
                    <div wire:loading>
                        <x-heroicon-o-arrow-path class="h-6 w-6 animate-spin text-gray-500 " />
                    </div>
                        <h3 class="font-mono text-lg font-semibold text-blue-500">
                            {{ $link->short_url }}
                            @if($link->is_custom)
                                <span class="text-xs text-green-500 ml-1">(custom)</span>
                            @endif
                        </h3>
                    @endif
                    <p class="text-sm text-black mt-1">Created on {{ $link->created_at->format('D M d, Y') }}</p>
                </div>
                
                <!-- Ellipsis Button and Dropdown -->
                <div class="relative">
                    <button 
                        @click="showDropdown = !showDropdown"
                        @click.away="showDropdown = false"
                        class="p-2 rounded-full hover:bg-gray-100 focus:outline-none transition"
                    >
                        <x-heroicon-o-ellipsis-vertical class="h-6 w-6 text-gray-500" />
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div 
                        x-show="showDropdown"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black dark:ring-gray-600 ring-opacity-5 z-50"
                        style="display: none;"
                    >
                        <div class="py-1">
                            <button 
                                type="button"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                @click="showDropdown = false"
                                wire:click="editLink"
                            >
                                <x-heroicon-o-pencil-square class="h-4 w-4 mr-2" />
                                Edit
                            </button>
                            
                            <form method="POST" action="{{ route('links.destroy', $link->id) }}" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                    @click="showDropdown = false"
                                    {{-- onclick="return confirm('Are you sure you want to delete this link?')" --}}
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-link-deletion')"
                                >
                                    <x-heroicon-o-trash class="h-4 w-4 mr-2" />
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <p class="text-sm">
                    <span class="font-medium">Original:</span> 
                    <span class="text-gray-400">{{ $link->original_url }}</span>
                </p>
            </div>
        </div>
        
        <!-- Blue footer section -->
        <div class="bg-blue-50 px-6 py-3 flex justify-between items-center">
            <div class="text-sm font-medium text-blue-800">{{ $link->clicks }} clicks</div>
            <div class="flex gap-4">
                <button 
                    wire:click="copyToClipboard"
                    class="flex bg-white rounded-md items-center p-2 text-sm text-black hover:text-black font-semibold border-gray-200"
                >
                    <x-heroicon-o-link class="h-4 w-4 mr-1" />
                    {{ $copied ? 'Copied!' : 'Copy' }}
                </button>
                <button 
                    @click="showQrModal = true"
                    class="flex bg-white rounded-md items-center p-2 text-sm text-black hover:text-black font-semibold border-gray-200"
                >
                    <x-heroicon-s-qr-code class="h-4 w-4 mr-1" />
                    QR Code
                </button>
                <a 
                    {{-- href="{{ route('links.analytics', $link->id) }}" --}}
                    class="flex bg-white rounded-md items-center p-2 text-sm text-black hover:text-black font-semibold border-gray-200"
                >
                    <x-heroicon-s-presentation-chart-line class="h-4 w-4 mr-1" />
                    Analytics
                </a>
            </div>
        </div>
    </div>
    
    <!-- QR Code Modal -->
    <div 
        x-show="showQrModal"
        @click.away="showQrModal = false"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;"
    >
        <div class="bg-white p-6 rounded-lg max-w-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">QR Code</h3>
                <button @click="showQrModal = false" class="text-gray-500 hover:text-gray-700">
                    <x-heroicon-o-x-mark class="h-6 w-6" />
                </button>
            </div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($link->short_url) }}" alt="QR Code">
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Scan this QR code to visit the link</p>
            </div>
        </div>
    </div>



<x-modal name="confirm-link-deletion" :show="$errors->isNotEmpty()" focusable>
    <form wire:submit="deleteLink" class="p-6">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this link?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Users cannot access this link once it is deleted. Do you want to continue?') }}
        </p>

        <div class="mt-6">
        
            <h1 class="bg-red-200 text-red-800 border-red-600 border p-2 rounded-md"> <span class="">{{ config('app.url') }}/</span>{{$link->short_url}}</h1>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Link') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
</div>