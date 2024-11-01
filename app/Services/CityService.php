<?php

namespace App\Services;

use App\Models\City;

class CityService extends BaseService
{

    public function model()
    {
        return City::class;
    }

}