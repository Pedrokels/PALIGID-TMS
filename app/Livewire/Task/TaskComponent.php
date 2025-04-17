<?php

namespace App\Livewire\Task;

use App\Events\SendRealtimeMessage;
use Livewire\Component;
use Livewire\Attributes\On;


class TaskComponent extends Component
{

    public string $message;

    public function sendEvent(): void
    {
        event(new SendRealtimeMessage($this->message));
        $this->message = '';
    }

    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleSendRealtimeMessage(): void
    {

        $this->message = 'event received';
    }


    public function render()
    {
        return view('livewire.task.task-component');
    }
}
