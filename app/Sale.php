<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
