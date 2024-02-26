<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SinglePostResource extends JsonResource
{
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
            'details' =>  $this->details,
            "seo_details" => $this->seo_details,
            "keyword" => $this->keyword,
            'photo' => $this->photo != null ? $this->photo : 'uploads/no-image.png',
            'date' => Carbon::parse($this->created_at)->diffForHumans(),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'category' => $this->category ? $this->category->name : '',
            'user' =>  new UserResource($this->user),
        ];
    }
}