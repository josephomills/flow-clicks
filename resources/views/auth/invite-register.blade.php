@extends('layouts.app')

@section('content')
<section class="flex min-h-screen bg-zinc-50 px-4 py-16 md:py-32 dark:bg-transparent">
    <form 
        method="POST" 
        action="{{ route('invite.complete', $invite->token) }}"
        class="bg-card m-auto h-fit w-full max-w-sm rounded-[calc(var(--radius)+.125rem)] border p-0.5 shadow-md dark:[--color-muted:var(--color-zinc-900)]">
        @csrf

        <div class="p-8 pb-6">
            <div>
                <a href="/" aria-label="go home">
                    <!-- Your logo here -->
                    <svg class="w-10 h-10" viewBox="0 0 24 24">
                        <!-- Your logo SVG path -->
                    </svg>
                </a>
                <h1 class="text-title mb-1 mt-4 text-xl font-semibold">Complete Your Registration</h1>
                <p class="text-sm">Please fill in your details to complete registration</p>
            </div>

            <div class="mt-6 space-y-5">
                <!-- Email (disabled) -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm">
                        Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium cursor-not-allowed opacity-50" 
                        value="{{ $invite->email }}" 
                        disabled>
                </div>

                <!-- First Name -->
                <div class="space-y-2">
                    <label for="first_name" class="block text-sm">
                        First Name *
                    </label>
                    <input 
                        id="first_name" 
                        type="text" 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('first_name') border-red-500 @enderror" 
                        name="first_name" 
                        value="{{ old('first_name') }}" 
                        required 
                        autocomplete="given-name" 
                        autofocus>

                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="space-y-2">
                    <label for="last_name" class="block text-sm">
                        Last Name *
                    </label>
                    <input 
                        id="last_name" 
                        type="text" 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('last_name') border-red-500 @enderror" 
                        name="last_name" 
                        value="{{ old('last_name') }}" 
                        required 
                        autocomplete="family-name">

                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm">
                        Password *
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 @error('password') border-red-500 @enderror" 
                        name="password" 
                        required 
                        autocomplete="new-password">

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password-confirm" class="block text-sm">
                        Confirm Password *
                    </label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password">
                </div>

                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                    Complete Registration
                </button>
            </div>
        </div>

        <div class="bg-muted rounded-(--radius) border p-3">
            <p class="text-accent-foreground text-center text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 underline-offset-4 hover:underline px-2 text-primary">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</section>
@endsection