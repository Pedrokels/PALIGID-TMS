<?php

namespace App\Services;

use App\Models\Area;
use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Store;
use Exception;

class TransmissionServices
{
    public function transmit($storeDataList)
    {
        try {
            $anyInserted = false;
            $details = [];

            foreach ($storeDataList as $data) {
                $inserted = false;

                $area = Area::firstOrCreate(['name' => $data['area']]);
                $inserted = $inserted || $area->wasRecentlyCreated;

                $municipality = Municipality::firstOrCreate([
                    'name' => $data['municipality'],
                    'area_id' => $area->id,
                ]);
                $inserted = $inserted || $municipality->wasRecentlyCreated;

                $barangay = Barangay::firstOrCreate([
                    'name' => $data['barangay'],
                    'municipality_id' => $municipality->id,
                ]);
                $inserted = $inserted || $barangay->wasRecentlyCreated;

                $store = Store::where([
                    'name' => $data['store_name'],
                    'type' => $data['type'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'barangay_id' => $barangay->id,
                ])->first();

                if (!$store) {
                    Store::create([
                        'name' => $data['store_name'],
                        'type' => $data['type'],
                        'latitude' => $data['latitude'],
                        'longitude' => $data['longitude'],
                        'description' => $data['description'],
                        'barangay_id' => $barangay->id,
                    ]);
                    $inserted = true;
                }

                $anyInserted = $anyInserted || $inserted;

                $details[] = [
                    'data' => $data,
                    'inserted' => $inserted,
                ];
            }
            return [
                'success' => true,
                'inserted' => $anyInserted,
                'message' => $anyInserted
                    ? 'The data has been inserted successfully.'
                    : 'All data already exists in the database.',
                'details' => $details,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception occurred: ' . $e->getMessage(),
            ];
        }
    }
}
