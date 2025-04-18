<?php

namespace App\Repositories;

use App\Repositories\TransmissionRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\SendRealtimeMessage;

class TransmissionRepository implements TransmissionRepositoryInterface
{
    public function transmit($request)
    {
        $message = Message::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $message;
    }
}
