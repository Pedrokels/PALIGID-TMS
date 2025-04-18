<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Barangay;

class Municipality extends Model
{
    protected $fillable = ['name', 'area_id'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class);
    }
}
