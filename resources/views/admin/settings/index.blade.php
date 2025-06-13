@extends('layouts.admin')

@section('title', 'Settings')

@section('top-action')
{{-- 
<a
class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">

<x-heroicon-s-arrow class="mr-1 h-5 w-5" />
Go Back
</a> --}}

@endsection

@section('content')
    <div >
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

 
            {{--  Form  --}}
            <div class="bg-background rounded-md border p-6">
             
          
    
              <form method="post" action="{{ route('admin.settings.store') }}" class="mt-6 space-y-6">
                @csrf
                @method('post')
                @csrf
                <div class="grid gap-6 mb-6">

                     <input
                      type="text"
                      id="userID"
                      name="userID"
                     value="{{ $current_user->id }}"
                      class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                      required
                     hidden
                    />
                       {{--  User Name field  --}}
                  <div>
                    <label for="country" class="block mb-2 text-sm font-medium">
                      Username
                    </label>
                    <input
                      type="text"
                      id="country"
                      name="name"
                     value="{{ $current_user->name }}"
                      class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                      required
                      placeholder="e.g. Enter Name..."
                    />
                  
                  </div>
                  {{--  Admin Denomination Setting field --}}
                  <div>
                    <label for="name" class="block mb-2 text-sm font-medium">
                      Denomination
                    </label>
                    <select
    
                      id="denomination"
                      name="denomination"
                      class="w-full h-10 rounded-md border border-input bg-background px-3 py-2"
                      required
                      placeholder="e.g. Web Design"
                      
                    >
                    @foreach ($denominations as $denomination)
    <option value="{{ $denomination->id }}" 
        {{ $current_user->denomination_id == $denomination->id ? 'selected' : '' }}>
        {{ $denomination->name }}
    </option>
@endforeach

                    </select>
                  </div>
    
               
    

                 
                
         
    
                </div>
    
                {{-- {/* Form actions */} --}}
                <div class="flex justify-end gap-4">
                  <a
                    href="/admin/categories"
                    class="flex items-center px-4 py-2 rounded-md border hover:bg-muted"
                  >
                    Cancel
                  </a>
                  <button
                    type="submit"
                
                    class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 disabled:opacity-50"
                  >
                    Save
                  </button>
                </div>
              </form>
            </div>
    
       
    </div>

@endsection