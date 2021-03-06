<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Device extends Model
{
    protected $dates = ['last_active_date'];
    
    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function endpoint()
    {
        return $this->hasOne(Endpoint::class);
    }
}
