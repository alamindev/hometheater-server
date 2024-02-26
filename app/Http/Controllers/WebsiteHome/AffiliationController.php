<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\AllHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
class AffiliationController extends Controller
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
            $data = Affiliation::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->image).' width="80" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("website.home.affiliation.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("website.home.affiliation.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','photo'])
                ->make(true);
        }
        $edit = AllHeader::where('type','affiliation')->first();
        return view('website-home.page.affiliation.affiliation', compact('edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('website-home.page.affiliation.add-affiliation');
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
        $affiliation  = new Affiliation;
        $affiliation->link =  $request->link;
        $affiliation->image = $img;
        $affiliation->save();
        return redirect()->route('website.home.affiliation');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'affiliation_'.time();
                $folder = '/uploads/affiliation/';
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                 return $filePath;
            }

    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Affiliation::find($id);
        return view('website-home.page.affiliation.edit-affiliation', compact('edit'));
    }
    public function storeHeader(Request $request)
    {

        if($request->id){
            $allheader  = AllHeader::where('type', 'affiliation')->find($request->id);
        }else{
            $allheader  = new AllHeader();
        }

        $allheader->title = $request->title;
        $allheader->details = $request->details;
        $allheader->type = 'affiliation';
        $allheader->save();

        return redirect()->route('website.home.affiliation');
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

        $affiliation  =   Affiliation::find($id);
        $img = $this->update_site_image($request, $affiliation);
        $affiliation->link =  $request->link;
        $affiliation->image =  $img !== null ? $img : $affiliation->image;
        $affiliation->save();
        return redirect()->route('website.home.affiliation');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'gallery_'.time();
                 $image_path =  $gallery->image;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/affiliation/';
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
         $affiliation = Affiliation::find($id);
        if ($affiliation) {
            $file_path = $affiliation->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $affiliation->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}