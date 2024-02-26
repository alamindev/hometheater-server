<?php

namespace App\Http\Controllers\WebsiteAbout;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
class AboutSliderController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          if ($request->ajax()) {
            $data = About::where('type', 'slider')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->image).' width="100" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("website.about.slider.show", $row->id).'  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href='.route("website.about.slider.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("website.about.slider.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','photo'])
                ->make(true);
        }
        return view('website-about.page.slider.slider');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('website-about.page.slider.add-slider');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $slider  = new About();
        $slider->title = $request->title;
        $slider->image = $img;
        $slider->details = $request->details;
        $slider->type = 'slider';
        $slider->save();
        return redirect()->route('website.about.slider');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'slider_'.time();
                $folder = '/uploads/slider/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                 return $filePath;
            }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = About::where('type','slider')->find($id);
        return view('website-about.page.slider.view-slider', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = About::where('type','slider')->find($id);
        return view('website-about.page.slider.edit-slider', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $slider  =   About::where('type','slider')->find($id);
        $img = $this->update_site_image($request, $slider);
        $slider->title = $request->title;
        $slider->image =  $img !== null ? $img : $slider->image;
        $slider->details = $request->details;
        $slider->save();
        return redirect()->route('website.about.slider');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'slider_'.time();
                 $image_path =  $gallery->image;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/slider/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                 return $filePath;
            }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $slider = About::where('type','slider')->find($id);
        if ($slider) {
            $file_path = $slider->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $slider->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}