<?php

namespace App\Http\Resources\Expenses;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'title' => $this->title,
            'lender' => $this->lender,
            'quantity' => $this->quantity,
            'buying_price' => $this->buying_price,
            'mode' => $this->mode,
            'category' => $this->expense_category->title,
            'user' => $this->user->name,
            'created_at' => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
