<div class="m-0">

    {{-- {/* Search and filters */} --}}
    <div class="bg-background p-4 rounded-md border mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-muted-foreground" />
                </div>
                <input type="text" placeholder="Search users..."
                    class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2" />
            </div>
            <div class="w-full md:w-48">
                <select class="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                    <option value="">All Roles</option>
                    <option value="name">Name</option>
                    <option value="country">Country</option>

                </select>
            </div>

        </div>
    </div>
    @if ($denominations->isEmpty())
        {{-- Empty state --}}
        <div class="p-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-fullbg-grey-200">
                <x-heroicon-o-rectangle-group class="h-10 w-10 text-muted-foreground " />
            </div>
            <h3 class="mt-4 text-sm font-medium text-foreground">No denominations found</h3>
            <p class="mt-1 text-sm text-muted-foreground">Get started by creating one.</p>
            <div class="mt-6">
                <a href="{{ route('admin.denominations.create') }}"
                    class="inline-flex items-center rounded-md bg-primary px-3 py-2 text-sm font-medium text-primary-foreground shadow-sm hover:bg-primary/90">
                    <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                    New Denomination
                </a>
            </div>
        </div>
    @else
        {{-- {/* Categories Table */} --}}
        <div class="bg-background rounded-md border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-muted/50">
                        <tr>
                            <th class="text-left px-4 py-3 text-sm font-medium">Name</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Slug</th>
                            <th class="text-left px-4 py-3 text-sm font-medium">Zone</th>

                            <th class="text-left px-4 py-3 text-sm font-medium">Population</th>

                            <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach ($denominations as $denomination)


                            <tr key={{$denomination->id}} class="hover:bg-muted/20">
                                <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                                    <x-heroicon-o-globe-alt class="h-4 w-4 text-gray-500" />
                                    {{$denomination->name}}
                                </td>
                                <td class="px-4 py-4 text-muted-foreground">{{$denomination->slug}}</td>
                                <td class="px-4 py-4 text-muted-foreground">{{$denomination->zone->name}}</td>


                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-muted text-muted-foreground">
                                        {{$denomination->population}}
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center space-x-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.denominations.edit', $denomination->id) }}"
                                            class="p-1 rounded-md hover:bg-muted" title="Edit">
                                            <x-heroicon-c-pencil class="h-4 w-4" />
                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST"
                                            action="{{ route('admin.denominations.destroy', $denomination->id) }}"
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
                {{ $denominations->links() }}
            </div>
            {{-- Empty State --}}
            {{-- <div class="p-8 text-center">
                <div class="mb-4">
                    <Search class="h-12 w-12 mx-auto text-muted-foreground" />
                </div>
                <h3 class="text-lg font-medium">No categories found</h3>
                <p class="text-sm text-muted-foreground mt-1">


                    Create your first category to get started
                </p>

                <Link href="/admin/categories/new"
                    class="inline-block mt-4 px-4 py-2 rounded-md bg-primary text-primary-foreground hover:bg-primary/90">
                Create Category
                </Link>

            </div> --}}

        </div>
    @endif

    {{-- <div class=" fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-background p-6 rounded-md max-w-md w-full">
            <h3 class="text-lg font-medium mb-4">Confirm Deletion</h3>
            <p class="text-muted-foreground mb-6">
                Are you sure you want to delete this category? Portfolios using this category won't be deleted but will
                need to be reassigned.
            </p>
            <div class="flex justify-end gap-4">
                <button onClick={()=> setDeleteConfirm(null)}
                    class="px-4 py-2 rounded-md border hover:bg-muted"
                    >
                    Cancel
                </button>
                <button onClick={()=> handleDelete(deleteConfirm)}
                    class="px-4 py-2 rounded-md bg-red-500 text-white hover:bg-red-600"
                    >
                    Delete
                </button>
            </div>
        </div>
    </div> --}}

</div>