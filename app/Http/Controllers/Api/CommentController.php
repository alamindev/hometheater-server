<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Activity;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->type = 'gallery';
        $comment->user()->associate($request->user_id);
        $gallery = Gallery::find($request->gallery_id);
        $album = Album::find($gallery->album_id);
        $gallery->comments()->save($comment);
        $ga  = Gallery::with('comments')->find($request->gallery_id)->first();
        $count = '';
        if ($ga) {
            $count = count($ga->comments) > 0 ? count($ga->comments) : '';
        }
        $activity = new Activity();
        $activity->user_id  = $request->user_id;
        $activity->comment_id  = $comment->id;
        $activity->type  = 'comment';
        $activity->text  = strip_tags(Str::words($request->comment, 5));
        $activity->link  ='/gallery/' . $album->slug . '?modal=true&slug='.$gallery->slug;
        $activity->save();

        return response()->json([
            'success' => true,
            'comment' => new CommentResource(Comment::where('id', $comment->id)->first()),
            'comment_counts' =>   $count
        ], 200);
    }
}
