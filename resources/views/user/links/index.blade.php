@extends('layouts.user')    

@section('title', auth()->user()->denomination?->name ?? 'My Links')
@section('top-action')

<a
href='{{route('user.links.create')}}'
class="flex flex-row items-center bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
>
<x-heroicon-s-plus-circle class="mr-1 h-4 w-4" />
Create New
</a>

@endsection


@section('content')
    <div class="">
        <!-- Top header with popup icon -->
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
        {{-- @livewire('') --}}

            @livewire('user.links-list-with-search')
       
    </div>

@endsection