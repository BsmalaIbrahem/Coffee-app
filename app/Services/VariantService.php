<?php

namespace App\Services;

use App\Models\Variant;

class VariantService extends BaseService
{
    public function model()
    {
        return Variant::class;
    }
}