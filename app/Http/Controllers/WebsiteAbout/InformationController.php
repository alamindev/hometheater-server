<?php

namespace App\Http\Controllers\WebsiteAbout;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class InformationController extends Controller
{
     public function index()
    {
        $edit= About::where('type','information')->first();
        return view('website-about.page.information.information', compact('edit'));
    }
     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'details' => 'required',
        ]);
        if($request->id){
            $information  = About::where('type','information')->find($request->id);
            $img = $this->upload_site_image($request, $information);
        }else{
            $img = $this->upload_site_image($request, '');
            $information  = new About();
        }
        $information->title = $request->title;
        $information->details = $request->details;
        $information->image = $img !== null ? $img : $information->image;
        $information->type = 'information';
        $information->save();

        return redirect()->route('website.about.information');
    }



     /**
     * update photo
     */
     private function upload_site_image($request, $post)
    {
           if ($request->has('photo') && $request->photo != 'null') {
                $image = $request->file('photo');
              $name = '';
                 $name = 'information_'.time();
                 if(!empty($post)){
                    $image_path =  $post->image;
                        if (Storage::exists($image_path)) {
                            Storage::delete($image_path);
                        }
                    }
                $folder = '/uploads/information/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                return $filePath;
            } else{
                return $post->photo;
            }

    }
}