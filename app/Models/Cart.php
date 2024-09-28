<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'phone_id', 
        'address_id', 
        'total', 
        'sub_total', 
        'delivery_fee',
        'quantity',
    ];

    protected $appends = ['address_details'];

    public function getAddressDetailsAttribute()
    {
        $address = \App\Models\Address::where('id', $this->address_id)->with('city')->first();

        return 'city : ' .$address['city']['name'] . 
                ' , street name : ' . $address['street_name'] .
                ' , building: ' . $address['building'] . 
                ' , district : ' . $address['district'] . 
                ' , nearest_landmark : ' . $address['nearest_landmark'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
