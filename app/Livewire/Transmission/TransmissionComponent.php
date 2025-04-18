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
        try {
            $storeDataList = $request->input('data');

            foreach ($storeDataList as $data) {
                $transmittedData = $this->transmission->transmit($data);
                event(new SendRealtimeMessage($transmittedData)); // Optional: one per store
            }
            return response()->json(['status' => 'All data transmitted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Exception occurred!', 'error' => $e->getMessage()], 500);
        }
    }
    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleSendRealtimeMessage($transmittedData): void
    {
        $this->dispatch('new-message-id', id: $transmittedData);
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
