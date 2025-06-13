<div class="m-0">

    {{-- {/* Search and filters */} --}}
    <div class="bg-background p-4 rounded-md border mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-muted-foreground" />
                </div>
                <input type="text" wire:model="search" placeholder="Search Zones..."
                    class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2"
                    disabled={{$zones->isEmpty()}} />

            </div>


        </div>
    </div>
    {{-- {/* Categories Table */} --}}
    @if ($zones->isEmpty())
        {{-- Empty state --}}
        <div class="p-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-fullbg-grey-200">
                <x-heroicon-o-rectangle-group class="h-10 w-10 text-muted-foreground " />
            </div>
            <h3 class="mt-4 text-sm font-medium text-foreground">No zones found</h3>
            <p class="mt-1 text-sm text-muted-foreground">Get started by creating one.</p>
            <div class="mt-6">
                <a href="{{ route('admin.zones.create') }}"
                    class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                    <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                    New Zone
                </a>
            </div>
        </div>
    @else
        {{-- Grouped Links Display --}}
        <div class="bg-background rounded-md border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="text-left px-4 py-3 text-sm font-medium">Name</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Slug</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Country</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">No. Denominations</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach ($zones as $zone)


                            <tr key={{$zone->id}} class="hover:bg-muted/20">
                                <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                                    <x-heroicon-o-globe-alt class="h-4 w-4 text-gray-500" />
                                    {{$zone->name}}
                                </td>
                                <td class="px-4 py-4 text-muted-foreground">{{$zone->slug}}</td>

                                <td class="px-4 py-4 text-muted-foreground">{{$zone->country}}</td>
                                <td class="px-4 py-4 text-muted-foreground">{{$zone->denominations_count}}</td>



                                <td class="px-4 py-4">
                                    <div class="flex items-center space-x-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.zones.edit', $zone->id) }}"
                                            class="p-1 rounded-md hover:bg-muted" title="Edit">
                                            <x-heroicon-c-pencil class="h-4 w-4" />
                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.zones.destroy', $zone->id) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this denomination?');">
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
            <!-- Pagination -->

            <div class="mt-4">
                {{ $zones->links() }}
            </div>

        </div>
    @endif


</div>