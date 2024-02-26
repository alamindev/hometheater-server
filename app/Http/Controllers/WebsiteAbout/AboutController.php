<?php

namespace App\Http\Controllers\WebsiteAbout;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
     public function index()
    {
        $edit= About::where('type','aboutmore')->first();
        return view('website-about.page.aboutmore.aboutmore', compact('edit'));
    }
     public function store(Request $request)
    {

        if($request->id){
            $aboutmore  = About::where('type','aboutmore')->find($request->id);
        }else{
            $aboutmore  = new About();
        }
        $aboutmore->title = $request->title;
        $aboutmore->details = $request->details;
        $aboutmore->type = 'aboutmore';
        $aboutmore->save();

        return redirect()->route('website.about.aboutmore');
    }



}
