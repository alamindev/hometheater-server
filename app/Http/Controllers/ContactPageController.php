<?php

namespace App\Http\Controllers;

use App\Models\ContactPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class ContactPageController extends Controller
{
      public function index()
    {
        $edit= ContactPage::first();
        return view('pages.contact-page.contact', compact('edit'));
    }
     public function store(Request $request)
    {

        if($request->id){
            $contact  = ContactPage::find($request->id);
        }else{
            $contact  = new ContactPage();
        }
        $image = $this->upload_images($request, $request->id);
        $contact->title = $request->title;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->image = $image !== null ? $image : $contact->image;
        $contact->save();

        return redirect()->route('contactpage');
    }

     private function upload_images($request, $id = null)
    {
            if ($request->has('image')) {
                $image = $request->file('image');
                $name = 'contact_page_'.time();
                    if($id != null){
                        $setting  = ContactPage::first();
                        $image_path =  $setting->image;
                        if (Storage::exists($image_path)) {
                            Storage::delete($image_path);
                        }
                    }
                $folder = '/uploads/images/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

                Storage::disk('public')->put($filePath, File::get($image));
                      return $filePath;
            }

    }
}