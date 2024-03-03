<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        $colors = explode('||#||', $this->color);
        array_pop($colors);
        $newColor = [];
        foreach($colors as $color){
            $c = explode('||*||', $color);  
            array_push($newColor, $c);
        } 
        $discount = 0;
        if($this->discount_price){
            $discount =   round($this->basic_price - $this->basic_price * ($this->discount_price / 100), 2);
        }
        return [
            "id" => $this->id,
            "title" => $this->title,
            "icon" => $this->icon,
            "slug" => $this->slug,
            "type" => $this->type,
            "code" => $this->service_type,
            "price" => $this->basic_price,
            "discount" => $this->discount_price,
            "discount_price" => $discount,
            "conditions" => $this->conditions,
            "delivery_time" => $this->delivery_time,
            "colors" =>  $newColor,
            "duration" => $this->duration,
            "details" => $this->details,
            "seo_details" => $this->seo_details,
            "keyword" => $this->keyword,
            "images" => ServiceImageResource::collection($this->whenLoaded('serviceImage')),
            "image" => count($this->serviceImage) > 0 ? $this->serviceImage[0]->image : null,
            'service_includes' => $this->extractData($this->datas),
            'review_count' => collect($this->reviews)->count(),
            'rating' => collect($this->reviews)->count() > 0 ? round(collect($this->reviews)->avg('rating'), 1) : ''
        ];
    }
    public function extractData($string)
    {
        $service_includes = explode('||#||', $string);
        array_pop($service_includes);
        return collect($service_includes);
    }
}
