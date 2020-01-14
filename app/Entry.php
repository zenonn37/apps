<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    protected $guarded = [];
    public function clock_entry()
    {
        return $this->belongsTo(Clock::class);
    }
}
