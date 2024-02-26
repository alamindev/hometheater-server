<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ActivityResource extends JsonResource
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
            'type' => $this->type,
            'text' => $this->text,
            'link' => $this->link,
            'date' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'photo' => $this->user->photo != null ? $this->user->photo : 'uploads/users/no-image.png',
            'username' => Str::ucfirst($this->user->first_name) . ' ' . $this->user->last_name
        ];
    }
}