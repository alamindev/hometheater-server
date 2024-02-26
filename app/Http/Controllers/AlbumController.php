<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Yajra\DataTables\Facades\DataTables;

use App\Services\Slug;
class AlbumController extends Controller
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
    public function index(Request $request)
    {
      if ($request->ajax()) {
            $data = Album::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function($row){
                     return $row->category->cate_name;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)"  data-remote='.route("album.edit", $row->id).' class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("album.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','category'])
                ->make(true);
        }

        return view('pages.album.album');
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
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $album = new Album();
         $album->name  = $request->name;
         $album->category_id  = $request->category_id;
        $album->slug =   Slug::createSlug($request->name);
         $album->save();
         return redirect()->route('album');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = album::find($id);
        return response($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);
            $id= $request->id;
            $album =  album::find($id);
         $album->name  = $request->name;
         $album->slug =   Slug::createSlug($request->name);
         $album->category_id  = $request->category_id;
         $album->save();
         return redirect()->route('album');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = album::find($id);
        if($album){
            $album->delete();
            return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}
