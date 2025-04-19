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
use App\Services\TransmissionServices;

class TransmissionComponent extends Component
{
    // protected $transmission;

    // public function __construct()
    // {
    //     $this->transmission = app(TransmissionRepositoryInterface::class);
    // }

    protected $transmission;

    public function boot()
    {
        $this->transmission = new TransmissionServices();
    }

    public function apiTransmit(Request $request)
    {
        $result = $this->transmission->transmit($request->input('data'));
        return response()->json($result, $result['success'] ? 200 : 500);
    }

    public function deleteMessage($id)
    {
        Store::find($id)->delete();
    }

    #[On('echo:transmission-channel,SendRealtimeTransmit')]
    public function handleSendRealtimeTransmit($data): void
    {
        $strID = Store::latest()->first()->id;
        $this->dispatch('transmitted', id: $strID);
    }

    public function render()
    {


        $latestStores = Store::latest()->first();
        $stores = Store::orderByDesc('id')->take(3)->get();

        // Buenget Stores Count
        $benguetArea = Area::where('name', 'Benguet')->first();
        $benguetStoreCount = $benguetArea ? Store::whereHas('barangay.municipality.area', function ($query) use ($benguetArea) {
            $query->where('id', $benguetArea->id);
        })->count() : 0;

        // Biliran Stores Count
        $biliranArea = Area::where('name', 'Biliran')->first();
        $biliranStoreCount = $biliranArea ? Store::whereHas('barangay.municipality.area', function ($query) use ($biliranArea) {
            $query->where('id', $biliranArea->id);
        })->count() : 0;

        // Sultan Kudarat Stores Count  
        $sultanKudaratArea = Area::where('name', 'Sultan Kudarat')->first();
        $sultanKudaratStoreCount = $sultanKudaratArea ? Store::whereHas('barangay.municipality.area', function ($query) use ($sultanKudaratArea) {
            $query->where('id', $sultanKudaratArea->id);
        })->count() : 0;

        return view('livewire.transmission.transmission-component', [
            'latestStores' => $latestStores,
            'stores' => $stores,
            'benguetStoreCount' => $benguetStoreCount,
            'biliranStoreCount' => $biliranStoreCount,
            'sultanKudaratStoreCount' => $sultanKudaratStoreCount,
            // 'provinceCount' => $provinceCount,
            // 'municipalityCount' => $municipalityCount,
            // 'barangayCount' => $barangayCount,
            // 'storeCount' => $storeCount,
            'mapboxToken' => env('MAPBOX_TOKEN')
        ]);
    }
}
