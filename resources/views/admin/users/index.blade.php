@extends('layouts.admin')

@section('title', 'Team Members')
@section('top-action')

<div class="flex flex-row items-center space-x-2">
    <a
href="{{route('admin.users.create')}}"
class="flex flex-row items-center bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
>
<x-heroicon-s-plus-circle class="mr-1 h-4 w-4" />
Create New
</a>
<a
href={{route('invite')}}
class="flex flex-row items-center bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
>
<x-heroicon-s-plus-circle class="mr-1 h-4 w-4" />
Invite
</a>
</div>

@endsection


@section('content')
    <div class="">
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

            @livewire('admin.users-list-with-search')
       
    </div>

@endsection