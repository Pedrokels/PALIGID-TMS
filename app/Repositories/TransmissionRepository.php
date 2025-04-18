<?php

namespace App\Repositories;

use App\Repositories\TransmissionRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\SendRealtimeMessage;

class TransmissionRepository implements TransmissionRepositoryInterface
{
    public function transmit($transmittedDatas)
    {
        foreach ($transmittedDatas as $data) {
            $transmittedData = Message::updateOrCreate(
                ['id' => $data['id']], // Use a unique key or change if needed
                $data
            );
        }
        return $transmittedData;
    }
}
