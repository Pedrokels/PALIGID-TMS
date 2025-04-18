<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Transmission\TransmissionComponent;

// Transmission API
Route::post('/transmit', [TransmissionComponent::class, 'apiTransmit'])->name('transmit');
