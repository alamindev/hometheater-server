<?php

namespace App\Http\Resources;

use App\Models\OrderQuantity;
use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
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
            'status' => $this->status,
            'datetime' => $this->orderdate,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'services' => $this->MainServices($this->whenLoaded('services')->pluck('service_id'), $this->id),
        ];
    }
    public function MainServices($service_ids, $order_id)
    {
        $services = Service::whereIn('id', $service_ids)->select('id', 'title', 'basic_price', 'slug', 'duration')->get();

        $newservices = [];

        foreach ($services as $key => $service) {
            $quantity = OrderQuantity::where('order_id', $order_id)->where('service_id', $service->id)->first();
            $newservices[$key]['id'] = $service->id;
            $newservices[$key]['duration'] = $service->duration * $quantity->quantity;
        }
        return  $newservices;
    }
}