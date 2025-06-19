@extends($layout ?? 'layouts.admin')

@section('title', 'Edit Link Group')

@section('top-action')
    <a href="{{ url()->previous() }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')

    <div class="">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @elseif (session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif
    </div>
    <div class="bg-background rounded-md border p-6 mx-auto mt-4">
        {{-- Flash Messages --}}


        {{-- Group Overview --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl font-semibold text-foreground mb-1">{{ $linkGroup->name }}
                    <span class="text-sm text-muted-foreground">({{ $linkGroup->links->count() }} Links)</span>

                </h2>

            </div>

            <div>
                <a
                    class="inline-flex items-center gap-2 px-4 py-2 bg-secondary text-secondary-foreground text-sm font-medium rounded-md hover:bg-secondary/80 transition-colors">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    Create Link
                </a>
            </div>
        </div>

        {{-- Edit Form --}}
        <form method="POST" action="{{ route('link-group.update', $linkGroup->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Group Title --}}
            <div>
                <label for="name" class="block text-sm font-medium text-muted-foreground mb-1">Group Title</label>
                <input type="text" name="name" id="name" value="{{ old('name', $linkGroup->name) }}"
                    class="block w-full rounded-md border border-muted bg-background text-foreground px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Original URL --}}
            <div>
                <label for="original_url" class="block text-sm font-medium text-muted-foreground mb-1">Original URL</label>
                <input type="url" name="original_url" id="original_url"
                    value="{{ old('original_url', $linkGroup->original_url) }}"
                    class="block w-full rounded-md border border-muted bg-background text-foreground px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
                    required>
                @error('original_url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground text-sm font-medium rounded-md hover:bg-primary/90 transition-colors">
                    <x-heroicon-s-check class="w-4 h-4 mr-2" />
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
