<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClockResource extends JsonResource
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
            'seconds' => $this->seconds,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'entries_count' => EntryResource::collection($this->clock_entrys)->count(),
            'entries_sum' => EntryResource::collection($this->clock_entrys)->sum('seconds'),
            'entries' => EntryResource::collection($this->clock_entrys)


        ];
    }
}
