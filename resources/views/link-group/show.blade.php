@extends($layout ?? 'layouts.admin')

@section('title', 'Analytics')

@section('top-action')
    <a href="{{ url()->previous() }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- Success Flash Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-foreground">
                {{ $linkGroup->name }}
            </h1>
            <div class="flex items-center text-muted-foreground text-sm mt-1">
                <x-heroicon-s-calendar class="h-4 w-4 mr-1.5" />
                {{ $linkGroup->created_at->format('l, F j, Y') }}
            </div>
            <div class="flex items-center text-muted-foreground text-sm mt-1">
                <x-heroicon-o-clock class="h-4 w-4 mr-1.5" />
                {{ $linkGroup->created_at->format('g:i A') }}
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            {{-- Total Clicks --}}
            <div class="bg-background rounded-md border p-4">
                <h2 class="text-lg font-medium mb-4">Total Clicks</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold">{{ $totalClicks }}</p>
                        <p class="text-sm text-muted-foreground">All time clicks</p>
                    </div>
                    <div class="bg-primary/10 p-3 rounded-full">
                        <x-heroicon-s-cursor-arrow-rays class="h-6 w-6 text-primary" />
                    </div>
                </div>
            </div>

            {{-- Clicks by Device --}}
            <div class="bg-background rounded-md border p-4">
                <h2 class="text-lg font-medium mb-4">Clicks by Device</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                        <x-heroicon-s-device-phone-mobile class="h-8 w-8 text-primary mb-2" />
                        <span class="text-sm text-muted-foreground">Mobile</span>
                        <span class="text-xl font-semibold mt-1">{{ $mobileClicks }}</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                        <x-heroicon-s-computer-desktop class="h-8 w-8 text-primary mb-2" />
                        <span class="text-sm text-muted-foreground">Desktop</span>
                        <span class="text-xl font-semibold mt-1">{{ $desktopClicks }}</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-muted/10 rounded-lg">
                        <x-heroicon-s-device-tablet class="h-8 w-8 text-primary mb-2" />
                        <span class="text-sm text-muted-foreground">Tablet</span>
                        <span class="text-xl font-semibold mt-1">{{ $tabletClicks }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Links Table --}}
        <div class="bg-background rounded-md border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium">Denomination</th>
                            <th class="text-left px-4 py-3 font-medium">Short URL</th>
                            <th class="text-left px-4 py-3 font-medium">Type</th>
                            <th class="text-left px-4 py-3 font-medium">Clicks</th>
                            <th class="text-left px-4 py-3 font-medium">Expires At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-muted">
                        @foreach ($linkGroup->links as $link)
                            @php
                                $generatedLink = env('APP_URL') . "/click/{$link->short_url}";
                                if ($link->denomination) {
                                    $generatedLink .= "/{$link->denomination->slug}";
                                }
                            @endphp
                            <tr class="hover:bg-muted/20">
                                <td class="px-4 py-3 font-medium">
                                    {{ $link->denomination->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <p class="text-muted-foreground hover:text-primary truncate max-w-[180px]">
                                            {{ $link->short_url }}
                                        </p>
                                        <button
                                            onclick="navigator.clipboard.writeText('{{ $generatedLink }}')"
                                            class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                                            title="Copy to clipboard">
                                            <x-heroicon-o-document-duplicate class="h-5 w-5" />
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                        {{ $link->link_type->name ?? 'None' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ $link->clicks ?? 0 }}
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
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
            <a href="{{url()->previous()}}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-muted text-muted-foreground rounded-md hover:bg-muted/70">
                <x-heroicon-o-arrow-left class="h-4 w-4" />
                Back to Links
            </a>
        </div>
    </div>
@endsection
