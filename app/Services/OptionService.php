<?php 

namespace App\Services;

use App\Models\Option;

class OptionService extends BaseService
{
    public function model()
    {
        return Option::class;
    }
}