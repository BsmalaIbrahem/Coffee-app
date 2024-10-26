<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    private $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function get()
    {
        return $this->service->find();
    }

    public function addProduct(Request $request)
    {
        $this->service->addProduct($request->all());
        return response(['success' => true]);
    }

    public function removeProduct(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
