<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
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
            $data = Page::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('thumb', function ($row) {
                    return '<img src=' . asset('storage' . $row->thumb) . ' width="100" alt="page-image">';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("page.show", $row->id) . '  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href=' . route("page.edit", $row->id) . '  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote=' . route("page.destroy", $row->id) . ' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'thumb'])
                ->make(true);
        }

        return view('pages.page.pages');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.page.add-page');
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
            'name' => 'required|min:3',
            'title' => 'required',
            'type' => 'required',
            'content' => 'required',
        ]);
        $img = $this->upload_site_image($request);
        $page  = new Page;
        $page->title = $request->name;
        $page->main_title = $request->title;
        $page->slug =   Slug::createSlug($request->name);
        $page->type = $request->type;
        $page->seo_details = $request->seo_details;
        $page->content = $request->content;
        $page->keyword = $request->keyword;
        $page->thumb = $img;
        $page->save();
        return redirect()->route('pages');
    }

    /**
     * update photo
     */
    private function upload_site_image($request)
    {
        if ($request->has('thumb')) {
            $image = $request->file('thumb');
            $name = '';
            if ($request->type == 0) {
                $name = 'page_' . time();
            } else {
                $name = 'page_' . time();
            }

            $folder = '/uploads/pages/';
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
        $view = page::find($id);
        return view('pages.page.view-page', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = page::find($id);
        return view('pages.page.edit-page', compact('edit'));
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
            'name' => 'required|min:3',
            'title' => 'required',
            'content' => 'required',
            'type' => 'required',
        ]);

        $page  =  Page::find($id);
        $page->title = $request->name;
        $page->main_title = $request->title;
        $page->content = $request->content;
        $page->seo_details = $request->seo_details;
        $page->type = $request->type;
        $page->keyword = $request->keyword;

        $page->thumb =  $this->update_site_image($request, $page);
        $page->save();
        return redirect()->route('pages');
    }
    /**
     * update photo
     */
    private function update_site_image($request, $page)
    {
        if ($request->has('thumb') && $request->thumb != 'null') {
            $image = $request->file('thumb');
            $name = '';
            if ($request->type == 0) {
                $name = 'page_' . time();
            } else {
                $name = 'page_' . time();
            }
            $image_path =  $page->photo;
            if (Storage::exists($image_path)) {
                Storage::delete($image_path);
            }
            $folder = '/uploads/pages/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        } else {
            return $page->thumb;
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
        $page = Page::find($id);
        if ($page) {
            $file_path = $page->photo;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $page->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'error']);
        }
    }

    public function upload(Request $request)
    {

        $CKEditor = $request->input('CKEditor') ? $request->input('CKEditor') : null;

        $funcNum = $request->input('CKEditorFuncNum') ? $request->input('CKEditorFuncNum') : null;

        $message = $url = '';

        if ($request->hasFile('upload')) {

            $file = $request->file('upload');

            if ($file->isValid()) {

                $filename = rand(1000, 9999) . $file->getClientOriginalName();

                $file->move(public_path() . '/uploads/', $filename);

                $url = url('uploads/' . $filename);
            } else {

                $message = 'An error occurred while uploading the file.';
            }
        } else {

            $message = 'No file uploaded.';
        }

        if ($_GET['type'] == 'file') {

            return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';
        }

        $data = ['uploaded' => 1, 'fileName' => $filename, 'url' => $url];

        return json_encode($data);
    }

    public function fileBrowser()
    {

        $paths = glob(public_path('uploads/*'));

        $fileNames = array();

        foreach ($paths as $path) {

            array_push($fileNames, basename($path));
        }

        return view('pages.page.file_browser')->with(compact('fileNames'));
    }
}