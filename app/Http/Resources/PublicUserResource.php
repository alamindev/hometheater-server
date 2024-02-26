<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicUserResource extends JsonResource
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
            'photo' => $this->photo != null ? $this->photo : 'uploads/avater.svg',
            'username' => $this->first_name . ' ' . $this->last_name,
            'nickname' => '@' . $this->first_name . '' . $this->last_name,
            'location' =>  $this->city . ',' . $this->state,
            'bio' => $this->bio,
            'comments' => $this->comments->count(),
            'likes' => $this->likes->count(),
            'reviews' => $this->reviews->count(),
            'facebook' => $this->social && $this->social->facebook ? $this->social->facebook : '#',
            'twitter' => $this->social && $this->social->twitter ? $this->social->twitter : '#',
            'messenger' => $this->social && $this->social->messenger ? $this->social->messenger : '#',
            'instagram' => $this->social && $this->social->instagram ? $this->social->instagram : '#',
        ];
    }
}