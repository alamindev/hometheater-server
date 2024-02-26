<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;
use App\Models\Gallery;

class GallerySingleResource extends JsonResource
{
    public $album_id;
    public function __construct($gallery, $album_id)
    {
         parent::__construct($gallery);
        $this->album_id = $album_id;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'url' => $this->photo,
            'install_date' => $this->install_date,
            'details' => $this->details,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comment_counts' => count($this->comments),
            'like_counts' => count($this->likes->where('liked', true)),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'share_counts' => $this->share_counts ? $this->share_counts->share_count : '',
            'previous_slug' =>  $this->previousData($this->id),
            'next_slug' => $this->nextData($this->id),
            'album_name' => $this->album->name
        ];
    }

    public function previousData($id){
        $previous = Gallery::where('id' , '<', $id)->where('album_id', $this->album_id)->orderby('id','desc')->first();
        if($previous == null){
            return Gallery::where('album_id', $this->album_id)->orderby('id','desc')->first()->slug;
        }
        return $previous->slug;
    }
    public function nextData($id){
        $next =  Gallery::where('id' , '>', $id)->where('album_id', $this->album_id)->orderby('id','asc')->first();
         if($next == null){
            return Gallery::where('album_id', $this->album_id)->orderby('id','asc')->first()->slug;
        }
        return $next->slug;
    }
}
