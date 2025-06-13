<div class="m-0">
    {{-- Search and filters --}}
    <div class="bg-background p-4 rounded-md border mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-muted-foreground" />
                </div>
                <input
                    type="text"
                    placeholder="Search links by type, url or title..."
                    class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2"
                />
            </div>
            <div class="w-full md:w-48">
                <select
                    class="w-full h-10 rounded-md border border-input bg-background px-3 py-2"
                >
                    <option value="">All Types</option>
                    @foreach($linkTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
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
            <a href="{{ route('admin.links.create') }}" class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                New Link
            </a>
        </div>
    </div>
        
    @else
        {{-- Links Table --}}
    <div class="bg-background rounded-md border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-medium">Title</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Short URL</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Type</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Expires At</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @foreach ($links as $link)
                    <tr key="{{ $link->id }}" class="hover:bg-muted/20">
                        <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                            <x-heroicon-o-globe-alt class="h-4 w-4 text-gray-500"/>
                            {{ $link->title }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ $shortDomain }}/{{ $link->short_url }}" 
                                   target="_blank"
                                   class="text-muted-foreground hover:text-primary hover:underline">
                                    flc.click/{{ $link->short_url }}
                                </a>
                                <button 
                                    onclick="navigator.clipboard.writeText('{{ $shortDomain }}/{{ $link->short_url }}/{{ auth()->user()->denomination->slug ?? 'psc'}}')"    
                                    class="p-1 rounded-md hover:bg-muted text-muted-foreground"
                                    title="Copy to clipboard">
                                    <x-heroicon-o-clipboard class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                {{ $link->link_type->name ?? 'None' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-muted-foreground">
                            {{ $link->expires_at ? $link->expires_at->format('M d, Y H:i') : 'Never' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.links.edit', $link->id) }}" class="p-1 rounded-md hover:bg-muted" title="Edit">
                                    <x-heroicon-c-pencil class="h-4 w-4" />
                                </a>
                                <form method="POST" action="{{ route('admin.links.destroy', $link->id) }}" onsubmit="return confirm('Are you sure you want to delete this link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 rounded-md hover:bg-muted text-red-500" title="Delete">
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

        <!-- Pagination -->
        <div class="mt-4 px-4">
            {{ $links->links() }}
        </div>
    </div>
    @endif
    
</div>