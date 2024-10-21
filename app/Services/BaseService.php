<?php

namespace App\Services;

abstract class BaseService
{
    abstract protected function model();

    public function get(callable $filters = null, bool $paginate = false, array $relations = array(), bool $take = false , bool $first = false)
    {
        $query = $this->model()::query();
        if($filters)
            $filters($query);
        if(request()->has('search'))
            $this->search($query);
        if(count($relations))
            $query->with($relations);

        if($take && !$paginate)
            $query->take(3);

        return $first ? $query->first() : ($paginate ? $query->paginate(6) : $query->get());
    }

    private function search($query)
    {
        $search = '%'.request('search') . '%';
        return $query->where('name', 'like', $search);
    }
}