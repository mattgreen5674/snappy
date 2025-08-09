<div>
    <h1 class="text-xl font-bold text-gray-800 mb-5">Players</h1>

    <div class="flex space-x-4 my-5">

        {{-- Search Filter Sort --}}
        <div class="flex-1">
            <livewire:helpers.lists.search
                searchName="Players Search"
            />
        </div>

        <div class="flex-1">
            <livewire:helpers.lists.filter
                :options="$countries"
                selected="0"
                selectName="Country Filter"
            />
        </div>

        <div class="flex-1">
            <livewire:helpers.lists.filter
                :options="$sortOptions"
                selected="0"
                selectName="Players Sort"
                filterName="sort-update"
            />
        </div>

    </div>
    {{-- End Search Filter Sort --}}

    {{-- Players List --}}
    @if ($players->isEmpty())
        <div class="text-gray-500 mt-2">
            There are no players for this selection....
        </div>
    @else
        @foreach ($players as $player)
            <div class="bg-white border border-gray-300 rounded-md p-4 w-auto mb-2">
                <div class="flex flex-wrap space-x-8">

                    <!-- Player detail -->
                    <div class="w-40">
                        <div class="text-gray-500 text-sm font-semibold">Name</div>
                        <div class="text-gray-900 text-base">{{ $player->full_name }}</div>
                    </div>

                    <div class="w-40">
                        <div class="text-gray-500 text-sm font-semibold">Nationality</div>
                        <div class="text-gray-900 text-base">{{ $player->nationality->name }}</div>
                    </div>

                    <div class="w-32">
                        <div class="text-gray-500 text-sm font-semibold">Position</div>
                        <div class="text-gray-900 text-base">{{ $player->position->name }}</div>
                    </div>

                    <div class="w-32">
                        <x:snappy.button-blue
                            :url="route('player.detail', $player->id)"
                            text="View Details"
                            type="button"
                        ></x:snappy.button-blue>
                    </div>


                </div>
            </div>

        @endforeach

        <livewire:helpers.lists.pagination
            :currentPage="$currentPage"
            :lastPage="$lastPage"
            key="{{ md5(json_encode($players)) }}"
        />
    @endif
    {{-- End Players List --}}

</div>
