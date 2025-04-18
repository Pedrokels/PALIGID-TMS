<div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900 p-6 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 class="text-8xl font-bold" wire:transition.fade>{{ $messageCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Province</h3>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border  border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900 p-6 flex items-center justify-center">
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
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900">
            <table class="table-auto w-full">
                <thead>
                    <tr class="">
                        <th class=" px-4 py-2 text-left">Title</th>
                        <th class=" px-4 py-2 text-left">Description</th>
                        <th class=" px-4 py-2 text-left">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    <tr wire:transition wire:key="{{ $message->id }}">
                        <td class=" px-4 py-2">{{ $message->title }}</td>
                        <td class=" px-4 py-2">{{ $message->description }}</td>
                        <td class=" px-4 py-2">
                            <flux:button variant="danger" wire:click="deleteMessage({{ $message->id }})">Delete</flux:button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>