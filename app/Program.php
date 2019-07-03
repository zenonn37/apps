<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = [];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
    public function excercises()
    {
        return $this->hasMany(Excercise::class);
    }
}
