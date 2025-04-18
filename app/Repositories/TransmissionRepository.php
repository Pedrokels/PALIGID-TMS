<?php

namespace App\Repositories;

use App\Repositories\TransmissionRepositoryInterface;
use App\Models\Area;
use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Store;

class TransmissionRepository implements TransmissionRepositoryInterface
{
    public function transmit($data)
    {
        $area = Area::firstOrCreate(['name' => $data['area']]);
        
        $municipality = Municipality::firstOrCreate([
            'name' => $data['municipality'],
            'area_id' => $area->id,
        ]);

        $barangay = Barangay::firstOrCreate([
            'name' => $data['barangay'],
            'municipality_id' => $municipality->id,
        ]);

        Store::create([
            'name' => $data['store_name'],
            'type' => $data['type'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'description' => $data['description'],
            'barangay_id' => $barangay->id,
        ]);

        return $data;
    }
}
