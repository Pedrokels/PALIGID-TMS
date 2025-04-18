<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;
use App\Models\Store;

class Barangay extends Model
{
    protected $fillable = ['name', 'municipality_id'];
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
