<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'email' => $this->email,
            'created_at' => $this->created_at->diffForHumans(),
            'role' => $this->role ? $this->role->name : 'No Role',
            'status' => $this->status,
            'department' => $this->department ? $this->department->name : 'No Department',
        ];
    }
}
