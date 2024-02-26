<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request; 
use Yajra\DataTables\Facades\DataTables;
use App\Services\Slug;

class BlogCategoryController extends Controller
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
            $data = BlogCategory::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn() 
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)"  data-remote='.route("blogCategory.edit", $row->id).' class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("blogCategory.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('pages.blog-category.blog-category');
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
        $blogCategory = new BlogCategory();
         $blogCategory->name  = $request->name;   
        $blogCategory->slug =   Slug::createSlug($request->name);  
        
         $blogCategory->save();

         return redirect()->route('blogCategory');
    }

     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = BlogCategory::find($id);
        return response($cate);
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
            $blogCategory =  BlogCategory::find($id);
            $blogCategory->name  = $request->name;   
            $blogCategory->save(); 

         return redirect()->route('blogCategory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = BlogCategory::find($id);
        if ($cate) { 
            $cate->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}
