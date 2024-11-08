<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'city_id',
        'street_name',
        'building',
        'district',
        'nearest_landmark',
        'address_type'
    ];

    protected $appends = ['details'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getDetailsAttribute()
    {
        return $this->building . ' '.$this->street_name . ' '. $this->nearest_landmark. ' '. $this->district. ' '. $this->city['name'];
    }


}
