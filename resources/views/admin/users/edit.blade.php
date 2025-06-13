@extends('layouts.admin')

@section('title', 'Edit User')

@section('top-action')
    <a href="{{ route('admin.users') }}"
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back
    </a>
@endsection

@section('content')
    <div>
        <!-- Top header with popup icon -->
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @elseif (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif

        {{-- Form --}}
        @livewire('admin.user-edit-form', ['user' => $user])



@endsection