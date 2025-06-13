<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flow Clicks - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles <!-- This can stay in head -->
</head>

<body class="min-h-screen bg-muted">
    <!-- Admin header -->
    @include('layouts.partials.header')

    <div class="container-kanik py-8 p-5">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Include sidebar -->
            @include('layouts.partials.admin-sidebar')

            <!-- Main content -->
            <main class="flex-1">
                <div class="flex flex-row justify-between pb-2">
                    <x-page-title>@yield('title')</x-page-title>
                    @yield('top-action')
                </div>
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts <!-- This should be just before </body> -->
</body>

</html>