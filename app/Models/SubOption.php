<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubOption extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['option_id', 'name', 'unit'];

    public $translatable = ['name'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'variants_sub_options');
    }
}
