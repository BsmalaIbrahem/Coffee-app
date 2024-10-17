<?php

namespace App\Services;

use App\Repositories\MainRepository;
use App\Models\Category;

class CategoryService extends BaseService
{
    public function model()
    {
        return Category::class;
    }

    public function getWithProducts($limit)
    {
        //
    }
    
}