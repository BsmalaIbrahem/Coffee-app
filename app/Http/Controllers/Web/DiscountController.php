<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\DiscountService;

class DiscountController extends Controller
{
    private $productService; private $service;

    public function __construct(DiscountService $service, ProductService $productService)
    {
        $this->service = $service;
        $this->productService = $productService;
    }

    public function index()
    {
        $last_offer = $this->service->get(function($q){
            $q->where('is_active', true)->latest('id');
        }, false, [], false, true);


        $products = $this->productService->get(function($q) use ($last_offer){
            $q->whereHas('offers', function($q) use ($last_offer){
                $q->where('offer_id', $last_offer['id']);
            });
        }, true,  [], false);

        return view('product', ['products' => $products]);

    }
}
