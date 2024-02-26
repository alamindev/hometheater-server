<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\RandomPostResource;
use App\Http\Resources\ServiceResource;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function blogSearch(Request $request)
    {

        $posts = Post::with('likes')
            ->where('title', 'LIKE', "%{$request->search}%")
            ->where('keyword', 'LIKE', "%{$request->search}%")
            ->get();
        if (count($posts) > 0) {
            return response()->json([
                'success' => true,
                'posts' => PostResource::collection($posts),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'No Blogs Found For Your Search!'
            ],
        ], 404);
    }
    public function serviceSearch(Request $request)
    {
        $keywords = explode(' ',$request->keyword);
        $services = Service::with('serviceImage')->where(function ($query) use ($keywords)
            {
            foreach($keywords as $keyword){
                $query->where('keyword', 'LIKE', "%{$keyword}%") ;
                }
            })->take(8)->orderBy('id', 'desc')->get();

        if (count($services) > 0) {
            return response()->json([
                'success' => true,
                'services' => ServiceResource::collection($services),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'No Services Found For Your Search!'
            ],
        ], 404);
    }
    public function LiveSearch(Request $request)
    {
        $keywords = explode(' ',$request->keyword);
        $services = Service::with('serviceImage')->where(function ($query) use ($keywords)
            {
            foreach($keywords as $keyword){
                $query->where('title', 'LIKE', "%{$keyword}%") ;
                $query->where('keyword', 'LIKE', "%{$keyword}%") ;
                }
            })->take(8)->orderBy('title', 'asc')->get();
        if (count($services) > 0) {
            return response()->json([
                'success' => true,
                'services' => ServiceResource::collection($services),
            ], 200);
        }
        return response()->json([
            'errors' => [
                "message" => 'No Services Found!'
            ],
        ], 404);
    }
}
