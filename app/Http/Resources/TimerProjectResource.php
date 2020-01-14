<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TimerTaskResource;

class TimerProjectResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "goal" => $this->goal,
            "completed" => $this->completed,
            "complete" => $this->complete,
            'tasks' => TimerTaskResource::collection($this->timer_tasks)->count(),
            'seconds' => ClockResource::collection($this->project_clocks)->sum('seconds')

        ];
    }
}
