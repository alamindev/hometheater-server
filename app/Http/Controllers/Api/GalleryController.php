<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GallerySingleResource;
use App\Models\Activity;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\ServiceCategory;
use App\Models\ShareCount;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $album =  Album::where('slug', $slug)->first();

        if ($album) {
            $galleries =  Gallery::where('album_id', $album->id)->orderBy('created_at', 'asc')->get();
            if (count($galleries) > 0) {
                return response()->json([
                    'success' => true,
                    'galleries' => GalleryResource::collection($galleries),
                    'album_name' => $album->name,
                ], 200);
            }
        }

        return response()->json([
            'errors' => [
                "message" => 'Photo not found!'
            ],
        ], 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function albums($slug = null)
    {
        $id = '';
        if (!is_null($slug)) {
            $category =  ServiceCategory::where('slug', $slug)->orderBy('created_at', 'desc')->first();
        } else {
            $category =  ServiceCategory::orderBy('created_at', 'desc')->first();
        }
        if ($category) {
             $ablums =  Album::with('galleries')->where('category_id', $category->id)->orderBy('created_at', 'desc')->get();
            if (count($ablums) > 0) {
                return response()->json([
                    'success' => true,
                    'albums' => AlbumResource::collection($ablums),
                     'category_name' => $category->cate_name,
                ], 200);
            }
        }

        return response()->json([
            'errors' => [
                "message" => 'Album not found in this category'
            ],
        ], 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Categories()
    {
        $categories =  ServiceCategory::orderBy('created_at', 'asc')->get();
        if (count($categories) > 0) {
            return response()->json([
                'success' => true,
                'categories' => CategoryResource::collection($categories),
            ], 200);
        }
        return response()->json([
            'success' => true,
            'categories' => [],
        ], 404);
    }

    /**
     * Display data filter by category
     */

    public function filterByCategory($slug)
    {
      $category =  ServiceCategory::where('slug', $slug)->first();
         $ablums =  Album::with('galleries')->where('category_id', $category->id)->orderBy('created_at', 'desc')->get();
        if (count($ablums) > 0) {
            if (count($ablums) > 0) {
                return response()->json([
                    'success' => true,
                    'albums' => AlbumResource::collection($ablums),
                    'category_name' => $category->cate_name,
                ], 200);
            }
        }
        return response()->json([
            'errors' => [
                "message" => 'Album not found in this category'
            ],
        ], 404);
    }
    /**
     * Display data sort by
     */

    public function sortBy($slug, $cate_slug)
    {
        $id =  Album::where('slug', $cate_slug)->first()->id;
        if ($slug == 'most-recent') {
            $galleries =  Gallery::where('album_id', $id)->orderBy('created_at', 'asc')->get();
        } elseif ($slug == 'most-popular') {
            $galleries =  Gallery::withCount('likes')->where('album_id', $id)->orderBy('likes_count', 'desc')->get();
        } elseif ($slug == 'most-commented') {
           $galleries =  Gallery::withCount('comments')->where('album_id', $id)->orderBy('comments_count', 'desc')->get();
        } elseif ($slug == 'random') {
            $galleries =  Gallery::where('album_id', $id)->InRandomOrder()->get();
        }
        return response()->json([
            'success' => true,
            'galleries' => GalleryResource::collection($galleries),
        ], 200);
    }
    /**
     * Display data Gallery single data
     */

    public function Gallery($slug, $album_slug)
    {
        $alumb_id = Album::where('slug',  $album_slug)->first()->id;
        $gallery =  Gallery::with('comments','likes')->where('album_id', $alumb_id)->where('slug', $slug)->first();

        if ($gallery) {
            return response()->json([
                'success' => true,
                'gallery' => new GallerySingleResource($gallery, $alumb_id),
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 404);
    }
    /**
     * Suggest gallery
     */

    public function SuggestGalleries($slug)
    {
        $category =  Gallery::where('slug', $slug)->first();
        if ($category) {
            $gallery = Gallery::whereNotIn('slug', [$slug])->where('category_id', $category->category_id)->inRandomOrder()->take(6)->get();
            if (count($gallery) > 0) {
                return response()->json([
                    'success' => true,
                    'suggestGalleries' => GalleryResource::collection($gallery),
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'suggestGalleries' => []
        ], 200);
    }
    /**
     *  coding for share count
     */

    public function ShareCount(Request $request)
    {

        $share = ShareCount::where('gallery_id', $request->gallery_id)->first();
        if ($share) {
            ShareCount::where('gallery_id', $request->gallery_id)->increment('share_count', $share->share_count);
        } else {
            $shareCount = new ShareCount;
            $shareCount->share_count  = 1;
            $shareCount->gallery_id = $request->gallery_id;
            $shareCount->save();
        }
        $count =    ShareCount::where('gallery_id', $request->gallery_id)->pluck('share_count');
        return response()->json([
            'success' => false,
            'share_counts' => $count[0]
        ], 200);
    }
    /**
     *  Delete comment
     */

    public function deleteComment(Request $request)
    {
        $comment = Comment::where('id', $request->id)->first();
        if ($comment) {
            $activity = Activity::where('comment_id', $comment->id)->first();
            if($activity) {
                $activity->delete();
            }
            $comment->delete();
            return response()->json([
                'success' => true,
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 200);
    }
}
