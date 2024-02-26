<?php

namespace App\Http\Controllers\WebsiteHome;

use App\Http\Controllers\Controller;
use App\Models\AllHeader;
use App\Models\DummyReview;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DummyReviewController extends Controller
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
            $data = DummyReview::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    return '<img src='.asset('storage'. $row->image).' width="100" alt="gallery-image">';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href='.route("website.home.review.show", $row->id).'  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href='.route("website.home.review.edit", $row->id).'  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote='.route("website.home.review.destroy", $row->id).' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','photo'])
                ->make(true);
        }
        $edit = AllHeader::where('type','review')->first();
        return view('website-home.page.review.review', compact('edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('website-home.page.review.add-review');
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
            'text' => 'required',
            'rating' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $review  = new DummyReview();
        $review->user_name = $request->user_name;
        $review->location = $request->location;
        $review->image = $img;
        $review->text = $request->text;
        $review->rating = $request->rating;
        $review->save();
        return redirect()->route('website.home.review');
    }

    /**
     * update photo
     */
     private function upload_site_image($request)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'dummy_review_'.time();
                $folder = '/uploads/review/';
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
        $view = DummyReview::find($id);
        return view('website-home.page.review.view-review', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = DummyReview::find($id);
        return view('website-home.page.review.edit-review', compact('edit'));
    }
public function storeHeader(Request $request)
    {

        if($request->id){
            $allheader  = AllHeader::where('type', 'review')->find($request->id);
        }else{
            $allheader  = new AllHeader();
        }

        $allheader->title = $request->title;
        $allheader->details = $request->details;
        $allheader->type = 'review';
        $allheader->save();

        return redirect()->route('website.home.review');
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
            'user_name' => 'required',
            'text' => 'required',
            'rating' => 'required',
        ]);

        $review  =   DummyReview::find($id);
        $img = $this->update_site_image($request, $review);
        $review->user_name = $request->user_name;
        $review->location = $request->location;
        $review->image =  $img !== null ? $img : $review->image;
        $review->text = $request->text;
        $review->rating = $request->rating;
        $review->save();
        return redirect()->route('website.home.review');
    }
 /**
     * update photo
     */
     private function update_site_image($request, $gallery)
    {
            if ($request->has('photo')) {
                $image = $request->file('photo');
                $name = 'dummy_review_'.time();
                 $image_path =  $gallery->image;
                    if (Storage::exists($image_path)) {
                        Storage::delete($image_path);
                    }
                $folder = '/uploads/review/';
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
         $review = DummyReview::find($id);
        if ($review) {
            $file_path = $review->image;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $review->delete();
             return response()->json(['message' => 'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }
}