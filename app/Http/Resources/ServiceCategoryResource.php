<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource  extends JsonResource
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
            'type' => $this->type,
            'photo' => $this->cate_img,
            'icon' => $this->icon,
            'services' =>  ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
