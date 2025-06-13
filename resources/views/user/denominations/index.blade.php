@extends('layouts.user')

@section('title', 'Assigned Denominations')

@section('top-action')
    <!-- You can add any top action buttons here if needed -->
@endsection

@section('content')
    <div class="container mx-auto px-4 py-4">
        @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
        @elseif (session('error'))
            <x-alert type="danger" class="mb-4">
                {{ session('error') }}
            </x-alert>
        @endif


        @if(auth()->user()->denominations->isEmpty())
            <div class="p-8 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted">
                    <x-heroicon-o-link class="h-6 w-6 text-muted-foreground" />
                </div>
                <h3 class="mt-4 text-sm font-medium text-foreground">No Assigned Denominations</h3>
                <p class="mt-1 text-sm text-muted-foreground">Get in touch with the admin</p>
                <div class="mt-6">
                    <a href="mailto:{{ $mailing_address }}" target="_blank"
                        class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                        <x-heroicon-o-envelope class="-ml-0.5 mr-1.5 h-5 w-5" />
                        Send Mail
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow">
                <ul class="divide-y divide-gray-200">
                    @foreach(auth()->user()->denominations as $denomination)
                        <li class="px-4 py-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $denomination->name }}
                                            </p>
                                            @if(auth()->user()->defaultDenomination && auth()->user()->defaultDenomination->id == $denomination->id)
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Primary
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-4">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $denomination->zone->name ?? 'N/A' }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                </svg>
                                                {{ $denomination->population ?? 0 }} members
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection