<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
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
            'id' => $this->id,
            'seconds' => $this->seconds,
            'timer_project_id' => $this->timer_project_id,
            'clock_id' => $this->clock_id,
            'start' => $this->start_time,
            'end' => $this->end_time
        ];
    }
}
