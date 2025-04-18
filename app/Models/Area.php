<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;

class Area extends Model
{
    protected $fillable = ['name'];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
