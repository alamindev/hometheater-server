<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use App\Models\Topheader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TopHeaderController extends Controller
{
    public function index()
    {
        $edit = Topheader::first();
        return view('website-home.page.top-header.top-header', compact('edit'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'btn_text' => 'required',
            'btn_link' => 'required',
            'details' => 'required',
        ]);
        if ($request->id) {
            $topheader  = Topheader::find($request->id);
            $img = $this->upload_site_image($request, $topheader);
        } else {
            $img = $this->upload_site_image($request, '');
            $topheader  = new Topheader();
        }
        $topheader->title = $request->title;
        $topheader->btn_text = $request->btn_text;
        $topheader->btn_link = $request->btn_link;
        $topheader->second_btn_text = $request->second_btn_text;
        $topheader->second_btn_link = $request->second_btn_link;
        $topheader->details = $request->details;
        $topheader->image = $img !== null ? $img : $topheader->image;
        $topheader->save();

        return redirect()->route('website.home.topheader');
    }



    /**
     * update photo
     */
    private function upload_site_image($request, $post)
    {
        if ($request->has('photo') && $request->photo != 'null') {
            $image = $request->file('photo');
            $name = '';
            $name = 'top_header_' . time();
            if (!empty($post)) {
                $image_path =  $post->image;
                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }
            }
            $folder = '/uploads/topheader/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        } else {
            return $post->photo;
        }
    }
}