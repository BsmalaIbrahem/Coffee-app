<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AddressService;
use App\Services\PhoneService;
use App\Services\CartService;
use App\Services\CityService;
use App\Services\OrderService;
use App\Http\Requests\CheckoutRequest;

class CheckoutConroller extends Controller
{
    private $addressService; private $phoneService; private $cartService; private $cityService; private $orderService;

    public function __construct(
        AddressService $addressService, 
        PhoneService $phoneService, 
        CartService $cartService, 
        CityService $cityService,
        OrderService $orderService
    ){
        $this->addressService = $addressService;
        $this->phoneService   = $phoneService;
        $this->cartService = $cartService;
        $this->cityService = $cityService;
        $this->orderService = $orderService;
    }

    public function get()
    {
        $cities = $this->cityService->get();
        
        $address = $this->addressService->get(function($q){
            $q->where('user_id', auth()->user()->id)->orderBy('id', 'desc');
        }, false, [], false, true);


        $phone = $this->phoneService->get(function($q){
            $q->where('user_id', auth()->user()->id)->orderBy('id', 'desc');
        }, false, [], false, true);

        $cart = $this->cartService->get(function($q){
            $q->where('user_id', auth()?->user()?->id);
        }, false, [], false, true);

        //shiiping fee
        $shipping_fee = 30;

        return view('checkout', [
                'cities'       => $cities,
                'address'      => $address,
                'phone'        => $phone,
                'cart'         => $cart, 
                'shipping_fee' => $shipping_fee, 
            ]);
    }

    public function checkout(CheckoutRequest $request)
    {
        $this->orderService->placeOrder($request->all(), $this->cartService);
        //send email to user & admin
        return redirect()->route('cart');
    }
}
