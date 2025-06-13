@extends('layouts.admin')

@section('title', 'Denominations')

@section('top-action')

<a
href={{route('admin.denominations.create')}}
class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
>
<x-heroicon-s-plus-circle class="mr-1 h-5 w-5" />
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
        @elseif (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif


       
        @livewire('admin.denominations-list-with-search', ['denominations' => $denominations])
    </div>

@endsection