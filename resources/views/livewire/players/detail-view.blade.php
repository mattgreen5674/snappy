<div>
    <h1 class="text-xl font-bold text-gray-800 mb-5">
        Player:
        <span class="text-lg font-bold text-gray-500">{{ $player->full_name }}</span>
    </h1>
    <div class="bg-white border border-gray-300 rounded-md p-4">
        <div class="grid grid-cols-2">
            <div class="m-auto">
                <img
                    src="{{ $player->image_path }}"
                    alt="{{ $player->full_name . ' image' }}"
                    width="350"
                    height="450"
                >
            </div>
            <div class="border border-gray-300 rounded-md p-4">

                <div class="grid grid-cols-2">
                    <div>
                        <p class="font-bold text-gray-800">First Name:</p>
                        <p>{{ $player->first_name }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Last Name:</p>
                        <p>{{ $player->last_name }}</p>
                    </div>
                <div>

                <div class="mt-5">
                    <p class="font-bold text-gray-800">DOB:</p>
                    <p>{{ \Carbon\Carbon::parse($player->date_of_birth)->format('d-m-Y') }}</p>
                </div>

                <div class="mt-5">
                    <p class="font-bold text-gray-800">Gender:</p>
                    <p>{{ ucwords($player->gender) }}</p>
                </div>

                <div class="mt-5">
                    <p class="font-bold text-gray-800">Nationality:</p>
                    <p>{{ $player->nationality->name }}</p>
                </div>

                <div class="grid grid-cols-2 mt-5">
                    <div>
                        <p class="font-bold text-gray-800">Player Type:</p>
                        <p>{{ $player->parentPosition->name }}</p>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Position:</p>
                        <p>{{ $player->position->name }}</p>
                    </div>
                <div>

            </div>
        </div>
    </div>
</div>
