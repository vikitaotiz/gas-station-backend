<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
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
            'name' => $this->product->title,
            'quantity' => $this->quantity,
            'system_stock' => $this->system_stock,
            'user' => $this->user->name,
            'created_at' => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
