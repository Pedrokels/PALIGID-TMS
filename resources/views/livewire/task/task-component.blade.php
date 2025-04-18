<div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900 p-6 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 class="text-8xl font-bold" wire:transition.fade>{{ $messageCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Province</h3>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900 p-6 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 wire:transition class="text-8xl font-bold">{{ $messageCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Municipality</h3>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900 p-6 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 wire:transition class="text-8xl font-bold">{{ $messageCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Barangay</h3>
                </div>
            </div>
        </div>

        <h1 class="text-2xl font-bold">Transmission Status:</h1>
        <div x-data="{ latestId: null, transmittedTime: null }" x-init="
            window.addEventListener('new-message-id', event => {
                latestId = event.detail.id;
                transmittedTime = 0;
                const interval = setInterval(() => {
                    transmittedTime++;
                }, 1000);
                setTimeout(() => {
                    latestId = null;
                    clearInterval(interval);
                }, 5000);
            });
        " class="relative h-full flex-1 overflow-hidden rounded-xl space-y-2">
            @if ($messages)
            @foreach ($messages as $message)
            <div wire:transition.scale.origin.top wire:key="{{ $message->id }}"
                x-data
                :class="latestId === {{ $message->id }} ? 'bg-neutral-600' : 'bg-neutral-50 dark:bg-neutral-900'"
                class="p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm transition-all duration-500">
                <h2 class="text-xl font-bold mb-2">{{ $message->id . ' ' . $message->title }}</h2>
                <p class="text-sm mb-4">{{ $message->description }}</p>
                <p x-show="latestId === {{ $message->id }}" class="text-sm text-gray-500">Transmitted <span x-text="transmittedTime"></span> sec ago</p>
                <flux:button variant="danger" wire:click="deleteMessage({{ $message->id }})">Delete</flux:button>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>