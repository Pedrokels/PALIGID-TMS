<?php

namespace App\Repositories;


use Illuminate\Http\Request;

interface TransmissionRepositoryInterface
{
    public function transmit($transmittedDatas);
}
