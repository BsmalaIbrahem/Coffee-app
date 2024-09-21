<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedItem extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id'];
    protected $appends = ['name', 'type'];

    public function offeredItemable()
    {
        return $this->morphTo();
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function getNameAttribute()
    {
        $item = $this->offeredItemable_type::find($this->offeredItemable_id);
        return $item?->name;
    }

    public function getTypeAttribute()
    {
        $parts = explode('\\', $this->offeredItemable_type);
        return end($parts);
    }

}
