<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Slug;
class GalleryController extends Controller
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
            $data = Gallery::with('album')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('album', function($row){
                    return $row->album->name;
                })
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->photo).' width="100" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("gallery.show", $row->id).'  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href='.route("gallery.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("gallery.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','album','photo'])
                ->make(true);
        }

        return view('pages.gallery.galleries');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('pages.gallery.add-gallery');
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
            'album_id' => 'required',
            'photo' => 'required',
            'title' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $gallery  = new Gallery;
        $gallery->title = $request->title;
        $gallery->slug =   Slug::createSlug($request->title);
        $gallery->photo = $img;
        $gallery->install_date = $request->install_date;
        $gallery->details = $request->details;
        $gallery->album_id = $request->album_id;
        $gallery->save();
        return redirect()->route('galleries');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'gallery_'.time();
                $folder = '/uploads/galleries/';
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
        $view = Gallery::with('album')->find($id);
        return view('pages.gallery.view-gallery', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Gallery::with('album')->find($id);
        return view('pages.gallery.edit-gallery', compact('edit'));
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

         $request->validate([
            'album_id' => 'required',
            'title' => 'required',
        ]);

        $gallery  =   Gallery::find($id);
        $img = $this->update_site_image($request, $gallery);
        $gallery->title = $request->title;
        $gallery->photo =  $img !== null ? $img : $gallery->photo;
        $gallery->install_date = $request->install_date;
        $gallery->details = $request->details;
        $gallery->album_id = $request->album_id;
        $gallery->save();
        return redirect()->route('galleries');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'gallery_'.time();
                 $image_path =  $gallery->photo;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/galleries/';
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
         $gallery = Gallery::find($id);
        if ($gallery) {
            $file_path = $gallery->photo;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $gallery->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}
