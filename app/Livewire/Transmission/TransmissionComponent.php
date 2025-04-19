<?php

namespace App\Livewire\Transmission;

use Livewire\Component;
use App\Models\Message;
use App\Repositories\TransmissionRepositoryInterface;
use App\Events\SendRealtimeMessage;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Area;
use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Store;

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
        Store::find($id)->delete();
    }

    #[On('echo:my-channel,SendRealtimeMessage')]
    public function handleSendRealtimeMessage($data): void
    {
        $storesID = Store::latest()->first()->id;
        $this->dispatch('new-message-id', id: $storesID);
    }

    public function render()
    {
        $latestStores = Store::latest()->first();
        $stores = Store::orderByDesc('id')->take(4)->get();
        $provinceCount = Area::count();
        $municipalityCount = Municipality::count();
        $barangayCount = Barangay::count();


        return view('livewire.transmission.transmission-component', [
            'latestStores' => $latestStores,
            'stores' => $stores,
            'provinceCount' => $provinceCount,
            'municipalityCount' => $municipalityCount,
            'barangayCount' => $barangayCount,
            'mapboxToken' => env('MAPBOX_TOKEN')
        ]);
    }
}
