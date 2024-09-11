<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubOption extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['option_id', 'name'];

    public $translatable = ['name'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
