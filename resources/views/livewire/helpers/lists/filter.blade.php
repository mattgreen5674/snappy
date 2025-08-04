<div class="bg-white border border-gray-300 rounded-md p-4">

    <label for="{{ Str::lower(Str::replace(' ', '-', $selectName)) }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $selectName }}</label>
    <select
        id="{{ Str::lower(Str::replace(' ', '-', $selectName)) }}"
        wire:model.live="selected"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        @foreach ($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    <x:snappy.button-black class="mt-2 max-w-[80px] ml-auto" wire:click="resetFilter()">Reset</x:snappy.button-black>

</div>
