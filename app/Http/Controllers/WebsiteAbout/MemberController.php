<?php

namespace App\Http\Controllers\WebsiteAbout;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AllHeader;
use App\Models\Dummymember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
class MemberController extends Controller
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
            $data = About::where('type','member')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->image).' width="100" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("website.about.member.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("website.about.member.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','photo'])
                ->make(true);
        }
        $edit = AllHeader::where('type','member')->first();
        return view('website-about.page.member.member', compact('edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('website-about.page.member.add-member');
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
            'user_name' => 'required',
            'photo' => 'required',
            'designation' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $member  = new About();
        $member->title = $request->user_name;
        $member->image = $img;
        $member->details = $request->designation;
        $member->type = 'member';
        $member->save();
        return redirect()->route('website.about.member');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'member_'.time();
                $folder = '/uploads/member/';
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
        $view = About::where('type','member')->find($id);
        return view('website-about.page.member.view-member', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = About::where('type','member')->find($id);
        return view('website-about.page.member.edit-member', compact('edit'));
    }
public function storeHeader(Request $request)
    {

        if($request->id){
            $allheader  = AllHeader::where('type', 'member')->find($request->id);
        }else{
            $allheader  = new AllHeader();
        }
        $allheader->title = $request->title;
        $allheader->type = 'member';
        $allheader->save();

        return redirect()->route('website.about.member');
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
            'title' => 'required',
            'details' => 'required',
        ]);

        $member  =   About::where('type','member')->find($id);
        $img = $this->update_site_image($request, $member);
        $member->title = $request->title;
        $member->image =  $img !== null ? $img : $member->image;
        $member->details = $request->details;
        $member->save();
        return redirect()->route('website.about.member');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'member_'.time();
                 $image_path =  $gallery->image;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/member/';
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
         $member = About::where('type','member')->find($id);
        if ($member) {
            $file_path = $member->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $member->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}