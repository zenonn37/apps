<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    protected $guarded = [];

    public function clock_entrys()
    {
        return $this->hasMany(Entry::class);
    }

    public function project_clocks()
    {
        return $this->belongsTo(TimerProject::class);
    }
}
