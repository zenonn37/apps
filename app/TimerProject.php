<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimerProject extends Model
{
    protected $guarded = [];

    public function timer_tasks()
    {
        return $this->hasMany(TimerTask::class);
    }

    public function project_clocks()
    {
        return $this->hasMany(Clock::class);
    }

    public function entrys(){
        return $this->hasMany(Entry::class);
    }
}
