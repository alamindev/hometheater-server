<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->cate_name,
            'image' => $this->cate_img,
            'icon' => $this->icon,
            'slug' => $this->slug,
            'type' => $this->type, 
        ];
    }
}
