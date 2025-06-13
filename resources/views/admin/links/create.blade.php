@extends('layouts.admin')

@section('title', 'Create New Link')

@section('top-action')
    <a href="{{ route('admin.links') }}"
        class="flex items-center bg-primary text-primary-foreground py-2 px-4 rounded-md hover:bg-primary/90 text-sm">
        <x-heroicon-s-arrow-left class="h-4 w-4 mr-1" />
        Back to Links
    </a>
@endsection
@if (session('success'))
    <x-alert type="success">
        {{ session('success') }}
    </x-alert>
    <x-alert type="success">
        {{ session('delete-success') }}
    </x-alert>
@elseif (session('error'))
    <x-alert type="danger">
        {{ session('error') }}
    </x-alert>
@endif
@section('content')
    {{-- some livewire component here --}}
    @livewire('create-link-form')
@endsection