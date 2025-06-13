<div class=" items-center h-96 bg-blue-50 w-full flex justify-center rounded-md shadow-sm"> 
    <div class="flex flex-col justify-between items-center self-center">
        <x-heroicon-o-clipboard class="flex-shrink-0 w-12 h-12" aria-hidden="true" />
        <h1 class="font-semibold text-base">No Links Available</h1>
        <p class="text-gray-500 text-base text-center">Your have not created any links yet</p>
        <button 
        @click="focusLinkInput()"
            class="flex bg-green-500 text-white hover:bg-green-600 p-2 rounded-md text-sm items-center focus:ring-green-500 justify-center max-w-xs gap-2 mt-4">
            <x-heroicon-o-plus class="flex-shrink-0 w-5 h-5" aria-hidden="true" />
            Add New Link
        </button>
    </div>
</div>
