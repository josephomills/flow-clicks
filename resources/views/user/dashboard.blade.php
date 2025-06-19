@extends('layouts.user')

@section('title', auth()->user()->denomination?->name ?? 'Dashboard')
@section('top-action')

<button
href="#"
class="flex flex-row items-center bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
>
<x-heroicon-s-plus-circle class="mr-1 h-4 w-4" />
Create New
</button>

@endsection


@section('content')


  @livewire('user.dashboard-stats')
  
  <!-- Recent links -->
  @livewire('user.dashboard-recent-links')
   

    <!-- Quick actions -->
    <div class="bg-background p-6 rounded-md border">
        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a
            href={{route('user.links.create')}}
                class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
            >
                Create New Link
            </a>
           
        </div>
    </div>
@endsection