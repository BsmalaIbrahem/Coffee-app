<?php

namespace App\Services;

use App\Models\Offer;

class DiscountService extends BaseService
{
    public function model()
    {
        return Offer::class;
    }
}