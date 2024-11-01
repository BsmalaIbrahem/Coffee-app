<?php

namespace App\Services;

use App\Models\Address;

class AddressService extends BaseService
{
    public function model()
    {
        return Address::class;
    }

    public function addAddress($data)
    {
        $this->model()::create(array_merge($data, [
            'user_id' => auth()->user()->id,
        ]));
    }
}