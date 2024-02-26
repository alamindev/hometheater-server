<?php

namespace App\Http\Resources;

use App\Models\OrderQuantity;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  $this->MainServices($this->whenLoaded('services')->pluck('service_id'), $this->id);
    }
    public function MainServices($service_ids, $order_id)
    {
        $services =   Service::whereIn('id', $service_ids)->select('id', 'title', 'basic_price', 'slug')->get();

        $newservices = [];

        foreach ($services as $key => $service) {
            $review = Review::with('review_images')->where('order_id', $order_id)->where('service_id', $service->id)->first();
            $newservices[$key]['id'] = $service->id;
            $newservices[$key]['title'] = $service->title;
            $newservices[$key]['is_review'] = !empty($review) ? true : false;
            $newservices[$key]['rating'] = !empty($review) ? $review->rating : '';
            $newservices[$key]['text'] = !empty($review) ? $review->details : '';
            $newservices[$key]['images'] = !empty($review) ? $review->review_images : [];
        }
        return  $newservices;
    }
}