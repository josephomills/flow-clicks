<div class="m-0">
    {{-- Search and filters --}}
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
                    <option value="country">Denomination</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Categories Table --}}
    <div class="bg-background rounded-md border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-muted/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-medium">Name</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Email</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Role</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Denomination(s)</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Updated At</th>
                        <th class="text-left px-4 py-3 text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @foreach ($users as $user)
                        <tr key="{{ $user->id }}" class="hover:bg-muted/20">
                            <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                                <x-heroicon-o-user class="h-4 w-4 text-gray-500" />
                                {{ $user->first_name }}
                            </td>
                            <td class="px-4 py-4 text-muted-foreground">{{ $user->email }}</td>
                            <td class="px-4 py-4 text-muted-foreground">{{ $user->role }}</td>

                            <td class="px-4 py-4 text-muted-foreground">
                                <div class="flex gap-1 flex-wrap">
                                    @foreach ($user->denominations as $denomination)
                                    <dfn title={{$denomination->name}} class="bg-muted text-xs text-gray-800 rounded-md p-1 w-fit">{{$denomination->slug}}</dfn>
                                @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4 text-muted-foreground">{{ $user->updated_at->diffForHumans() }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="p-1 rounded-md hover:bg-muted" title="Edit">
                                        <x-heroicon-c-pencil class="h-4 w-4" />
                                    </a>
                                    {{-- Delete form --}}
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
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
            {{ $users->links() }}
        </div>

    </div>
</div>
