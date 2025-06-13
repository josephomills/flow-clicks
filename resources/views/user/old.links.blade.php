@extends('layouts.user')

@section('title', 'My Links')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        My Links
    </h2>
@endsection

@section('content')
    <div class="container-kanik">
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

        <div x-data="{ focusLinkInput: () => document.getElementById('original_url')?.focus() }">
            <!-- Create new link section -->
            @include('user.partials.create-link-form')

            @livewire('user.links-list-with-search')
        </div>
    </div>
@endsection
