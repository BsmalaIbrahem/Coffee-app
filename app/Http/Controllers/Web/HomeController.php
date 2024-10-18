<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\SocialMediaService;
use App\Services\LanguageService;

class HomeController extends Controller
{
    private $categoryService; private $socialService; private $languageService;

    public function __construct(CategoryService $categoryService, SocialMediaService $socialService, LanguageService $languageService)
    {
        $this->categoryService = $categoryService;
        $this->socialService = $socialService;
        $this->languageService = $languageService;
    }

    public function index()
    {
        $categories = $this->categoryService->get(null, false, ['products' => function($q){
            $q->take(3);
        }], true);

        $allSocialMedia = $this->socialService->get();

        $ContactMethods = $this->socialService->get(function($query){
            $query->whereIn('type', ['Phone', 'Gmail', 'Location']);
        });
        
        return view('home', ['categories' => $categories, 'allSocialMedia' => $allSocialMedia, 'ContactMethods' => $ContactMethods]);
    }

    public function changeLanguage()
    {
        $this->languageService->change();
        return redirect()->route('home');
    }
}
