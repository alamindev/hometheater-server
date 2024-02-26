<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
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
            $data = Post::with('tags', 'category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tag', function ($row) {
                    $store = '';
                    foreach ($row->tags()->pluck('name')->toArray() as $arr) {
                        $store .= "<span class='mx-1 badge badge-success'>$arr</span>";
                    }
                    return $store;
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('photo', function ($row) {
                    if ($row->photo) {
                        return '<img src=' . asset('storage' . $row->photo) . ' width="100" alt="post-image">';
                    }
                    return 'no photo';
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route("post.show", $row->id) . '  class="view btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a><a href=' . route("post.edit", $row->id) . '  class="edit btn btn-success btn-sm mr-2"><i class="fa fa-edit"></i></a><a href="javascript:void(0)"  data-remote=' . route("post.destroy", $row->id) . ' class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'tag', 'category', 'photo'])
                ->make(true);
        }

        return view('pages.post.posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('created_at', 'asc')->get();
        $tags = Tag::orderBy('created_at', 'asc')->get();
        return view('pages.post.add-post', compact('categories', 'tags'));
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
            'title' => 'required|unique:posts,slug',
            'category_id' => 'required',
            'tag' => 'required',
            'photo' => 'required',
            'details' => 'required',
        ]);
        $slug = Slug::createSlug($request->title, null, 'Post');
        $img = $this->upload_site_image($request);
        $post  = new Post;
        $post->title = $request->title;
        $post->slug =   $slug;
        $post->details = $request->details;
        $post->seo_details = $request->seo_details;
        $post->keyword = $request->keyword;
        $post->category_id = $request->category_id;
        $post->author_id = auth()->user()->id;
        $post->active = $request->status;
        $post->photo = $img;
        $post->save();

        $post->tags()->sync($request->tag);

        $activity = new Activity;
        $activity->user_id  = auth()->user()->id;
        $activity->type  = 'blog';
        $activity->text  = strip_tags(Str::words($request->details, 6));
        $activity->link  = '/blogs/' . $slug;
        $activity->save();

        return redirect()->route('posts');
    }

    /**
     * update photo
     */
    private function upload_site_image($request)
    {
        if ($request->has('photo')) {
            $image = $request->file('photo');
            $name = '';
            $name = 'post_' . time();
            $folder = '/uploads/posts/';
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
        $view = Post::with('tags', 'category')->find($id);
        return view('pages.post.view-post', compact('view'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Post::with('tags')->find($id);
        $categories = BlogCategory::orderBy('created_at', 'asc')->get();
        $tags = Tag::orderBy('created_at', 'asc')->get();
        return view('pages.post.edit-post', compact('edit', 'categories', 'tags'));
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
            'title' => 'required|unique:posts,slug',
            'category_id' => 'required',
            'tag' => 'required',
            'details' => 'required',
        ]);

        $post  =  Post::find($id);
        $post->title = $request->title;
        $slug = Slug::createSlug($request->title, null, 'Post');
        $post->slug =   $slug;
        $post->details = $request->details;
        $post->category_id = $request->category_id;
        $post->author_id = auth()->user()->id;
        $post->seo_details = $request->seo_details;
        $post->keyword = $request->keyword;
        $post->active = $request->status;
        $post->photo = $this->update_site_image($request, $post);
        $post->save();
        $post->tags()->sync($request->tag);
        return redirect()->route('posts');
    }
    /**
     * update photo
     */
    private function update_site_image($request, $post)
    {
        if ($request->has('photo') && $request->photo != 'null') {
            $image = $request->file('photo');
            $name = '';
            $name = 'post_' . time();
            $image_path =  $post->photo;
            if (Storage::exists($image_path)) {
                Storage::delete($image_path);
            }
            $folder = '/uploads/posts/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
            $name = !is_null($name) ? $name : Str::random(25);
            $image->storeAs($folder, $name . '.' . $image->getClientOriginalExtension(), 'public');
            return $filePath;
        } else {
            return $post->photo;
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
        $post = Post::find($id);
        if ($post) {
            $file_path = $post->photo;
            if (Storage::exists($file_path)) {
                Storage::delete($file_path);
            }
            $post->delete();
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

        return view('pages.post.file_browser')->with(compact('fileNames'));
    }
}