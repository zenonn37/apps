<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            "name" => $this->name,
            "balance" => $this->balance,
            "type" => $this->type,
            "created" => $this->created_at,
            "updated" => $this->updated_at,
            "id" => $this->id

        ];
    }
}
