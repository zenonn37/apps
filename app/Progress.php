<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $guarded = [];

    public function activities()
    {
        return $this->belongsTo(Activity::class);
    }
}
