<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcerciseResource extends JsonResource
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
            'sets' => $this->sets,
            'reps' => $this->reps,
            'instructions' => $this->instructions,
            'failure' => $this->failure,
            'completed' => $this->completed,
            'id' => $this->id
        ];
    }
}
