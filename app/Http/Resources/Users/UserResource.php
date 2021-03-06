<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'department_id' => $this->department_id,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'password' => $this->password,
            'pwd_clr' => $this->pwd_clr,
            'status' => $this->status,
            'created_at' => $this->created_at->diffForHumans(),
            'department' => $this->department->name
        ];
    }
}
