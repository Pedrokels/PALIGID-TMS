<div>
    <flux:button variant="primary" wire:click="sendEvent">Send event</flux:button>
    <flux:input wire:model="message" />

    {{ $message }}
</div>