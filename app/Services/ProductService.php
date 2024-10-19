<?php

namespace App\Services;

use App\Models\Product;

class ProductService extends BaseService
{
    public function model()
    {
        return Product::class;
    }

    public function incrementViews($id)
    {
        $product = $this->get(function($q) use ($id){
            $q->where('id', $id);
        });
       // dd($product[0]);

        $product[0]->views = $product[0]->views + 1;
        $product[0]->save();
    }
}