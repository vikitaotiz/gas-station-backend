<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'pin' => $this->pin,
            'email' => $this->email,
            'role' => $this->role ? $this->role->name : 'No Role',
            'schedule' => $this->schedule,
            'status' => $this->status,
            'department' => $this->department ? $this->department->name : 'No Department',
            'created_at' => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
