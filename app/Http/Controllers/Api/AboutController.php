<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AllHeader;
use Illuminate\Http\Request;

class AboutController extends Controller
{
  public function FetchAllData()
  {

        $sliders = About::where('type','slider')->select('id','title','image','details')->get();
        $information = About::where('type','information')->select('title','image','details')->first();
        $members = About::where('type','member')->select('id','title','image','details')->get();
        $counters = About::where('type','counter')->select('id','title','details')->get();
        $about = About::where('type','aboutmore')->select('title','details')->first();
        $header = AllHeader::where('type','member')->select('title')->first();
        return response()->json([
            'success' => true,
            'sliders' => $sliders,
            'information' => $information,
            'members' => $members,
            'counters' => $counters,
            'about' => $about,
            'header' => $header,
        ], 200);
  }
}