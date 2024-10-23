<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WishlistService;

class WishlistController extends Controller
{
    private $service;
    public function __construct(WishlistService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $wishlists = $this->service->get(function($q){
            $q->where('user_id', auth()->user()->id);
        }, true, ['products']);
        
        return view('wishlist');
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());
        return response(['message' => 'success']);
    }
}
