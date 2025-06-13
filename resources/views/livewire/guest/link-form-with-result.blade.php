<div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
    @include('home.partials.pill-announcement')

    <div class="text-center">
        <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl animate-slide-up">
            Shorten your next link
        </h1>
    </div>

    {{-- Searchbar --}}
    <form wire:submit.prevent="submit">
        <label class="mx-auto mt-8 relative bg-white min-w-sm max-w-2xl flex flex-col md:flex-row items-center justify-center border py-2 px-2 rounded-2xl gap-2 shadow-2xl"
               for="link-input">
    
            <input id="link-input"
                   placeholder="https://facebook.com/...."
                   wire:model="linkUrl"
                   class="px-6 py-2 w-full rounded-md flex-1 outline-none bg-white"
                   required
                   type="url">
    
            <button type="submit"
                    class="w-full md:w-auto px-6 py-3 bg-kanik-brown-300 text-white rounded-lg transition-all disabled:opacity-75 relative">
                <span>Shorten</span>
            </button>
        </label>

    </form>

{{-- Result --}}
@php
    $host = request()->getHost();
    $port = request()->getPort();
    $protocol = request()->isSecure() ? 'https' : 'http';

    // Use 'click.' subdomain only if not localhost
    $clickDomain = $host === 'localhost'
        ? "{$protocol}://click.localhost:{$port}"
        : "{$protocol}://click.{$host}";
@endphp

@if ($createdLink)
    <section class="mt-10 bg-white p-8 rounded-xl shadow-lg">
        <div class="space-y-6">
            <!-- Short Link Card with Copy Button -->
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-gray-800">Your Short Link</h2>
                <div class="flex items-center gap-2 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <code class="flex-1 text-kanik-brown-400 font-mono break-all hover:text-kanik-brown-600 transition-colors">
                        {{ "{$clickDomain}/{$createdLink->short_url}" }}
                    </code>
                    <button 
                        onclick="copyToClipboard('{{ "{$clickDomain}/{$createdLink->short_url}/default" }}')"
                        class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors"
                        title="Copy to clipboard"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-gray-500">Default tracking URL</p>
            </div>

            <!-- Denominations Table with Copy Actions -->
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 p-4 bg-gray-50 border-b">
                    Custom Links by Denomination
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Denomination
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tracking Link
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($denominations as $denomination)
                                @php
                                    $url = "{$clickDomain}/{$createdLink->short_url}/{$denomination->slug}";
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">
                                        {{ $denomination->name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ $url }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-blue-600 hover:text-blue-800 hover:underline transition-colors break-all">
                                            {{ $url }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button 
                                            onclick="copyToClipboard('{{ $url }}')"
                                            class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded transition-colors"
                                            title="Copy to clipboard"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Optional: Show a tooltip or temporary message
                const originalTitle = event.currentTarget.getAttribute('title');
                event.currentTarget.setAttribute('title', 'Copied!');
                setTimeout(() => {
                    event.currentTarget.setAttribute('title', originalTitle);
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
@endif


</div>
