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
        $area = Area::where('name', $data['area'])->first();
        if (!$area) {
            $area = Area::create(['name' => $data['area']]);
        }

        $municipality = Municipality::where('name', $data['municipality'])
            ->where('area_id', $area->id)
            ->first();
        if (!$municipality) {
            $municipality = Municipality::create([
                'name' => $data['municipality'],
                'area_id' => $area->id,
            ]);
        }

        $barangay = Barangay::where('name', $data['barangay'])
            ->where('municipality_id', $municipality->id)
            ->first();
            
        if (!$barangay) {
            $barangay = Barangay::create([
                'name' => $data['barangay'],
                'municipality_id' => $municipality->id,
            ]);
        }

        $store = Store::where('name', $data['store_name'])
            ->where('type', $data['type'])
            ->where('latitude', $data['latitude'])
            ->where('longitude', $data['longitude'])
            ->where('barangay_id', $barangay->id)
            ->first();

        if (!$store) {
            Store::create([
                'name' => $data['store_name'],
                'type' => $data['type'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'description' => $data['description'],
                'barangay_id' => $barangay->id,
            ]);
        }

        return $data;
    }
}
