<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name', 'product_description', 'photo', 'price', 'is_added_to_cart'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($product) {
    //         $product->update(['is_added_to_cart' => true]);
    //     });

    //     static::deleted(function ($product) {
    //         $product->update(['is_added_to_cart' => false]);
    //     });
    // }
}
