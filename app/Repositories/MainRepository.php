<?php

namespace App\Repositories;

use App\Models\Product;

class MainRepository implements GenericRepository
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model; 
    }

    public function all($limit = 6)
    {
        return $this->model::paginate($limit);
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function getByFilter($filter, $limit = 6)
    {
        return $this->model::where($filter['type'], $filter['value'])->paginate($limit);
    }

    public function getWithRelations($relations, $limit = 6)
    {
        return $this->model::with($relations)->paginate($limit);
    }
}