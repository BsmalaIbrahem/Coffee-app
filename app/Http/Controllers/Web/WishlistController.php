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
        }, true, ['product']);
        
        return view('wishlist', ['wishlists' => $wishlists]);
    }

    public function store(Request $request)
    {
        $this->service->store($request->all());
        return response(['message' => 'success']);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response(['message' => 'success']);
    }
}
