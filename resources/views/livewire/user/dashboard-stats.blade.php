  <!-- Stats overview -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $stats = [
            [
                'title' => 'Created Links',
                'value' => $linksCount,
                'description' => 'Total links created',
                'icon' => '<svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 7H16C18.7614 7 21 9.23858 21 12C21 14.7614 18.7614 17 16 17H14M10 7H8C5.23858 7 3 9.23858 3 12C3 14.7614 5.23858 17 8 17H10M8 12H16" stroke="#FF0044" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
            [
                'title' => 'User Clicks',
                'value' => $clicksCount,
                'description' => 'Total clicks on all links',
                'icon' => '<svg class="h-8 w-8 text-yellow-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 7L5.5 5.5M15 7L16.5 5.5M5.5 16.5L7 15M11 5L11 3M5 11L3 11M17.1603 16.9887L21.0519 15.4659C21.4758 15.3001 21.4756 14.7003 21.0517 14.5346L11.6992 10.8799C11.2933 10.7213 10.8929 11.1217 11.0515 11.5276L14.7062 20.8801C14.8719 21.304 15.4717 21.3042 15.6375 20.8803L17.1603 16.9887Z" stroke="#00ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>',
                
            ],
           
            
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="bg-background p-6 rounded-md border">
            <div class="flex justify-between items-end mb-4">
                <div>
                    <p class="text-muted-foreground text-md">
                        {{ $stat['title'] }}
                    </p>
                    <h3 class="text-3xl font-bold">{{ $stat['value'] }}</h3>
                </div>
                <div class="bg-muted rounded-full p-3">{!! $stat['icon'] !!}</div>
            </div>
            
        </div>
    @endforeach
</div>