<div class="mt-6">
    @if ($linkGroups->isEmpty())
        <div class="p-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted">
                <x-heroicon-o-folder-open class="h-6 w-6 text-muted-foreground" />
            </div>
            <h3 class="mt-4 text-sm font-medium text-foreground">No link groups found</h3>
            <p class="mt-1 text-sm text-muted-foreground">Create a group to organize your links.</p>
            <div class="mt-6">
                <a href="#"
                    class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                    <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                    New Group
                </a>
            </div>
        </div>
    @else
        @php
            $groupsWithLinks = $linkGroups->filter(function ($group) {
                return $group->links->isNotEmpty();
            });
        @endphp

        @if ($groupsWithLinks->isEmpty())
            <div class="p-8 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted">
                    <x-heroicon-o-folder-open class="h-6 w-6 text-muted-foreground" />
                </div>
                <h3 class="mt-4 text-sm font-medium text-foreground">No groups with links found</h3>
                <p class="mt-1 text-sm text-muted-foreground">All groups are empty. Add links to your groups to see them
                    here.</p>
            </div>
        @else
            @foreach ($groupsWithLinks as $group)
                <div class="mb-10">
                    {{-- Group Header --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-folder class="h-5 w-5 text-primary" />
                                <h3 class="text-lg font-semibold text-foreground">
                                    {{ $group->name }}
                                </h3>
                            </div>
                            <span class="text-sm text-muted-foreground">
                                Owner: {{ $group->user->name }} &middot; Role: {{ $group->user->role }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('link-group.show', ['linkGroup' => $group->id]) }}"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-primary text-primary hover:bg-primary/10 text-sm"
                                title="View Analytics">
                                <x-heroicon-o-chart-bar class="h-4 w-4" />
                                Analytics
                            </a>

                            <a href="{{ route('link-group.edit', ['linkGroup' => $group->id]) }}"
                            class="p-1.5 rounded-md hover:bg-muted text-muted-foreground"
                                title="Edit Group">
                                <x-heroicon-o-pencil class="h-4 w-4" />
                            </a>
                        </div>
                    </div>

                    {{-- Group Links Table --}}
                    <div class="bg-background border rounded-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-muted/50 text-muted-foreground">
                                    <tr>
                                        <th class="text-left px-4 py-2 font-medium">Title</th>
                                        <th class="text-left px-4 py-2 font-medium">Short URL</th>
                                        <th class="text-left px-4 py-2 font-medium">Type</th>
                                        <th class="text-left px-4 py-2 font-medium">Clicks</th>
                                        <th class="text-left px-4 py-2 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-muted">
                                    @foreach ($group->links as $link)
                                        <tr class="hover:bg-muted/20">
                                            <td class="px-4 py-3 text-foreground">
                                                {{ $link->title ?? 'Untitled' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <span x-data="{ copied: false }"
                                                        class="inline-flex items-center gap-1.5 rounded-full border border-muted bg-muted px-3 py-1.5 text-sm font-medium text-muted-foreground hover:bg-muted/80 transition-colors relative">
                                                        {{ $link->short_url }}

                                                        <button
                                                            @click="
                                            navigator.clipboard.writeText('{{ env('APP_URL') }}/click/{{ $link->short_url }}/{{ $link->denomination->slug }}');
                                            copied = true;
                                            setTimeout(() => copied = false, 1500);
                                        "
                                                            class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                                                            title="Copy to clipboard">
                                                            <x-heroicon-o-document-duplicate class="h-4 w-4" />
                                                        </button>

                                                        <span x-show="copied" x-transition
                                                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-background text-xs text-green-600 px-2 py-1 rounded shadow border border-green-200">
                                                            Copied!
                                                        </span>
                                                    </span>

                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                                    {{ $link->link_type->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-muted-foreground">
                                                {{ $link->clicks ?? 0 }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">

                                                    <button class="p-1.5 rounded-md hover:bg-muted text-blue-500"
                                                        title="Share">
                                                        <x-heroicon-o-share class="h-4 w-4" />
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $link->id }})"
                                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                        class="p-1.5 rounded-md hover:bg-muted text-red-500"
                                                        title="Delete">
                                                        <x-heroicon-o-trash class="h-4 w-4" />
                                                    </button>

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
        @endif
    @endif
</div>
