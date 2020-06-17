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
          'amount' => $this->amount,
          'due' => $this->due,
         
          'category' => $this->category,
          'id' => $this->id,
        ];
    }
}
