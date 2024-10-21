<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VariantService;

class VariantController extends Controller
{
    private $service; 
    
    public function __construct(VariantService $service)
    {
        $this->service = $service;
    }

    public function get($id)
    {
        $variant = $this->service->get(function($q) use ($id){
            $q->where('id', $id);
        }, false, ['subOptions', 'subOptions.option'], false, true);

        return response(['data' => $variant]);
    }
}
