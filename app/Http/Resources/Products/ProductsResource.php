<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
            'quantity' => $this->quantity,
            'image_url' => $this->image_url,
            'min_qty' => $this->min_qty,
            'decription' => $this->description,
            'user' => $this->user->name,
            'category' => $this->product_category->title,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
