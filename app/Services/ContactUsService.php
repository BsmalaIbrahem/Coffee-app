<?php

namespace App\Services;

use App\Models\ContactUs;

class ContactUsService extends BaseService
{
    public function model()
    {
        return ContactUs::class;
    }

    public function create($data)
    {
        $this->model()::create($data);
    }
}