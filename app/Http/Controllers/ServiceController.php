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

class ServiceController extends Controller
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
            $data = Service::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category->cate_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("service.show", $row->id) . '  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href=' . route("service.edit", $row->id) . '  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote=' . route("service.destroy", $row->id) . ' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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

        return view('pages.service.services');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.service.add-service');
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
            'duration' => 'required',
            'category_id' => 'required',
            'service_type' => 'required|min:6|max:7',
            'image' => 'required',
            'thumbnail' => 'required',
        ]);
        $service  = new Service;
        $service->title = $request->title;
        $service->slug =   Slug::createSlug($request->slug);
        $service->service_type = $request->service_type;
        $service->basic_price = $request->basic_price;
        $service->icon = $request->icon;
        // $service->type = $request->type;
        // $service->svg = $request->svg;
        $service->details = $request->details;
        $service->seo_details = $request->seo_details;
        $service->keyword = $request->keyword;
        $service->duration = $request->duration;
        $service->category_id = $request->category_id;
		if( $request->suggestion){
			 $service->suggestion = implode(',', $request->suggestion);
		}


        if ($request->feature != null && count($request->feature) > 0) {
            $feature = '';

            for ($i = 0; $i < count($request->feature); $i++) {
                $feature .= $request->feature[$i] . "||#||";
            }
            $service->datas = $feature;
        }
          $service->thumbnail =  $this->upload_thumbnail($request);

        $service->save();

        $service_id = $service->id;
        $this->upload_site_image($request, $service_id);
        if ($request->question_title != null && count($request->question_title) > 0) {
            $question_title = $request->question_title;
            foreach ($question_title  as $title) {
                $service_question = new ServiceQuestion();
                $service_question->name = $title['title'];
                $service_question->service_id = $service_id;
                $service_question->save();
                unset($title['title']);
                foreach ($title as $t) {
                    $option = new QuestionOption();
                    $option->title = $t['option'];
                    $option->price = $t['price'];
                    $option->question_id = $service_question->id;
                    $option->save();
                }
            }
        }

        return redirect()->route('services');
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
        $view = Service::with('serviceQuestion', 'category')->find($id);
        return view('pages.service.view-service', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Service::with('serviceQuestion', 'category')->find($id);
        return view('pages.service.edit-service', compact('edit'));
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
            'category_id' => 'required',
            'service_type' => 'required|min:6|max:7',
        ]);

        $service  =   Service::find($id);
        $service->title = $request->title;
        $service->service_type = $request->service_type;
        $service->basic_price = $request->basic_price;
        $service->slug =   Slug::createSlug($request->slug);
        $service->icon = $request->icon;
        $service->details = $request->details;
        // $service->type = $request->type;
        // $service->svg = $request->svg;
        $service->seo_details = $request->seo_details;
        $service->keyword = $request->keyword;
        $service->duration = $request->duration;
        $service->category_id = $request->category_id;
        if($request->suggestion){
			 $service->suggestion = implode(',', $request->suggestion);
		}else{
             $service->suggestion = '';
        }

        if ($request->feature != null && count($request->feature) > 0) {
            $feature = '';
            for ($i = 0; $i < count($request->feature); $i++) {
                $feature .= $request->feature[$i] . "||#||";
            }
            $service->datas = $feature;
        }

         $service->thumbnail = $this->update_thumbnail($request, $service);
        $service->save();

        $service_id = $service->id;
        $this->update_site_image($request, $service_id);

        if ($request->question_title != null && count($request->question_title) > 0) {
            $question_title = $request->question_title;
            if ($request->question_id != '') {
                ServiceQuestion::where('service_id', $service_id)->whereNotIn('id', $request->question_id)->delete();
            }
            if ($request->option_delete_ids != '') {
                QuestionOption::whereIn('question_id', $request->question_id)->whereIn('id', $request->option_delete_ids)->delete();
            }
          
            for ($i = 0; $i < count($question_title); $i++) {
                $question =  ServiceQuestion::where('id', !empty($request->question_id[$i]) ? $request->question_id[$i] : '')->first();
                if(array_key_exists('title',$question_title[$i])){
                if ($question) {
                    $service_question = ServiceQuestion::find($question->id);
                    $service_question->name = $question_title[$i]['title'];
                    $service_question->service_id = $service_id;
                    $service_question->save();
                }else {   
                        $service_question = new ServiceQuestion();
                        $service_question->name = $question_title[$i]['title'];
                        $service_question->service_id = $service_id;
                        $service_question->save(); 
                  
                }    

             
                    unset($question_title[$i]['title']);
                

                    for ($t = 0; $t < count($question_title[$i]); $t++) {
                        $option =  QuestionOption::where('id', !empty($question_title[$i][$t]['option_id']) ? $question_title[$i][$t]['option_id'] : '')->first();
                        if(array_key_exists($t, $question_title[$i])){
                            if ($option) {
                                $question_option = QuestionOption::find($option->id);
                                $question_option->title = $question_title[$i][$t]['option'];
                                $question_option->price = $question_title[$i][$t]['price'];
                                $question_option->question_id = $service_question->id;
                                $question_option->save();
                            } else {
                                $question_option = new QuestionOption();
                                $question_option->title = $question_title[$i][$t]['option'];
                                $question_option->price = $question_title[$i][$t]['price'];
                                $question_option->question_id = $service_question->id;
                                $question_option->save();
                            }
                        }
                    }
                }
            }
         
        } else {
            ServiceQuestion::where('service_id', $service_id)->delete();
        }

        return redirect()->route('services');
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
