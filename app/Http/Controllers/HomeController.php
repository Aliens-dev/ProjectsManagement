<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($lang)
    {
        if($lang !== 'fr' && $lang !== 'en') {
            app()->setLocale('en');
            return view('home');
        }
        app()->setLocale($lang);
        return view('welcome');
    }
}
