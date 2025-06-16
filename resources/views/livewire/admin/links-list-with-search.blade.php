<div class="m-0">
    {{-- Search and filters --}}
    <div class="bg-background p-4 rounded-md border mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-muted-foreground" />
                </div>
                <input type="text" placeholder="Search links by type, url or title..."
                    class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2"
                    wire:model.live.debounce.300ms="search" />
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="selectedType"
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                    <option value="">All Types</option>
                    @foreach ($linkTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="selectedGroup"
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                    <option value="">All Groups</option>
                    <option value="ungrouped">Ungrouped</option>
                    @foreach ($linkGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if ($links->isEmpty())
    {{-- Empty state --}}
    <div class="p-8 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted">
            <x-heroicon-o-link class="h-6 w-6 text-muted-foreground" />
        </div>
        <h3 class="mt-4 text-sm font-medium text-foreground">No links found</h3>
        <p class="mt-1 text-sm text-muted-foreground">Get started by creating a new short link.</p>
        <div class="mt-6">
            <a href="{{ route('admin.links.create') }}"
                class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                New Link
            </a>
        </div>
    </div>
    @else
    {{-- Grouped Links Display --}}
    @foreach ($groupedLinks as $groupId => $groupLinks)
    <div class="mb-8">
        {{-- Group Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    @if ($groupId === 'ungrouped')
                    <x-heroicon-o-folder-open class="h-5 w-5 text-muted-foreground" />
                    @else
                    <x-heroicon-o-folder class="h-5 w-5 text-primary" />
                    @endif
                    <h3 class="text-lg font-semibold text-foreground">
                        {{ $groupNames[$groupId] }}
                        ({{ $groupLinks->first()->created_at->format('D, M d, Y') }})
                    </h3>
                </div>
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                    {{ $groupLinks->count() }} {{ Str::plural('link', $groupLinks->count()) }}
                </span>
            </div>

            @if ($groupId !== 'ungrouped')
            {{-- Group Actions --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.analytics.show', $groupId) }}"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-md border-2 border-primary text-primary hover:bg-primary/10"
                    title="View Analytics">
                    <x-heroicon-o-chart-bar class="h-4 w-4" /> Analytics
                </a>

                <button class="p-1 rounded-md hover:bg-muted text-muted-foreground" title="Edit Group">
                    <x-heroicon-o-pencil class="h-4 w-4" />
                </button>
            </div>
            @endif
        </div>

        {{-- Links Table for this group --}}
        <div class="bg-background rounded-md border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="text-left px-4 py-3 text-sm font-medium">Denomination</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Short URL</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Type</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Clicks</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach ($groupLinks as $link)
                        @php
                        $generatedLink = "{$domain}/{$link->short_url}";
                        if ($link->denomination) {
                        $generatedLink .= "/{$link->denomination->slug}";
                        }
                        @endphp
                        <tr key="{{ $link->id }}" class="hover:bg-muted/20">
                            <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                                <x-heroicon-o-globe-alt class="h-4 w-4 text-gray-500" />
                                {{ $link->denomination?->name ?? 'N/A' }}

                            </td>
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
                            <td class="px-4 py-4 text-muted-foreground">
                                {{ $link->clicks }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.links.edit', $link->id) }}"
                                        class="p-1 rounded-md hover:bg-muted" title="Edit">
                                        <x-heroicon-c-pencil class="h-4 w-4" />
                                    </a>
                                    <form method="POST" action="{{ route('admin.links.destroy', $link->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this link?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 rounded-md hover:bg-muted text-red-500"
                                            title="Delete">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-6">
        {{ $links->links() }}
    </div>
    @endif

</div>