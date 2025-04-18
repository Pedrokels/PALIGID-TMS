<?php

namespace App\Livewire\Task;

use Flux\Flux;
use App\Events\SendRealtimeMessage;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Repositories\TransmissionRepositoryInterface;

class TaskComponent extends Component
{
    protected $transmission;

    public function __construct()
    {
        $this->transmission = app(TransmissionRepositoryInterface::class);
    }

    public function apiTransmit(Request $request)
    {
        $transmittedMessage = $this->transmission->transmit($request);
        if ($transmittedMessage) {
            event(new SendRealtimeMessage($transmittedMessage));
            return response()->json(['status' => 'The data has been transmitted successfully!'], 200);
        } else {
            return response()->json(['status' => 'Error transmitting data!'], 400);
        }
    }

    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleSendRealtimeMessage($message): void
    {
        $this->dispatch('new-message-id', id: $message['message']['id']);
    }

    public function render()
    {
        // $messages = Message::latest()->take(10)->get();
        $latestMessage = Message::latest()->first();
        $messages = Message::orderByDesc('id')->take(4)->get();

        $messageCount = Message::count();
        return view('livewire.task.task-component', [
            'messages' => $messages,
            'messageCount' => $messageCount
        ]);
    }
}
