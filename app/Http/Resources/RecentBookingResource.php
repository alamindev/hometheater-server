<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentBookingResource extends JsonResource
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
            'order_id' => $this->order_id,
            'datetime' => count($this->orderdate) > 0 ? \Carbon\Carbon::parse($this->orderdate[0]['date'])->format('m/d/Y') : '',
            'status' => $this->status,
            'total' => $this->price,
            'service_type' => Service::whereIn('id', $this->services->pluck('service_id'))->pluck('service_type'),
        ];
    }
}