<div class="bg-background p-6 rounded-md border mb-8">
    <h2 class="text-xl font-semibold mb-4">Recent Links</h2>
    <div class="space-y-4">
        @foreach ($recentLinks as $link)
            <div class="flex items-center justify-between border-b pb-4 last:border-0">
                <div>
                    <h3 class="font-medium">
                        {{ $link->title }} -
                        <span class="text-muted-foreground text-sm">{{ $link->denomination->name ?? 'No Denomination' }}
                        </span>
                    </h3>
                    <p class="text-sm text-muted-foreground">

                        Created on {{ \Carbon\Carbon::parse($link->created_at)->format('M d, Y') }}


                    </p>
                </div>
                <a href="#"
   class="inline-flex items-center gap-1.5 rounded-full border border-muted bg-muted px-3 py-1.5 text-sm font-medium text-muted-foreground hover:bg-muted/80 transition-colors">
   <x-heroicon-s-clipboard class="w-4 h-4" />
   Copy
</a>


            </div>
        @endforeach
    </div>
</div>
