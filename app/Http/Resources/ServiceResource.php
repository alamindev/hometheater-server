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
        $discount = 0;
        if($this->discount_price){
            $discount =   round($this->basic_price - $this->basic_price * ($this->discount_price / 100), 2);
        }
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
            'rating' => collect($this->reviews)->count() > 0 ? round(collect($this->reviews)->avg('rating'), 1) : '',
            "discount" => $this->discount_price > 0 ? formatPrice($this->discount_price) : 0,
            "discount_price" => $discount,
        ];
    }
}
