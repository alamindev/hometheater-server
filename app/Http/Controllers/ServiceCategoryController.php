<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Slug;
class ServiceCategoryController extends Controller
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
            $data = ServiceCategory::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('cate_img', function($row){ 
                    if($row->type == 0){
                        return "<i class='$row->icon'></i>";
                    }else{
                        return '<img src='.asset('storage'. $row->cate_img).' width="100" alt="category-image">';
                    }
                }) 
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)"  data-remote='.route("serviceCategory.edit", $row->id).' class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("serviceCategory.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','cate_img'])
                ->make(true);
        }
      
        return view('pages.service-category.service-category');
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
            'cate_name' => 'required', 
        ]);
        $serviceCategory = new ServiceCategory();
         $serviceCategory->cate_name  = $request->cate_name;  
         $serviceCategory->type  = $request->type;  
        $serviceCategory->slug =   Slug::createSlug($request->cate_name); 

        if($request->type == 0){
            $serviceCategory->icon  = $request->icon;
        }else{
            if ($request->has('cate_img')) {    
                $image = $request->file('cate_img'); 
                $name = 'service_category_'.time();  
                $folder = '/uploads/service-category/'; 
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();  
                $name = !is_null($name) ? $name : Str::random(25); 
                $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                $serviceCategory->cate_img = $filePath; 
            } 
        }
        
         $serviceCategory->save();

         return redirect()->route('serviceCategory');
    }

     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = ServiceCategory::find($id);
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
                'cate_name' => 'required', 
            ]);
            $id= $request->cate_id;
            $serviceCategory =  ServiceCategory::find($id);
            $serviceCategory->cate_name  = $request->cate_name; 
            $serviceCategory->type  = $request->type;  
            if($request->type == 0){
                $serviceCategory->icon  = $request->icon;
            }else{
                if ($request->has('cate_img') && $id != null) { 
                        $image = $request->file('cate_img'); 
                        $name = 'service_category_'.time();   
                        $image_path =  $serviceCategory->cate_img;  
                        if (Storage::exists($image_path)) {
                            Storage::delete($image_path); 
                        }  
                        $folder = '/uploads/service-category/'; 
                        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();  
                        $name = !is_null($name) ? $name : Str::random(25); 
                        $image->storeAs($folder, $name.'.'.$image->getClientOriginalExtension(), 'public');
                        $serviceCategory->cate_img = $filePath;  
                    } 
            }
            $serviceCategory->save();
           

         return redirect()->route('serviceCategory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = ServiceCategory::find($id);
        if ($cate) {
            $file_path = $cate->cate_img;  
            if (Storage::exists($file_path)) {
                Storage::delete($file_path); 
            }  
            $cate->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}