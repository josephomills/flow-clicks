<aside class="w-full lg:w-64 space-y-1">
    <div class="text-sm font-medium text-muted-foreground mb-4">
        LINKS MANAGEMENT
    </div>
    <a
        href="/admin/links"
        class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
    >
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5 w-5 text-muted-foreground">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <span>Links</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>

  
  
    <a
        href="/admin/users"
        class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50" . {{request()->routeIs('/admin.users') ? ' bg-kanik-brown-100/40': ''}}
    >
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5 w-5 text-muted-foreground">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Team Members</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>
    <a
        href="/admin/denominations"
        class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
    >
        <div class="flex items-center">
            <x-heroicon-o-rectangle-group class="mr-2 h-5 w-5 text-muted-foreground" />
            <span>Denominations</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>
    <a
        href="/admin/zones"
        class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
    >
        <div class="flex items-center">
            <x-heroicon-o-rectangle-group class="mr-2 h-5 w-5 text-muted-foreground" />
            <span>Zones</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>

    <a
    href="/admin/analytics"
    class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
>
    <div class="flex items-center">
        <x-heroicon-o-chart-bar class="mr-2 h-5 w-5 text-muted-foreground" />
        <span>Analytics</span>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
        <polyline points="9 18 15 12 9 6"/>
    </svg>
</a>

    <a
    href="/admin/clicks"
    class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
>
    <div class="flex items-center">
        <x-heroicon-o-cursor-arrow-rays class="mr-2 h-5 w-5 text-muted-foreground" />
        <span>Link Clicks</span>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
        <polyline points="9 18 15 12 9 6"/>
    </svg>
</a>

    <a
        href="/admin/settings"
        class="flex items-center justify-between p-3 rounded-md bg-background border hover:bg-muted/50"
    >
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5 w-5 text-muted-foreground">
                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
            <span>Settings</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-muted-foreground">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </a>
</aside>