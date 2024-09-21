<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sub_options_ids', 'quantity', 'price', 'is_same_price'];

    protected $appends = ['option', 'sub_option', 'sub_options_names'];

    protected $casts = ['sub_options_ids' => 'array'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubOptionsNamesAttribute()
    {
        $names = '';
  
        if(!is_array($this->sub_options_ids)){
          $this->sub_options_ids = json_decode($this->sub_options_ids);
        }
          foreach($this->sub_options_ids as $sub_option_id){
            $sub_option = \App\Models\SubOption::find($sub_option_id);
            if($sub_option){
              $names .= $sub_option['name'].", ";
            }
        }
      
        return $names;

    }
}
