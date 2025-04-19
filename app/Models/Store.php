<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'type', 'barangay_id', 'latitude', 'longitude', 'description'];
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
