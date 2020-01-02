<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimerTask extends Model
{
    protected $guarded = [];

    public function projects()
    {
        return $this->belongsTo(TimerProject::class);
    }
}
