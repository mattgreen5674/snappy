<div>

    <div class="max-w-md mx-auto space-y-4">

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact Email Form</h2>

        @if (session()->has('flash'))
            <div 
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 5000)"
                x-show="show"
                class="p-4 rounded text-white"
                :class="{
                    'bg-green-500': '{{ session('flash.type') === 'success' }}',
                    'bg-red-500': '{{ session('flash.type') === 'failure' }}',
                }"
            >
                {{ session('flash.message') }}
            </div>
        @endif

        <!-- Alert Box -->
        <div
            x-data="{ show: false, message: '', type: '' }"
            x-init="
                $wire.on('alert', ({ message: msg, type: t }) => {
                    message = msg;
                    type = t;
                    show = true;
                    setTimeout(() => show = false, 5000);
                });
                
            "
        >
            <div 
                x-show="show" 
                x-transition 
                class="mt-4 p-4 rounded shadow text-white bg-green-500 bg-red-500"
                :class="{
                    'bg-green-500': type === 'success',
                    'bg-red-500': type === 'failure'
                }"
            >
                <p x-text="message"></p>
            </div>
        </div>

        <form wire:submit.prevent="sendEmail" class="space-y-4">
            <div>
                <label>Your name</label>
                <input type="text" wire:model.lazy="fromName" class="input w-full" />
                @error('fromName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Your email address</label>
                <input type="email" wire:model.lazy="fromEmail" class="input w-full" />
                @error('fromEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Comment</label>
                <textarea wire:model.lazy="comment" class="input w-full"></textarea>
                @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Send</button>
        </form>

    </div>        
</div>
