<div class="bg-white border border-gray-300 rounded-md p-4">

    <label for="{{ Str::lower(Str::replace(' ', '-', $searchName)) }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $searchName }}</label>
    <input
        id="{{ Str::lower(Str::replace(' ', '-', $searchName)) }}"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        wire:model.live="searchTerm"
        type="text"
    />
    <x:snappy.button-black class="mt-2 max-w-[80px] ml-auto" wire:click="resetSearch()">Reset</x:snappy.button-black>
</div>
