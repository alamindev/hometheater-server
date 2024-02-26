<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\RandomPostResource;
use App\Http\Resources\SinglePostResource;
use App\Models\AllHeader;
use App\Models\BlogCategory;
use App\Models\Like;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function PostRandom()
    {
        $post = Post::with('likes')->where('active', 1)->InRandomOrder()->first();
        $post_header = AllHeader::where('type', 'blog')->select('title', 'details')->first();
        if ($post) {
            return response()->json([
                'success' => true,
                'post' => new RandomPostResource($post),
                'header' => $post_header,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'post' => '',
        ], 200);
    }
    public function PostRecent()
    {
        $posts = Post::where('active', 1)->InRandomOrder()->take(3)->get();
        if (count($posts) > 0) {
            return response()->json([
                'success' => true,
                'posts' =>   RandomPostResource::collection($posts),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'posts' => '',
        ], 200);
    }
    public function Categories()
    {
        $categories = BlogCategory::inRandomOrder()->select('id', 'name', 'slug')->take(11)->get();
        if (count($categories) > 0) {
            return response()->json([
                'success' => true,
                'categories' =>  $categories,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'categories' => '',
        ], 200);
    }
    /**
     * start coding for fetch post by category
     *
     */
    public function Post($slug = null)
    {
        $id = '';
        if (!is_null($slug)) {
            $category =  BlogCategory::where('slug', $slug)->first();
        } else {
            $category =  BlogCategory::first();
        }
        if ($category) {
            $posts =  Post::where('category_id', $category->id)->orderBy('created_at', 'desc')->take(6)->get();
            if (count($posts) > 0) {
                return response()->json([
                    'success' => true,
                    'posts' => PostResource::collection($posts),
                ], 200);
            }
        }

        return response()->json([
            'errors' => [
                "message" => 'No Blogs found for this Category!'
            ],
        ], 404);
    }
    /**
     * start coding for fetch post single post
     *
     */
    public function singlePost($slug)
    {
        $post = Post::with('likes', 'user', 'category')->where('slug', $slug)->first();
        if ($post) {
            return response()->json([
                'success' => true,
                'post' => new SinglePostResource($post),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'Post not found!'
            ],
        ], 404);
    }


    /**
     * Display data filter by category
     */

    public function filterByCategory($slug)
    {
        $category =  BlogCategory::where('slug', $slug)->first();

        if ($category) {
            $posts =  Post::where('category_id', $category->id)->take(6)->get();
            if (count($posts) > 0) {
                return response()->json([
                    'success' => true,
                    'posts' => PostResource::collection($posts),
                ], 200);
            }
        }
        return response()->json([
            'errors' => [
                "message" => 'Post not found!'
            ],
        ], 404);
    }
    /**
     * store like
     *
     */
    public function SubmitLike(Request $request)
    {
        $liked = Like::where('likeable_id', $request->post_id)->first();
        if ($liked) {
            if ($liked->likeable_id == $request->post_id && $liked->liked == true) {
                $this->is_liked(false, $request, $liked->id);
            } else {
                $this->is_liked(true, $request, $liked->id);
            }
        } else {
            $this->is_liked(true, $request);
        }

        return response()->json([
            'success' => true,
            'likes' =>   LikeResource::collection(Like::where('likeable_id', $request->post_id)->get())
        ], 200);
    }

    public function is_liked($val, $request, $id = null)
    {
        if (is_null($id)) {
            $like = new Like();
        } else {
            $like =  Like::find($id);
        }
        $like->liked = $val;
        $like->type = 'post';
        $like->user()->associate($request->user_id);
        $post = Post::find($request->post_id);
        $post->likes()->save($like);
    }

    /**
     * Subscribe post
     */
    public function Subscribe(Request $request)
    {
        $rules = array(
            'email' => 'required|email|unique:subscribers,email',
        );
        $validator = Validator::make($request->all(), (array)$rules);

        if (!$validator->fails()) {
            $subscriber = new Subscriber();
            $subscriber->email = $request->email;
            $subscriber->save();
            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
}