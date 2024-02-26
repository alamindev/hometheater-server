<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ReviewUserResource extends JsonResource
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
            'username' => Str::ucfirst($this->first_name) . ' '. $this->last_name
        ];
    }
}