<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total',
        'sub_total',
        'shipping_fee',
        'quantity',
        'status',
        'address_id',
        'phone_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
