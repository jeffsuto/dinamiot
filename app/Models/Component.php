<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Component extends Model
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
