<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Value extends Model
{
    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
