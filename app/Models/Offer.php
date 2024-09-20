<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'type', 'start_date', 'end_date', 'is_global', 'is_active'];

    protected $casts = 
    [
        'value' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_global' => 'boolean',
        'is_active' => 'boolean',  
    ];

    public function items()
    {
        return $this->hasMany(OfferedItem::class);
    }
}
