<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductHeader;

class ProductHeaderController extends Controller
{
    public function index()
    {
        $edit= ProductHeader::first();
        return view('website-home.page.product-header.product-header', compact('edit'));
    }
     public function store(Request $request)
    { 
        if($request->id){
            $ProductHeader  = ProductHeader::find($request->id); 
        }else{
            $ProductHeader  = new ProductHeader(); 
        } 
        $ProductHeader->title = $request->title;
        $ProductHeader->description = $request->description;

        $ProductHeader->save();

        return redirect()->route('website.home.productheader');
    }
    
}
