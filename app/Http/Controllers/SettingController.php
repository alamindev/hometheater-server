<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return  view('pages.setting.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'max:1500',
            'favicon' => 'max:500',
        ]);
        $id = $request->id;
        $site_logo = $this->upload_site_logo($request, $id);
        $fav_icon = $this->upload_fav_icon($request, $id);
        $footer_logo = $this->upload_footer_logo($request, $id);
        if ($id != null) {
            $setting  = Setting::first();
            $setting->copyright = $request->copyright;
            $setting->taxes = $request->taxes;
            $setting->site_title = $request->site_title;
            $setting->analytics_id = $request->analytics_id;
            $setting->site_logo = $site_logo !== null ? $site_logo : $setting->site_logo;
            $setting->favicon = $fav_icon !== null ? $fav_icon : $setting->favicon;
            $setting->footer_logo = $footer_logo !== null ? $footer_logo : $setting->footer_logo;
            $setting->footer_details = $request->footer_details;
            $setting->facebook = $request->facebook;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->contact_email = $request->contact_email;
            $setting->contact_number = $request->contact_number;
            $setting->save();
        } else {
            $setting  = new Setting;
            $setting->site_logo = $site_logo; 
            $setting->site_title = $request->site_title;
            $setting->analytics_id = $request->analytics_id;
            $setting->favicon = $fav_icon;
            $setting->copyright = $request->copyright;
            $setting->taxes = $request->taxes;
            $setting->footer_logo = $footer_logo;
            $setting->footer_details = $request->footer_details;
            $setting->facebook = $request->facebook;
            $setting->instagram = $request->instagram;
            $setting->twitter = $request->twitter;
            $setting->contact_email = $request->contact_email;
            $setting->contact_number = $request->contact_number;
            $setting->save();
        }

        return redirect()->route('setting');
    }

    private function upload_site_logo($request, $id = null)
    {
        if ($request->has('site_logo')) {
            $image = $request->file('site_logo');
            $name = 'logo_' . time();
            if ($id != null) {
                $setting  = Setting::first();
                $image_path =  $setting->site_logo;
                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }
            }
            $folder = '/uploads/images/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            Storage::disk('public')->put($filePath, File::get($image));
            return $filePath;
        }
    }



    private function upload_fav_icon($request,  $id = null)
    {
        if ($request->has('favicon')) {
            $image = $request->file('favicon');
            $name = 'favicon_' . time();
            if ($id != null) {
                $setting  = Setting::first();
                $image_path =  $setting->favicon;
                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }
            }
            $folder = '/uploads/images/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        }
    }
    private function upload_footer_logo($request,  $id = null)
    {
        if ($request->has('footer_logo')) {
            $image = $request->file('footer_logo');
            $name = 'footer_logo_' . time();
            if ($id != null) {
                $setting  = Setting::first();
                $image_path =  $setting->footer_logo;
                if (Storage::exists($image_path)) {
                    Storage::delete($image_path);
                }
            }
            $folder = '/uploads/images/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        }
    }
}