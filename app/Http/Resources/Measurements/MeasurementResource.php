<?php

namespace App\Http\Resources\Measurements;

use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
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
            'user' => $this->user->name,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
