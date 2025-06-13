<div class="bg-background p-6 rounded-md border mb-8">
    <h2 class="text-xl font-semibold mb-4">Recent Links</h2>
    <div class="space-y-4">
        @foreach($recentLinks as $link)
            <div class="flex items-center justify-between border-b pb-4 last:border-0">
                <div>
                    <h3 class="font-medium">
                        {{$link->short_url}}
                    </h3>
                    <p class="text-sm text-muted-foreground">
                        
                        Created on {{ \Carbon\Carbon::parse($link->created_at)->format('M d, Y') }}

                       
                    </p>
                </div>
                <a
                    href="#"
                    class="flex flex-row justify-center items-center text-sm  text-accent border p-2 rounded-md border-kanik-brown-500 hover:text-accent/80"
                >
                <x-heroicon-s-clipboard class="w-4 h-4 mr-2 text-kanik-brown-500" />
                    Copy
                    

                </a>
            </div>
        @endforeach
    </div>
</div>