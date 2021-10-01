<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function product_category()
    // {
    //     return $this->belongsTo(ProductCategory::class);
    // }
}
