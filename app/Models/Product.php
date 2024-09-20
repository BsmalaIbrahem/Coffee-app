<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'ingredients',
        'how_to_prepare',
        'is_unlimited',
        'main_image',
        'images',
        'quantity',
        'price',
        'options_ids'
    ];

    public $translatable = ['name', 'description', 'ingredients', 'how_to_prepare'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::Class);
    }

    public function offers()
    {
        return $this->morphMany('App\Models\OfferedItem', 'offeredItemable');
    }
}
