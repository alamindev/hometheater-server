<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Carbon\Carbon;
class PostResource extends JsonResource
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
            'details' => strip_tags(Str::words($this->details,20)),
            'photo' => $this->photo != null ? $this->photo : 'uploads/no-image.png',
            'date' => Carbon::parse($this->created_at)->format('d M Y'),
             'likes' => LikeResource::collection($this->whenLoaded('likes')),
        ];
    }
}
