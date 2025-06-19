@extends('layouts.admin')

@section('title', 'Edit Zone')

@section('top-action')
    <a href="{{ route('admin.zones.index') }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')
    <div>
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @elseif (session('error'))
            <x-alert type="danger">{{ session('error') }}</x-alert>
        @endif

        <div class="bg-background rounded-md border p-6">
            <form method="POST" action="{{ route('admin.zones.update', $zone->id) }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 mb-6">
                    {{-- Name field --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $zone->name) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required
                            placeholder="e.g. Web Design" />
                    </div>

                    {{-- Slug field --}}
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium">Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $zone->slug) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required placeholder="e.g. web-design" />
                        <p class="mt-1 text-xs text-muted-foreground">URL-friendly identifier. Must be unique.</p>
                    </div>

                    {{-- Country field --}}
                    <div>
                        <label for="country" class="block mb-2 text-sm font-medium">Country *</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $zone->country) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required placeholder="e.g. Ghana, Nigeria" />
                    </div>
                </div>

                {{-- Form actions --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.zones.index') }}"
                        class="flex items-center px-4 py-2 rounded-md border hover:bg-muted">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 disabled:opacity-50">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection