<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUs\CreateRequest;
use App\Services\ContactUsService;

class ContactUsController extends Controller
{
    private $service;

    public function __construct(ContactUsService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $this->service->create($request->all());
        return redirect()->route('home')->with('message', "Sent successfully!");
    }
}
