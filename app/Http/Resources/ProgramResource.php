<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ExcerciseResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'level' => $this->level,
            'time' => $this->time,
            'calories' => $this->calories,
            'description' => $this->description,
            'used' => $this->used,
            'first_run' => $this->first_run,
            'id' => $this->id,
            'excercises' => ExcerciseResource::collection($this->excercises)


        ];
    }
}
