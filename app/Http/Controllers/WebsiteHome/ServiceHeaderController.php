<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use App\Models\ServiceHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ServiceHeaderController extends Controller
{
 public function index()
    {
        $edit= ServiceHeader::first();
        return view('website-home.page.service-header.service-header', compact('edit'));
    }
     public function store(Request $request)
    {

        if($request->id){
            $ServiceHeader  = ServiceHeader::find($request->id);
            $img = $this->upload_site_image($request, $ServiceHeader);
        }else{
            $ServiceHeader  = new ServiceHeader();
               $img = $this->upload_site_image($request, '');
        }

        $ServiceHeader->home_title = $request->home_title;
        $ServiceHeader->home_details = $request->home_details;
        $ServiceHeader->service_title = $request->service_title;
        $ServiceHeader->service_details = $request->service_details;
        $ServiceHeader->service_btn_text = $request->service_btn_text;
        $ServiceHeader->service_btn_link = $request->service_btn_link;
        $ServiceHeader->image = $img;
        $ServiceHeader->booking_title = $request->booking_title;
        $ServiceHeader->booking_details = $request->booking_details;

        $ServiceHeader->save();

        return redirect()->route('website.home.serviceheader');
    }
   /**
     * update photo
     */
     private function upload_site_image($request, $post)
    {
           if ($request->has('photo') && $request->photo != 'null') {
                $image = $request->file('photo');
              $name = '';
                 $name = 'service_header_'.time();
                 if(!empty($post)){
                    $image_path =  $post->image;
                        if (Storage::exists($image_path)) {
                            Storage::delete($image_path);
                        }
                    }
                $folder = '/uploads/serviceheader/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                return $filePath;
            } else{
                return $post->photo;
            }

    }
}
