<!-- Tabs -->
<div class="flex items-center justify-between border-b">
    <nav class="-mb-px flex space-x-8">
        <button id="denomination-tab"
            class="tab-button active border-b-2 border-primary text-primary px-1 py-4 text-sm font-medium">
            By Denomination
        </button>
        <button id="zone-tab"
            class="tab-button border-b-2 border-transparent text-muted-foreground hover:text-primary px-1 py-4 text-sm font-medium">
            By Zone
        </button>
        <button id="date-tab"
            class="tab-button border-b-2 border-transparent text-muted-foreground hover:text-primary px-1 py-4 text-sm font-medium">
            By Date
        </button>
    </nav>

    <div class="flex items-center space-x-2">
        <div class="relative">
            <select class="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm appearance-none pr-8">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 90 days</option>
                <option selected>Custom Range</option>
            </select>
            <x-heroicon-s-chevron-down class="absolute right-3 top-3 h-4 w-4 text-muted-foreground" />
        </div>
        <button
            class="flex items-center bg-primary text-primary-foreground px-4 py-2 rounded-md hover:bg-primary/90 text-sm">
            <x-heroicon-s-arrow-down-tray class="mr-1 h-4 w-4" />
            Export
        </button>
    </div>
</div>

<!-- Tab Content -->
<div class="py-4">
    <!-- Denomination Tab Content -->
    <div id="denomination-content" class="tab-content active">
        {{-- @livewire('admin.analytics.clicks-by-denominations-table') --}}
        @livewire('admin.analytics.clicks-by-denominations')
    </div>

    <!-- Zone Tab Content -->
    <div id="zone-content" class="tab-content hidden">
        @livewire('admin.analytics.clicks-by-zones')
    </div>

    <!-- Date Tab Content -->
    <div id="date-content" class="tab-content hidden">
        @livewire('admin.analytics.clicks-by-date')
    </div>
</div>
</div>

{{-- @push('scripts') --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tab switching functionality
        const tabs = {
            'denomination-tab': 'denomination-content',
            'zone-tab': 'zone-content',
            'date-tab': 'date-content'
        };

        Object.entries(tabs).forEach(([tabId, contentId]) => {
            const tab = document.getElementById(tabId);
            const content = document.getElementById(contentId);

            tab.addEventListener('click', () => {
                // Hide all content and deactivate all tabs
                document.querySelectorAll('.tab-content').forEach(el => {
                    el.classList.add('hidden');
                    el.classList.remove('active');
                });
                document.querySelectorAll('.tab-button').forEach(el => {
                    el.classList.remove('active', 'border-primary', 'text-primary');
                    el.classList.add('border-transparent', 'text-muted-foreground');
                });

                // Show selected content and activate tab
                content.classList.remove('hidden');
                content.classList.add('active');
                tab.classList.add('active', 'border-primary', 'text-primary');
                tab.classList.remove('border-transparent', 'text-muted-foreground');
            });
        });
    });
</script>