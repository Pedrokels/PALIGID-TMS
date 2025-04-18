<?php

namespace App\Livewire\Task;

use Flux\Flux;
use App\Events\SendRealtimeMessage;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Message;

class TaskComponent extends Component
{
    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleSendRealtimeMessage($message): void
    {
        // $messages = Message::latest()->take(10)->paginate(5);
        // $this->dispatch('new-message', message: $messages);
    }

    public function render()
    {
        $messages = Message::latest()->take(10)->get();
        $messageCount = Message::count();
        return view('livewire.task.task-component', [
            'messages' => $messages,
            'messageCount' => $messageCount
        ]);
    }
}
