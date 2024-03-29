<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource; 
class GalleryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'slug' => $this->slug,  
            'url' => $this->photo, 
        ];
    }
}
