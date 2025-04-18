<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Message;
use App\Events\SendRealtimeMessage;

Route::post('/transmit', function (Request $request) {
    $message = Message::create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    if ($message) {
        // Broadcast event to Livewire
        // broadcast(new \App\Events\NewMessageReceived($message))->toOthers();
        event(new SendRealtimeMessage($message));
        return response()->json(['status' => 'success']);
    } else {
        return response()->json(['status' => 'error']);
    }
});
