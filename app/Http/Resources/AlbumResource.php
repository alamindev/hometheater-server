<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
            'id' => $this->id,
            'album_name' => $this->name,
            'slug' => $this->slug,
            'image_count' => $this->galleries->count(),
            'images' => AlbumPhotoResource::collection($this->whenLoaded('galleries'))->take(2),
        ];
    }
}
