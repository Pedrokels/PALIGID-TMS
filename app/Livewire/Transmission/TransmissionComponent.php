<?php

namespace App\Livewire\Transmission;

use Livewire\Component;
use App\Models\Message;
use App\Repositories\TransmissionRepositoryInterface;
use App\Events\SendRealtimeMessage;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransmissionComponent extends Component
{
    protected $transmission;

    public function __construct()
    {
        $this->transmission = app(TransmissionRepositoryInterface::class);
    }

    public function apiTransmit(Request $request)
    {
        $transmittedDatas = $request->input('messages');
        Log::info('Received transmission:', $transmittedDatas);
        $transmittedData = $this->transmission->transmit($transmittedDatas);
        if ($transmittedData) {
            event(new SendRealtimeMessage($transmittedData));
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
    public function handleSendRealtimeMessage($transmittedData): void
    {
        $this->dispatch('new-message-id', id: $transmittedData['transmittedData']['id']);
    }


    public function render()
    {
        $latestMessage = Message::latest()->first();
        $messages = Message::orderByDesc('id')->take(4)->get();

        $messageCount = Message::count();

        return view('livewire.transmission.transmission-component', [
            'messages' => $messages,
            'messageCount' => $messageCount
        ]);
    }
}
