<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class LanguageService
{
    public function change()
    {
        $this->get() == 'en' ? $this->set('ar') : $this->set('en');
    }

    public function get()
    {
        return session('language') ?? 'en';
    }

    public function set($language)
    {
        Session::put('language', $language);
    }
}