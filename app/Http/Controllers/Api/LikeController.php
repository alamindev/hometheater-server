<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Models\Activity;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LikeController extends Controller
{
    /**
     * store like
     *
     */
    public function store(Request $request)
    {
        $liked = Like::where('likeable_id', $request->gallery_id)->first();
        if ($liked) {
            if ($liked->likeable_id == $request->gallery_id && $liked->liked == true) {
                $this->is_liked(false, $request, $liked->id);
            } else {
                $this->is_liked(true, $request, $liked->id);
            }
        } else {
            $this->is_liked(true, $request);
        }

        return response()->json([
            'success' => true,
            'like_counts' => Like::where('likeable_id', $request->gallery_id)->where('liked', true)->count(),
            'likes' =>   LikeResource::collection(Like::where('likeable_id', $request->gallery_id)->get())
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
        $like->type = 'gallery';
        $like->user()->associate($request->user_id);
        $gallery = Gallery::find($request->gallery_id);
        $album = Album::find($gallery->album_id);
        $gallery->likes()->save($like);

        $activity = new Activity();
        $activity->user_id  = $request->user_id;
        $activity->type  = 'like';
        $activity->text  = 'null';
        $activity->link  = '/gallery/' . $album->slug . '?modal=true&slug='.$gallery->slug;
        $activity->save();
    }
}
