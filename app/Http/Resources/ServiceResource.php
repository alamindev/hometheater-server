<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            "title" => $this->title,
            "icon" => $this->icon,
            "type" => $this->type,
            "svg" => $this->svg,
            "thumbnail" => $this->thumbnail,
            "slug" => $this->slug,
            "price" => formatPrice($this->basic_price),
            "image" => count($this->serviceImage) > 0 ? $this->serviceImage[0]->image : null,
            'review_count' => collect($this->reviews)->count(),
            'rating' => collect($this->reviews)->count() > 0 ? round(collect($this->reviews)->avg('rating'), 1) : ''
        ];
    }
}
