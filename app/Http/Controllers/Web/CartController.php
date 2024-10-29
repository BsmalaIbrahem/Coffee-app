<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function get()
    {
        $cart = $this->service->get(function($q){
            $q->where('user_id', auth()?->user()?->id)->orWhere('session', Session::getId());
        }, false, ['products', 'products.product', 'products.variant', 'products.variant.subOptions'], false, true);

        return view('cart', ['cart' => $cart]);
    }

    public function addProduct(Request $request)
    {
        $this->service->addProduct($request->all());
        return response(['success' => true]);
    }

    public function removeProduct($product_id)
    {
        $this->service->deleteCartProduct($product_id);
        return redirect()->route('cart');
    }

    public function incrementQuantity(Request $request)
    {
        $this->service->incrementProductQuantity(null, $request['cart_product_id']);
        $this->service->incrementCartQuantity();
        return response(['sucess' => true]);
    }

    public function decrementQuantity(Request $request)
    {
        $this->service->decrementProductQuantity(null, $request['cart_product_id']);
        
        return response(['sucess' => true]);
    }
}
