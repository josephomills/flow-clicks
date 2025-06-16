@extends('layouts.admin')

@section('title', 'Analytics')

@section('top-action')
<a href="{{ url()->previous() }}"
    class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
    <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
    Go Back
</a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-foreground">
            {{ isset($ungrouped) ? 'Ungrouped Link Analytics' : 'Analytics for: ' . $group->name }}
        </h1>
        @unless(isset($ungrouped))
        <div class="flex items-center text-muted-foreground text-sm mt-1">
            <x-heroicon-s-calendar class="h-4 w-4 mr-1.5" />
            <span>{{ $group->created_at->format('l, F j, Y ') }}</span>
        </div>
        <div class="flex items-center text-muted-foreground text-sm mt-1">
            <x-heroicon-o-clock class="h-4 w-4 mr-1.5" />
            <span> {{ $group->created_at->format('g:i A') }}</span>
        </div>
        @endunless
    </div>

    {{-- Statistics Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Total Clicks Card --}}
        <div class="bg-background rounded-md border p-4">
            <h2 class="text-lg font-medium mb-4">Total Clicks</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold">{{ $totalClicks }}</p>
                    <p class="text-muted-foreground text-sm">All time clicks</p>
                </div>
                <div class="bg-primary/10 p-3 rounded-full">
                    <x-heroicon-s-cursor-arrow-rays class="h-6 w-6 text-primary" />
                </div>
            </div>
        </div>

        {{-- Clicks by Device Card --}}
        <div class="bg-background rounded-md border p-4">
            <h2 class="text-lg font-medium mb-4">Clicks by Device</h2>
            <div class="grid grid-cols-3 gap-4">
                {{-- Mobile --}}
                <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                    <x-heroicon-s-device-phone-mobile class="h-8 w-8 text-primary mb-2" />
                    <span class="text-sm text-muted-foreground">Mobile</span>
                    <span class="text-xl font-semibold mt-1">{{ $mobileClicks }}</span>
                </div>

                {{-- Desktop --}}
                <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                    <x-heroicon-s-computer-desktop class="h-8 w-8 text-primary mb-2" />
                    <span class="text-sm text-muted-foreground">Desktop</span>
                    <span class="text-xl font-semibold mt-1">{{ $desktopClicks }}</span>
                </div>

                {{-- Tablet --}}
                <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                    <x-heroicon-s-device-tablet class="h-8 w-8 text-primary mb-2" />
                    <span class="text-sm text-muted-foreground">Tablet</span>
                    <span class="text-xl font-semibold mt-1">{{ $tabletClicks }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Link Table --}}
    <div class="bg-background rounded-md border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-medium">Denomination</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Short URL</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Type</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Clicks</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Expires At</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @foreach (($ungrouped ?? false) ? $links : $group->links as $link)
                    @php
                    $domain = env('APP_URL') . "/click";
                    $generatedLink = "{$domain}/{$link->short_url}";
                    if ($link->denomination) {
                    $generatedLink .= "/{$link->denomination->slug}";
                    }
                    @endphp
                    <tr class="hover:bg-muted/20">
                        <td class="px-4 py-4 font-medium">{{ $link->denomination->name }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <p class="text-muted-foreground hover:text-primary">
                                    {{ $link->short_url }}
                                </p>
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $generatedLink }}')"
                                    class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                                    title="Copy to clipboard">
                                    <x-heroicon-o-document-duplicate class="h-6 w-6" />
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                {{ $link->link_type->name ?? 'None' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            {{ $link->clicks ?? '0' }}
                        </td>
                        <td class="px-4 py-4 text-muted-foreground">
                            {{ $link->expires_at ? $link->expires_at->format('M d, Y H:i') : 'Never' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-6">
        <a href="{{ route('admin.links') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-muted text-muted-foreground rounded-md hover:bg-muted/70">
            <x-heroicon-o-arrow-left class="h-4 w-4" /> Back to Links
        </a>
    </div>
</div>
@endsection