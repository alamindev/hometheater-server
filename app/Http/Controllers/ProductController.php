<?php

namespace App\Http\Controllers;

use App\Models\QuestionOption;
use App\Models\Service;
use App\Models\ServiceCost;
use App\Models\ServiceImage;
use App\Models\ServiceInclude;
use App\Models\ServiceQuestion;
use Illuminate\Http\Request;
use App\Services\Slug;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
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
            $data = Service::with('category')->where('type', 1)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category->cate_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("product.show", $row->id) . '  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href=' . route("product.edit", $row->id) . '  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote=' . route("product.destroy", $row->id) . ' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                  ->addColumn('thumbnail', function ($row) {
                    if ($row->thumbnail) {
                        return '<img src=' . asset('storage'. $row->thumbnail) . ' width="100" alt="user-image">';
                    }
                    return 'No photo';
                })
                ->rawColumns(['action', 'category', 'thumbnail'])
                ->make(true);
        }

        return view('pages.product.products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.product.add-product');
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
            'slug' => 'required',
            'basic_price' => 'required', 
            'category_id' => 'required',
            'delivery_time' => 'required',
            'service_type' => 'required|min:6|max:7',
            'image' => 'required',
            'thumbnail' => 'required',
        ]);
        $product  = new Service;
        $product->title = $request->title;
        $product->slug = Slug::createSlug($request->slug);
        $product->service_type = $request->service_type;
        $product->basic_price = $request->basic_price;
        $product->type = 1;
        $product->icon = $request->icon; 
        $product->delivery_time = $request->delivery_time; 
        $product->details = $request->details;
        $product->seo_details = $request->seo_details;
        $product->keyword = $request->keyword; 
        $product->category_id = $request->category_id;
		if( $request->suggestion){
			 $product->suggestion = implode(',', $request->suggestion);
		}


        if ($request->feature != null && count($request->feature) > 0) {
            $feature = '';

            for ($i = 0; $i < count($request->feature); $i++) {
                $feature .= $request->feature[$i] . "||#||";
            }
            $product->datas = $feature;
        }
          $product->thumbnail =  $this->upload_thumbnail($request);

        $product->save();

        $product_id = $product->id;

        $this->upload_site_image($request, $product_id);
         
        return redirect()->route('products');
    }

    /**
     * update photo
     */
    private function upload_site_image($request, $servie_id)
    {
        if ($request->has('image')) {
            foreach ($request->image as $key => $image) {
                $name = 'service_' . $key . "_" . time();
                $folder = '/uploads/services/';
                $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                $name = !is_null($name) ? $name : Str::random(25);
                $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
                $img = new ServiceImage();
                $img->image = $filePath;
                $img->service_id = $servie_id;
                $img->save();
            }
        }
    }
    /**
     * update thumbnail
     */
    private function upload_thumbnail($request)
    {
        if ($request->has('thumbnail')) {
            $image = $request->file('thumbnail');
            $name = 'service_thumb'.time();
            $folder = '/uploads/services/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
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
        $view = Service::with('category')->where('type', 1)->find($id);
        return view('pages.product.view-product', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Service::with('category')->find($id);
        return view('pages.product.edit-product', compact('edit'));
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
            'duration' => 'required',
            'basic_price' => 'required',
            'delivery_time' => 'required',
            'category_id' => 'required',
            'service_type' => 'required|min:6|max:7',
        ]);

        $product  =   Service::find($id);
        $product->title = $request->title;
        $product->service_type = $request->service_type;
        $product->basic_price = $request->basic_price;
        $product->slug =   Slug::createSlug($request->slug);
        $product->icon = $request->icon;
        $product->type = 1;
        $product->details = $request->details; 
        $product->delivery_time = $request->delivery_time;
        $product->seo_details = $request->seo_details;
        $product->keyword = $request->keyword; 
        $product->category_id = $request->category_id;
        if($request->suggestion){
			 $product->suggestion = implode(',', $request->suggestion);
		}else{
             $product->suggestion = '';
        }

        if ($request->feature != null && count($request->feature) > 0) {
            $feature = '';
            for ($i = 0; $i < count($request->feature); $i++) {
                $feature .= $request->feature[$i] . "||#||";
            }
            $product->datas = $feature;
        }

        $product->thumbnail = $this->update_thumbnail($request, $product);
        $product->save();

        $service_id = $product->id;
        $this->update_site_image($request, $service_id); 

        return redirect()->route('products');
    }

    /**
     * update photo
     */
    private function update_site_image($request, $service_id)
    {
        $collection = collect($request->image);
        $delete_images = ServiceImage::where('service_id', $service_id)->whereNotIn('id',  $collection->pluck('id'))->get();
        foreach ($delete_images as $img) {
            if (Storage::exists($img->image)) {
                Storage::delete($img->image);
            }
            ServiceImage::where('id', $img->id)->delete();
        }
        $service_images = ServiceImage::whereIn('id', $request->update_img)->get();
        if (count($service_images) > 0) {
            foreach ($service_images as $img) {
                if (Storage::exists($img->image)) {
                    Storage::delete($img->image);
                }
            }
            foreach ($request->image as $key => $img) {
                if (!empty($img['img'])) {
                    $image = $img['img'];
                    $name = 'service_' . $key . "_" . time();
                    $folder = '/uploads/services/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $name = !is_null($name) ? $name : Str::random(25);
                    $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
                    if (!empty($img['id'])) {
                        $img =  ServiceImage::find($img['id']);
                    } else {
                        $img = new ServiceImage();
                    }
                    $img->image = $filePath;
                    $img->service_id = $service_id;
                    $img->save();
                }
            }
        } else {
            foreach ($request->image as $key => $img) {
                if (!empty($img['img'])) {
                    $image = $img['img'];
                    $name = 'service_' . $key . "_" . time();
                    $folder = '/uploads/services/';
                    $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
                    $name = !is_null($name) ? $name : Str::random(25);
                    $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
                    $img = new ServiceImage();
                    $img->image = $filePath;
                    $img->service_id = $service_id;
                    $img->save();
                }
            }
        }
    }
/**
     * update thumbnail
     */
    private function update_thumbnail($request, $service)
    {
         if ($request->has('thumbnail') && $request->photo != 'null') {
            $image = $request->file('thumbnail');
            $image_path =  $service->thumbnail;
            if (Storage::exists($image_path)) {
                Storage::delete($image_path);
            }
            $name = 'service_thumbnail'. time();
            $folder = '/uploads/services/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        } else {
            return  $service->thumbnail;
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
        $service = Service::find($id);
        if ($service) {
            $file_path = $service->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $service->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'error']);
        }
    }
}
