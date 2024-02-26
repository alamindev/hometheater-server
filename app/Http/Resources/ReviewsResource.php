<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            "id" => $this->id,
            'rating' => $this->rating,
            'title' => $this->service ? Str::words($this->service->title, 5) : '',
            'details' => $this->service ? strip_tags(Str::words($this->service->details, 12)) : '',
            'order_id_show' => $this->order ? $this->order->order_id : '',
            'order_id' => $this->order ? $this->order->id : '',
            'date' => Carbon::parse($this->created_at)->format('m/d/Y'),
        ];
    }
}