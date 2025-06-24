<div class="m-0">
    {{-- Search and filters --}}
    <div class="bg-background p-4 rounded-md border mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-muted-foreground" />
                </div>
                <input type="text"
                       placeholder="Search users..."
                       wire:model.live.debounce.300ms="search"
                       class="pl-10 w-full h-10 rounded-md border border-input bg-background px-3 py-2" />
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="roleFilter"
                        class="w-full h-10 rounded-md border border-input bg-background px-3 py-2">
                    <option value="">All Roles</option>
                    @foreach(['admin', 'user', 'moderator'] as $role)
                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Loading indicator --}}
    <div wire:loading wire:target="search,roleFilter" class="mb-4">
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
            <div class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Searching...
            </div>
        </div>
    </div>

    {{-- Users Table --}}
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
                @forelse ($users as $user)
                    <tr key="{{ $user->id }}" class="hover:bg-muted/20">
                        <td class="flex flex-row gap-2 items-center px-4 py-4 font-medium text-sm">
                            <x-heroicon-o-user class="h-4 w-4 text-gray-500" />
                            {{ $user->first_name }} {{ $user->last_name }}
                        </td>
                        <td class="px-4 py-4 text-muted-foreground">{{ $user->email }}</td>
                        <td class="px-4 py-4 text-muted-foreground">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($user->role) }}
                                </span>
                        </td>

                        <td class="px-4 py-4 text-muted-foreground">
                            <div class="flex gap-1 flex-wrap">
                                @foreach ($user->denominations as $denomination)
                                    <dfn title="{{ $denomination->name }}"
                                         class="bg-muted text-xs text-gray-800 rounded-md p-1 w-fit">
                                        {{ $denomination->slug }}
                                    </dfn>
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
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">
                            @if($search || $roleFilter)
                                <div class="flex flex-col items-center space-y-2">
                                    <x-heroicon-o-magnifying-glass class="h-8 w-8 text-muted-foreground" />
                                    <p>No users found matching your search criteria.</p>
                                    <button wire:click="$set('search', '')"
                                            wire:click="$set('roleFilter', '')"
                                            class="text-sm text-blue-600 hover:text-blue-800">
                                        Clear filters
                                    </button>
                                </div>
                            @else
                                <div class="flex flex-col items-center space-y-2">
                                    <x-heroicon-o-user-group class="h-8 w-8 text-muted-foreground" />
                                    <p>No users found.</p>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-4 px-4 pb-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Results summary --}}
    @if($users->total() > 0)
        <div class="mt-4 text-sm text-muted-foreground">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
            @if($search)
                for "<strong>{{ $search }}</strong>"
            @endif
            @if($roleFilter)
                filtered by role: <strong>{{ ucfirst($roleFilter) }}</strong>
            @endif
        </div>
    @endif
</div>
