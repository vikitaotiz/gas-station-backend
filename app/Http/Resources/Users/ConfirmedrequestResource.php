<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmedrequestResource extends JsonResource
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
            'content' => $this->content,
            'user_requesting' => $this->user_requesting,
            'provider' => $this->provider_name,
            'paymentmode' => $this->payment_mode,
            'amount' => $this->amount,
            'user' => $this->user ? $this->user->name : 'No User',
            'created_at' => $this->created_at->format('H:m A, jS D M Y')
        ];
    }
}
