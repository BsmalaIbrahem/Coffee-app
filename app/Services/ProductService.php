<?php

namespace App\Services;

use App\Models\Product;

class ProductService extends BaseService
{
    public function model()
    {
        return Product::class;
    }

    public function index()
    {
        $filterMethod = null;
        if(request()->has('category'))
        {
            $filterMethod = $this->getMethodbyCategory();
        }
        else if(request()->has('search_key'))
        {
            //
        }
        return $this->get($filterMethod, true, ['variants', 'variants.subOptions', 'variants.subOptions.option']);
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

    private function getMethodbyCategory()
    {
        return function($q){
            $q->wherehas('category', function($q){
                $q->where('name->'.app()->getLocale(), request()->get('category'));
            });
        };
    }
}