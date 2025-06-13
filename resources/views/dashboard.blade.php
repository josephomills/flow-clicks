@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <!-- Stats overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                [
                    'title' => 'Created Links',
                    'value' => '48',
                    'description' => 'Total published posts',
                    'icon' => '<x-heroicon-m-link class="h-8 w-8 text-blue-500" />',
                    'change' => '+12%',
                    'trend' => 'up'
                ],
                [
                    'title' => 'User Clicks',
                    'value' => '24',
                    'description' => 'Case studies and projects',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-purple-500"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
                    'change' => '+8%',
                    'trend' => 'up'
                ],
               
                [
                    'title' => 'Team Members',
                    'value' => '8',
                    'description' => 'Active team members',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-amber-500"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                    'change' => '0%',
                    'trend' => 'neutral'
    ],
    [
                    'title' => 'Tokens Left',
                    'value' => '12',
                    'description' => 'Number of links left',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-green-500"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                    'change' => '-3%',
                    'trend' => 'down'
                ],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-background p-6 rounded-md border">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-muted-foreground text-sm">
                            {{ $stat['title'] }}
                        </p>
                        <h3 class="text-3xl font-bold">{{ $stat['value'] }}</h3>
                    </div>
                    <div>{!! $stat['icon'] !!}</div>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-xs text-muted-foreground">
                        {{ $stat['description'] }}
                    </p>
                    <div class="text-xs font-medium {{ 
                        $stat['trend'] === 'up' ? 'text-green-500' : 
                        ($stat['trend'] === 'down' ? 'text-red-500' : 'text-muted-foreground') 
                    }}">
                        {{ $stat['change'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Recent activity -->
    <div class="bg-background p-6 rounded-md border mb-8">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        <div class="space-y-4">
            @foreach([1, 2, 3] as $index)
                <div class="flex items-center justify-between border-b pb-4 last:border-0">
                    <div>
                        <h3 class="font-medium">
                            New blog post published: "The Role of Animation in Modern Web Design"
                        </h3>
                        <p class="text-sm text-muted-foreground">
                            @if($index === 1)
                                Today at 10:32 AM
                            @elseif($index === 2)
                                Yesterday at 4:15 PM
                            @else
                                2 days ago at 1:45 PM
                            @endif
                        </p>
                    </div>
                    <a
                        href="#"
                        class="flex flex-row justify-center items-center text-sm text-accent hover:text-accent/80"
                    >
                    <x-heroicon-s-eye class="w-4 h-4 mr-2 text-black" />
                        View
                        

                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Quick actions -->
    <div class="bg-background p-6 rounded-md border">
        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a
                href="/admin/posts/new"
                class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
            >
                Create New Post
            </a>
            <a
                href="/admin/portfolios/new"
                class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
            >
                Add Portfolio Item
            </a>
            <a
                href="/admin/team/new"
                class="bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90"
            >
                Add Team Member
            </a>
        </div>
    </div>
@endsection