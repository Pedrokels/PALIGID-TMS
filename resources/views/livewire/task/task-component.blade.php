<div>
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Title</th>
                <th class="border px-4 py-2 text-left">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
            <tr>
                <td class="border px-4 py-2">{{ $message->title }}</td>
                <td class="border px-4 py-2">{{ $message->description }}</td>
                <td class="border px-4 py-2">
                    <flux:button variant="danger" wire:click="deleteMessage({{ $message->id }})">Delete</flux:button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>