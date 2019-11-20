<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'acct_id' => $this->acct_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'amount' => $this->amount,
            'date' => $this->date,
            'type' => $this->type,
            'created_at' => $this->created_at,


        ];
    }
}
