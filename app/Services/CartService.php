<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\CartProduct;
use Illuminate\Support\Facades\DB;

class CartService extends BaseService
{
    private $cart_id;

    public function __construct()
    {
        $cart = $this->find();
        $this->cart_id = $cart ? $cart['id'] : null; 
    }

    public function model()
    {
        return Cart::class;
    }

    public function addProduct($data)
    {
       //dd($data);
        if(!$this->find()){
            $cart = $this->create();
            $this->storeNewCartProduct($data);
        }else{
            if($this->getCartProduct($data)){
                $this->incrementProductQuantity($data);
                $this->incrementCartQuantity();
            }else{
                $this->storeNewCartProduct($data);
                $this->incrementCartQuantity();
            }
        }
    }

    public function find()
    {
        return $this->get(function($q){
            $q->where('user_id', auth()?->user()?->id)->orWhere('session', Session::getId());
        }, false, [], false, true);
    }

    public function create($quantity = 1)
    {
        $cart = $this->model()::create([
            'user_id' => auth()?->user()?->id ?? null,
            'session' => auth()->check() ? null : Session::getId(),
            'quantity' => $quantity,
        ]);

        $this->cart_id = $cart['id'];
        return $cart;
    }

    public function storeNewCartProduct($data, $cart_id=null)
    {
        return CartProduct::create([
            'cart_id' => $cart_id ?? $this->find()['id'],
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'quantity' => $data['quantity'] ?? 1,
        ]);
    }

    public function incrementProductQuantity($data, $cart_products_id=null)
    {
        $cart_product = $this->getCartProduct($data, null, $cart_products_id);
        $cart_product->quantity = ($cart_product->quantity) + 1;
        $cart_product->save();

    }

    public function incrementCartQuantity()
    {
        $cart = $this->find();
        $cart->quantity = ($cart->quantity) + 1;
        $cart->save();
    }

    public function decrementProductQuantity($data, $cart_products_id=null)
    {
        $this->decrementCartQuantity();

        $cart_product = $this->getCartProduct($data, null, $cart_products_id);
        $cart_product->quantity = ($cart_product->quantity) - 1;
        $cart_product->save();

        if($cart_product->quantity == 0){
            $this->deleteCartProduct($cart_product['id']);
        }
    }

    public function decrementCartQuantity()
    {
        $cart = $this->find();
        $cart->quantity = ($cart->quantity) - 1;
        $cart->save();
    }
    

    public function getCartProduct($data = null, $cart_id = null, $id=null)
    {
        if($id){
            return CartProduct::where('id', $id)->first();
        }
        if($cart_id && !$data){
            return CartProduct::where('cart_id', $cart_id)->get();
        }
        return CartProduct::where('cart_id', $cart_id ?? $this->find()['id'])
                            ->where('product_id',$data["product_id"])
                            ->where('variant_id', $data['variant_id'])
                            ->first();
                            
    }

    public function deleteCartProduct($id)
    {
        CartProduct::find($id)->delete();
    }

    public function addCartToUser($cart)
    {
        if($cart){
            $user_cart = $this->get(function($q){
                $q->where('user_id', auth()?->user()?->id);
            }, false, [], false, true);

            if($user_cart){
                //add cart quantity to user cart quantity
                $user_cart['quantity'] = $user_cart['quantity'] + $cart['quantity'];
                $user_cart->save();
                //update cart products cart_id  if product is found increment qunatity 
                $this->moveProductsToAnotherCart($cart, $user_cart);
                //delete session cart (record)
                $this->destory($cart["id"]);
            }else{
                $cart['user_id'] = auth()->user()->id;
                $cart['session'] = null;
                $cart->save();
            }
        }
    }

    public function moveProductsToAnotherCart($seesion_cart, $user_cart)
    {
        $cart_products = CartProduct::where('cart_id', $seesion_cart['id'])->get();

        foreach($cart_products as $cart_product){
            $user_cart_product = $this->getCartProduct($cart_product, $user_cart["id"]);
            if($user_cart_product){
                $user_cart_product['quantity'] = $user_cart_product['quantity'] + $cart_product['quantity'];
                $user_cart_product->save();
            }
            else{
                $cart_product['cart_id'] = $user_cart['id'];
                $cart_product->save();
            }
        }
    }

    public function destory($cart_id)
    {
        $this->model()::where('id', $cart_id)->delete();
    }
   
} 