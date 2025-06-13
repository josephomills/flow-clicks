@extends('layouts.admin')

@section('title', 'Member Invite')

@section('top-action')

  <a href="{{ route('admin.users') }}"
    class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">
    <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
    Go Back
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

    {{-- <form action="{{ route('invite') }}" method="post">
    {{ csrf_field() }}
    <input type="email" name="email" />
    <button type="submit">Send invite</button>
    </form> --}}
    <div>
    <form method="post" action="{{ route('invite') }}" class="mt-6 space-y-6">
      @csrf
      @method('post')
      <div class="grid gap-6 mb-6">
      {{-- Invitee Email field --}}
      <div>
        <label for="email" class="block mb-2 text-sm font-medium">
        Email *
        </label>
        <input type="email" id="email" name="email"
        class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required
        placeholder="e.g. example@gmail.com..." />
      </div>


      </div>



      {{-- {/* Form actions */} --}}
      <div class="flex justify-end gap-4">
      <a href="#" class="flex items-center px-4 py-2 rounded-md border hover:bg-muted">
        Cancel
      </a>
      <button type="submit"
        class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 disabled:opacity-50">
        Invite
      </button>
      </div>
    </form>
    </div>

  </div>

@endsection