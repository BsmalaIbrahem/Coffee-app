<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable  = ['cart_id', 'product_id', 'variant_id', 'quantity'];
    protected $appends = ['price', 'price_after_discount', 'total'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function getPriceAttribute()
    {
        return $this->variant_id ? $this->variant['price'] : $this->product['price'];
    }

    public function getPriceAfterDiscountAttribute()
    {
        return $this->variant_id ? $this->variant['price_after_discount'] : $this->product['price_after_discount'];
    }

    public function getTotalAttribute()
    {
        return ($this->price_after_discount > 0 ? $this->price_after_discount : $this->price) * $this->quantity;
    }
}
