<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\OptionService;

class ProductController extends Controller
{
    private $service; private $optionService;
    public function __construct(ProductService $service, OptionService $optionService)
    {
        $this->service = $service;
        $this->optionService = $optionService;
    }

    public function index()
    {
        $products = $this->service->index();
        $options  = $this->optionService->get(null, false, ['subOptions']);
        return view('product', ['products' => $products, 'options' => $options]);
    }

    public function incrementViews($id)
    {
        $this->service->incrementViews($id);
        return response(['message' => 'success']);
    }
}
