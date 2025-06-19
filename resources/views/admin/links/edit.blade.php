@extends('layouts.admin')

@section('title', 'Edit Link Group')

@section('top-action')
<a href="{{ url()->previous() }}"
class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
  <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
  Go Back
</a>
@endsection

@section('content')
<div class="bg-background rounded-md border p-6">
  @if (session('success'))
    <x-alert type="success">
      {{ session('success') }}
    </x-alert>
  @elseif (session('error'))
    <x-alert type="danger">
      {{ session('error') }}
    </x-alert>
  @endif


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    </div>
      <!-- Column 1 -->
    
@endsection