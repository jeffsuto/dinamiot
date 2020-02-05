<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Endpoint extends Model
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
