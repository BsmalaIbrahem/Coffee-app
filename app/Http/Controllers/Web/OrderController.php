<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->get(function($q){
            $q->where('user_id', auth()->user()->id);
        }, true, []);

        return view('orders', ['orders'=> $orders]);
    }

    public function get($id)
    {
        $order = $this->orderService->get(function($q) use ($id){
            $q->where('user_id', auth()->user()->id)->where('id', $id);
        }, false, ['products', 'products.item', 'products.variant'], false, true);

        return view('oneOrder', ['order'=> $order]);
    }
}
