<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Validation\ValidationException;


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
            return $order;
        }catch(err){
            DB::rollBack();
        }
    }

    public function create($data, $cart)
    {
        return $this->model()::create([
            'user_id' => auth()->user()->id,
            'reference_id' => Str::random(),
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

            $this->decrementProductQuantity($cartProduct);
            $this->decrementVariantQuantity($cartProduct);

        }
    }

    public function checkCartProductsQuantities($cartService)
    {
        $cart = $cartService->find();
        foreach($cart->products as $item)
        {
            if(!$item['product']['is_unlimited']){
                if($item['variant_id']){
                    if($item['variant']['quantity'] < $item['quantity'])
                        throw ValidationException::withMessages([
                            'message' => "Sorry, this ".$item['product']['name']." is currently not available in the requested quantity. The maximum quantity you can purchase for this item is ".$item['variant']['quantity']
                        ]);
                }
                else{
                    if($item['product']['quantity'] < $item['quantity'])
                        throw ValidationException::withMessages([
                            'message' => "Sorry, this ".$item['product']['name']." is currently not available in the requested quantity. The maximum quantity you can purchase for this item is ".$item['product']['quantity']
                        ]);
                }
            }
        }

        return true;
    }

    public function decrementProductQuantity($cartProduct)
    {
        if(!$cartProduct['product']['is_unlimited']){
            $product = Product::find($cartProduct['product_id']);
            $product['quantity'] = $product['quantity'] - $cartProduct['quantity'];
            $product->save();
        }
    }

    public function decrementVariantQuantity($cartProduct)
    {
        if(!$cartProduct['product']['is_unlimited'] && $cartProduct['variant_id']){
            $variant = Variant::find($cartProduct['variant_id']);
            $variant['quantity'] = $variant['quantity'] - $cartProduct['quantity'];
            $variant->save();
        }
    }

}
