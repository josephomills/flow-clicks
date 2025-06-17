@extends('layouts.admin')

@section('title', 'Edit Denomination')

@section('top-action')
    <a href="{{ route('admin.denominations') }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')
    <div class="">
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @elseif (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif

        <div class="bg-background rounded-md border p-6">
            <form method="POST" action="{{ route('admin.denominations.update', $denomination->id) }}"
                class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 mb-6">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $denomination->name) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required />
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium">Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $denomination->slug) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required />
                        <p class="mt-1 text-xs text-muted-foreground">
                            URL-friendly identifier. Must be unique.
                        </p>
                    </div>

                    {{-- avg_attendance --}}
                    <div>
                        <label for="avg_attendance" class="block mb-2 text-sm font-medium">avg_attendance *</label>
                        <input type="number" id="avg_attendance" name="avg_attendance"
                            value="{{ old('avg_attendance', $denomination->avg_attendance) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required />
                        <p class="mt-1 text-xs text-muted-foreground">Should be digits</p>
                    </div>

                    {{-- Country --}}
                    <div>
                        <label for="country" class="block mb-2 text-sm font-medium">Country *</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $denomination->country) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required />
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block mb-2 text-sm font-medium">City *</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $denomination->city) }}"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                            required />
                    </div>

                    {{-- Zone --}}
                    <div>
                        <label for="zone" class="block mb-2 text-sm font-medium">Zone</label>
                        <select id="zone" name="zone_id"
                            class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" {{ $zone->id == old('zone_id', $denomination->zone_id) ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Form actions --}}
                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.denominations') }}"
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