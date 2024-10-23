<?php

namespace App\Services;

use App\Models\Wishlist;

class WishlistService extends BaseService
{
    public function model()
    {
        return Wishlist::class;
    }

    public function store($data)
    {
        $this->model()::create([
            'user_id' => auth()->user()->id,
            'product_id' => $data['product_id'],
        ]);
    }

    public function destroy($id)
    {
        $wishlist = $this->model()::find($id);
        $wishlist->delete();
    }
}