<?php

use App\Livewire\Task\TaskComponent;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Events\SendRealtimeMessage;

Route::post('/transmit', [TaskComponent::class, 'apiTransmit'])->name('transmit');
