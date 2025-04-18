<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Transmission\TransmissionComponent;

// Transmission API
Route::middleware('api.key')->group(function () {
    Route::post('/transmit', [TransmissionComponent::class, 'apiTransmit'])->name('transmit');
});
