<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'shared' => $this->shared,
            'color' => $this->color,
            'favorite' => $this->favorite,
            'comments' => $this->comments,
            'tasks'=> TaskResource::collection($this->tasks)
        ];
    }
}
