<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','quantity', 'price', 'is_same_price'];

    protected $appends = ['name', 'price_after_discount'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subOptions()
    {
      return $this->belongsToMany(SubOption::class, 'variants_sub_options');
    }

    public function getPriceAttribute($val)
    {
      return $val == 0 ? $this->product['price'] : $val;
    }

    public function getNameAttribute()
    {
        $names = '';
          foreach($this->subOptions as $sub_option){
              $names .= $sub_option['name'];
              if($sub_option['unit'])
                $names .= " " . $sub_option['unit'];

              $names .= ", ";
        }
      
        return $names;

    }

    public function getPriceAfterDiscountAttribute()
    {
        $offers = $this->product->offers;
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
}
