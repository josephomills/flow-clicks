<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<header class="px-5 sticky top-0 z-50 w-full border-b bg-background/80 backdrop-blur-md">
    <div class=" flex h-16 items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="/dashboard" class="font-bold text-kanik-brown-500 text-xl">
                Flow Clicks 
            </a>
           
        </div>
        
        <!-- User Dropdown -->
        @volt
        <div class="flex items-center  justify-center gap-2" x-data="{ open: false }">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-slate-900 text-white overflow-hidden">
                <span class="text-lg text-center font-bold leading-none">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </span>
            </div>
            
            <button 
                @click="open = !open"
                class="flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground focus:outline-none"
            >
            
                <span>{{ auth()->user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" 
                     :class="{ 'rotate-180': open }" 
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div 
                x-show="open"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-10 top-10 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black dark:ring-gray-600 ring-opacity-5 py-1 z-50"
            >
                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Dashboard
                </a>
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" wire:navigate>
                    Profile
                </a>
                
                <button wire:click="logout" class="w-full text-start">
                    <x-dropdown-link>
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </button>
            </div>
        </div>
        @endvolt
    </div>
</header>