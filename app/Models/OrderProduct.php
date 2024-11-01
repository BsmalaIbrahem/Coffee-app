<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable =[
        'order_id',
        'product_id',
        'variant_id',
        'price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
