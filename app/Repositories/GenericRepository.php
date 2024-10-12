<?php

namespace App\Repositories;

interface GenericRepository
{
    public function all();

    public function find($id);

    public function getByFilter($filter);
}