<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'bill' => $this->bill,
            'amount' => $this->amount,
            'mode' => $this->mode,
            'creditor_name' => $this->creditor_name,
            'receipt_no' => $this->receipt_no,
            'content' => $this->content,
            'user' => $this->user->name,
            'created_at' => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
