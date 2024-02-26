<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use App\Models\AllHeader;
use Illuminate\Http\Request;

class BlogController extends Controller
{
  public function index()
    {
        $edit= AllHeader::where('type','blog')->first();
        return view('website-home.page.blog.blog', compact('edit'));
    }
     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
        ]);

        if($request->id){
            $allheader  = AllHeader::where('type', 'blog')->find($request->id);
        }else{
            $allheader  = new AllHeader();
        }

        $allheader->title = $request->title;
        $allheader->details = $request->details;
        $allheader->type = 'blog';
        $allheader->save();


        return redirect()->route('website.home.blog');
    }




}