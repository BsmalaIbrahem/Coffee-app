<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function incrementViews($id)
    {
        $this->service->incrementViews($id);
        return response(['message' => 'success']);
    }
}
