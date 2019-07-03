<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Excercise extends Model
{
    protected $guarded = [];

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }
}
