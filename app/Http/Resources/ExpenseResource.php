<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
          'name' => $this->name,
          'type' => $this->type,
          'amount' => $this->amount,
          'due' => $this->due,
          'paid' => $this->paid,
          'repeated' => $this->repeated,
          'id' => $this->id,
        ];
    }
}
