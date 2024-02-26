<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Services\Slug;
use Yajra\DataTables\Facades\DataTables;
class TagController extends Controller
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
            $data = Tag::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)"  data-remote='.route("tag.edit", $row->id).' class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("tag.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('pages.blog-tag.blog-tag');
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
        ]);
        $tag = new Tag();
         $tag->name  = $request->name;   
        $tag->slug =   Slug::createSlug($request->name);  
        
         $tag->save();

         return redirect()->route('tag');
    }

     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);
        return response($tag);
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
            ]);
            $id= $request->cate_id;
            $tag =  Tag::find($id);
            $tag->name  = $request->name;   
            $tag->save(); 

         return redirect()->route('tag');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if ($tag) { 
            $tag->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}
