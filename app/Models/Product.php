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
        'options_ids',
        'views',
    ];

    public $translatable = ['name', 'description', 'ingredients', 'how_to_prepare'];

    protected $appends = ['price_after_discount', 'wishlisted'];

    protected $casts = [
        'options_ids' => 'array',
        'wishlisted' => 'boolean',
    ];

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

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getPriceAfterDiscountAttribute()
    {
        $offers = $this->offers;
        for($i=count($offers) - 1; $i >= 0; $i++)
        {
            $offer = \App\Models\Offer::find($offers[$i]['offer_id']);
            if($offer){
                if($offer['type'] == 'percentage'){
                    return floor($this->price - (($offer['value'] / 100) * $this->price));
                }else
                    return $this->price - $offer['value']; 
            }
            
        }
        return 0;
    }

    public function getWishlistedAttribute()
    {
        if(auth()->check()){
            $wishlist = \App\Models\Wishlist::where('product_id', $this->id)->where('user_id' , auth()->user()->id)->first();
            if($wishlist)
                return true;
        }
        return false;
    }
}

