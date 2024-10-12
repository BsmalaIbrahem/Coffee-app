<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements GenericRepository
{
    public function all()
    {
        return Product::paginate(6);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function getByFilter($filter)
    {
        return product::where($filter['type'], $filter['value'])->paginate(6);
    }

    public function getWithRelations($relations)
    {
        return Product::with($relations)->paginate(6);
    }
}