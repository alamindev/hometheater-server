<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllHeader;
use App\Models\Portfolio;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
class PortfolioController extends Controller
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
            $data = Portfolio::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->image).' width="100" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("website.home.portfolio.show", $row->id).'  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href='.route("website.home.portfolio.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("website.home.portfolio.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','photo'])
                ->make(true);
        }
        $edit = AllHeader::where('type','portfolio')->first();
        return view('website-home.page.portfolio.portfolio', compact('edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('website-home.page.portfolio.add-portfolio');
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
            'title' => 'required',
            'photo' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $choose_us  = new Portfolio;
        $choose_us->title = $request->title;
        $choose_us->image = $img !== null ? $img : $choose_us->image;
        $choose_us->details = $request->details;
        $choose_us->save();
        return redirect()->route('website.home.portfolio');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'portfolio_'.time();
                $folder = '/uploads/portfolio/';
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
        $view = Portfolio::find($id);
        return view('website-home.page.portfolio.view-portfolio', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Portfolio::find($id);
        return view('website-home.page.portfolio.edit-portfolio', compact('edit'));
    }
public function storeHeader(Request $request)
    {

        if($request->id){
            $allheader  = AllHeader::where('type', 'portfolio')->find($request->id);
        }else{
            $allheader  = new AllHeader();
        }

        $allheader->title = $request->title;
        $allheader->details = $request->details;
        $allheader->type = 'portfolio';
        $allheader->save();

        return redirect()->route('website.home.portfolio');
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
        ]);

        $choose_us  =   Portfolio::find($id);
        $img = $this->update_site_image($request, $choose_us);
        $choose_us->title = $request->title;
        $choose_us->image =  $img !== null ? $img : $choose_us->image;
        $choose_us->details = $request->details;
        $choose_us->save();
        return redirect()->route('website.home.portfolio');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'portfolio_'.time();
                 $image_path =  $gallery->image;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/portfolio/';
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
         $choose_us = Portfolio::find($id);
        if ($choose_us) {
            $file_path = $choose_us->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $choose_us->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}