<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class DiscountController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->get(function($q){
            $q->whereHas('offers');
        }, true,  [], false);

        return view('product', ['products' => $products]);

    }
}
