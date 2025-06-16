@extends('layouts.admin')

@section('title', 'Dashboard')
@section('top-action')

<a
    href="{{route('admin.links.create')}}"
    class="flex flex-row items-center bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
    <x-heroicon-s-plus-circle class="mr-1 h-4 w-4" />
    Create New
</a>

@endsection


@section('content')


@livewire('admin.dashboard-stats')

<!-- Recent links -->
@livewire('admin.dashboard-recent-links')


<!-- Quick actions -->
<div class="bg-background p-6 rounded-md border">
    <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a
            href="{{route('admin.links.create')}}"
            class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
            Create New Link
        </a>
        <a
            href={{route('admin.denominations.create')}}
            class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
            Add Denomination
        </a>
        <a
            href="/admin/users/new"
            class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
            Add User
        </a>
    </div>
</div>
@endsection