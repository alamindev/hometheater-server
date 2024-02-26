<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingUserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'city' => $this->city,
            'state' => $this->state,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'is_appointment' => $this->is_appointment === 'sms' ? false : true,
            'is_notification' => $this->is_notification == 1 ? false : true,
            'facebook' => $this->social ? $this->social->facebook : '',
            'twitter' => $this->social ? $this->social->twitter : '',
            'messenger' => $this->social ? $this->social->messenger : '',
            'instagram' => $this->social ? $this->social->instagram : '',
            'photo' => $this->photo != null ? $this->photo : '/uploads/avater.svg',
        ];
    }
}