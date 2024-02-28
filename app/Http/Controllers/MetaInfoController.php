<?php

namespace App\Http\Controllers;

use App\Models\MetaInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MetaInfoController extends Controller
{
    public function homepage()
    {
        $edit = MetaInfo::where('type', 'home')->first();
        return view('website-meta-info.page.home-page', compact('edit'));
    }
    public function service()
    {
        $edit = MetaInfo::where('type', 'service')->first();
        return view('website-meta-info.page.service', compact('edit'));
    }
    public function product()
    {
        $edit = MetaInfo::where('type', 'product')->first();
        return view('website-meta-info.page.product', compact('edit'));
    }
    public function booking()
    {
        $edit = MetaInfo::where('type', 'booking')->first();
        return view('website-meta-info.page.booking', compact('edit'));
    }
    public function blog()
    {
        $edit = MetaInfo::where('type', 'blog')->first();
        return view('website-meta-info.page.blog', compact('edit'));
    }
    public function gallery()
    {
        $edit = MetaInfo::where('type', 'gallery')->first();
        return view('website-meta-info.page.gallery', compact('edit'));
    }
    public function contact()
    {
        $edit = MetaInfo::where('type', 'contact')->first();
        return view('website-meta-info.page.contact', compact('edit'));
    }
    public function login()
    {
        $edit = MetaInfo::where('type', 'login')->first();
        return view('website-meta-info.page.login', compact('edit'));
    }
    public function register()
    {
        $edit = MetaInfo::where('type', 'register')->first();
        return view('website-meta-info.page.register', compact('edit'));
    }
    public function portfolio()
    {
        $edit = MetaInfo::where('type', 'portfolio')->first();
        return view('website-meta-info.page.portfolio', compact('edit'));
    }

    public function store(Request $request, $type)
    {
        if ($request->id) {
            $metainfo  = MetaInfo::where('type', $type)->find($request->id);
            $img = $this->upload_site_image($request, $metainfo);
        } else {
            $img = $this->upload_site_image($request, '');
            $metainfo  = new MetaInfo();
        }
        $metainfo->title = $request->title;
        $metainfo->description = $request->details;
        $metainfo->keyword = $request->keyword;
        $metainfo->type = $type;
        $metainfo->image = $img !== null ? $img : $metainfo->image;
        $metainfo->save();
        if ($type == 'home') {
            return redirect()->route('website.info.home');
        } elseif ($type == 'service') {
            return redirect()->route('website.info.service');
        } elseif ($type == 'booking') {
            return redirect()->route('website.info.booking');
        } elseif ($type == 'blog') {
            return redirect()->route('website.info.blog');
        } elseif ($type == 'gallery') {
            return redirect()->route('website.info.gallery');
        } elseif ($type == 'contact') {
            return redirect()->route('website.info.contact');
        } elseif ($type == 'login') {
            return redirect()->route('website.info.login');
        } elseif ($type == 'register') {
            return redirect()->route('website.info.register');
        }elseif ($type == 'product') {
            return redirect()->route('website.info.product');
        }
    }



    /**
     * update photo
     */
    private function upload_site_image($request, $meta)
    {
        if ($request->has('photo') && $request->photo != 'null') {
            $image = $request->file('photo');
            $name = '';
            $name = 'top_header_' . time();
            if (!empty($meta)) {
                $image_path =  $meta->image;
                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }
            }
            $folder = '/uploads/meta/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        } else {
            if ($meta != '') {
                return $meta->image;
            }
        }
    }
}