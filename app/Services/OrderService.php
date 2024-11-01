<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService extends BaseService
{
    public function model()
    {
        return Order::class;
    }

    public function placeOrder($data, $cartService)
    {
        DB::beginTransaction();
        try{
            //get Cart
            $cart = $cartService->find();
            //create order
            $order = $this->create($data, $cart);
            //get Cart Products
            $cartProducts = $cartService->getCartProduct(null, $cart['id']);
            //create order products
            $this->addProductsFromCart($order['id'], $cartProducts);
            //delete Cart
            $cartService->destory($cart['id']);

            DB::commit();
        }catch(err){
            DB::rollBack();
        }
    }

    public function create($data, $cart)
    {
        return $this->model()::create([
            'user_id' => auth()->user()->id,
            'reference_id' => Str::random(10),
            'total' => $cart['total'],
            'shipping_fee' => 30,
            'sub_total' => $cart['total'] + 30,
            'quantity' => $cart['quantity'],
            'address_id' => $data['address_id'],
            'phone_id' => $data['phone_id'],
        ]);
    }

    public function addProductsFromCart($order_id,$cartProducts)
    {
        foreach($cartProducts as $cartProduct)
        {
            OrderProduct::create([
                'order_id' => $order_id,
                'product_id' => $cartProduct['product_id'],
                'variant_id' => $cartProduct['variant_id'],
                'quantity' => $cartProduct['quantity'],
                'price' => $cartProduct['total'],
            ]);
        }
    }
}