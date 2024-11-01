<?php

namespace App\Services;

use App\Models\Phone;

class PhoneService extends BaseService
{
    public function model()
    {
        return Phone::class;
    }

    public function add($data)
    {
        $this->model()::create(array_merge($data, ['user_id' => auth()->user()->id]));
    }
}