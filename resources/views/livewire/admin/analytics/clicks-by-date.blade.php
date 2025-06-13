<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-border">
        <thead class="bg-muted/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Facebook Clicks</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">YouTube Clicks</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Total Clicks</th>
                <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
            </tr>
        </thead>
        <tbody class="bg-background divide-y divide-border">
            @forelse ($clicksByDate as $data)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        {{ \Carbon\Carbon::parse($data['date'])->format('F j, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ $data['facebook_clicks'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        {{ $data['youtube_clicks'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                        {{ $data['total_clicks'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-primary hover:text-primary/80">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-muted-foreground">
                        No click data available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
