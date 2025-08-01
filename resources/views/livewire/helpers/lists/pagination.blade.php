<div class="w-88 mx-auto">
    <div class="flex items-center justify-center px-4 py-2 space-x-4">

        @if ($currentPage == 1)
            <button class="bg-blue-100 text-white font-semibold w-10 h-10" disabled>
                <i class="fa-solid fa-angle-left fa-lg"></i>
            </button>
        @else
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold w-10 h-10 cursor-pointer" wire:click="update({{ $currentPage - 1 }})">
                <i class="fa-solid fa-angle-left fa-lg"></i>
            </button>
        @endif

        <div class="flex space-x-4 text-lg">
            @foreach ($pagination as $page)
                @if ($page === 'dots')
                    <span>...</span>
                @elseif ($page == $currentPage)
                    <span class="font-bold underline">{{ $page }}</span>
                @else
                    <button wire:click="update({{ $page }})" class="">{{ $page }}</button>
                @endif

            @endforeach
        </div>

        @if ($currentPage == $lastPage)
            <button class="bg-blue-100 text-white font-semibold w-10 h-10" disabled>
                <i class="fa-solid fa-angle-right fa-lg"></i>
            </button>
        @else
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold w-10 h-10 cursor-pointer" wire:click="update({{ $currentPage + 1 }})">
                <i class="fa-solid fa-angle-right fa-lg"></i>
            </button>
        @endif

    </div>
</div>