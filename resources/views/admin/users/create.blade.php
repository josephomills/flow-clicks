@extends('layouts.admin')

@section('title', 'Add New User')

@section('top-action')

    <a
        class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90">

        <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
        Go Back


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
            <div class="bg-background rounded-md border p-6">



                <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('post')
                    <div class="grid gap-6 mb-6">


                        {{-- User Name field --}}
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium">
                                First Name
                            </label>
                            <input type="text" id="first_name" name="first_name"
                                class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                                required placeholder="Enter First Name..." />

                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium">
                                Last Name
                            </label>
                            <input type="text" id="last_name" name="last_name"
                                class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                                required placeholder="Enter Last Name..." />

                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium">
                                Email
                            </label>
                            <input type="email" id="email" name="email"
                                class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                                required placeholder="Enter Email eg. example@gmail ..." />

                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium">
                                Password
                            </label>
                            <input type="text" id="password" name="password"
                                class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 font-mono text-sm"
                                required placeholder="****" />

                        </div>
                        {{-- Admin Denomination Setting field --}}
                        <div>
                            <label for="denomination" class="block mb-2 text-sm font-medium">
                                Denomination
                            </label>
                            <select id="denomination" name="denomination"
                                class="w-full h-10 rounded-md border border-input bg-background px-3 py-2" required
                                placeholder="e.g. Web Design">
                                @foreach ($denominations as $denomination)
                                    <option value="{{ $denomination->id }}">

                                        {{ $denomination->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>








                    </div>

                    {{-- {/* Form actions */} --}}
                    <div class="flex justify-end gap-4">
                        <a href="/admin/categories" class="flex items-center px-4 py-2 rounded-md border hover:bg-muted">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 disabled:opacity-50">
                            Save
                        </button>
                    </div>
                </form>
            </div>


        </div>

    @endsection