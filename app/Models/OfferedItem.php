<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedItem extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id'];

    public function offeredItemable()
    {
        return $this->morphTo();
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

}
