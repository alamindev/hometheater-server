<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('website-home.index');
    }
    public function about()
    {
        return view('website-about.index');
    }
}