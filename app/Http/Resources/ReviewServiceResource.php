<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewServiceResource extends JsonResource
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
            "id" => $this->id,
            "user" => new ReviewUserResource($this->whenLoaded('user')),
            "rating" => $this->rating,
            "text" => $this->details,
            "date" => Carbon::parse($this->created_at)->diffForHumans(),
            "images" => $this->review_images
        ];
    }
}