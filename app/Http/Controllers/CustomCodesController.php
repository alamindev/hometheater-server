<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Storage::exists('custom.css') && Storage::exists('custom.js')) {
            $css = Storage::get('custom.css');
            $js = Storage::get('custom.js');
            return  view('pages.custom-codes.custom-codes', compact('css', 'js'));
        }

        return  view('pages.custom-codes.custom-codes');
    }
    public function jsStore(Request $request)
    {
        if ($request->has('js')) {
            $js = $request->js;
            Storage::put('custom.js', $js);
        }

        return redirect()->route('customcodes');
    }

    public function cssStore(Request $request)
    {
        if ($request->has('css')) {
            $css = $request->css;
            Storage::put('custom.css', $css);
        }
        return redirect()->route('customcodes');
    }
}