<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-3 gap-3">

                        <div class="bg-white border border-gray-300 rounded-md p-4">
                            <h1 class="text-xl font-bold text-gray-800 mb-5">
                                Players List
                            </h1>
                            <x:snappy.button-blue
                                :url="route('players')"
                                text="View"
                                type="button"
                            ></x:snappy.button-blue>
                        </div>

                        <div class="bg-white border border-gray-300 rounded-md p-4">

                            <h1 class="text-xl font-bold text-gray-800 mb-5">
                                Send Email
                            </h1>
                            <x:snappy.button-blue
                                :url="route('emails.contact_email')"
                                text="Create"
                                type="button"
                            ></x:snappy.button-blue>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
