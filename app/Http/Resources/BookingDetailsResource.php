<?php

namespace App\Http\Resources;

use App\Models\OrderQuantity;
use App\Models\QuestionOption;
use App\Models\Service;
use App\Models\OrderPrice;
use App\Models\OrderVarient;
use Carbon\Carbon;
use App\Models\ServiceQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingDetailsResource extends JsonResource
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
            'price' => (float)$this->price,
            'sub_total' => (float)$this->sub_total,
            'payment' => $this->payment,
            'discount' => (float)$this->discount,
            'discount_price' => (float)$this->discount_price,
            'addon_price' => (float)$this->addon_price,
            'taxes' => (float)$this->taxes,
            'quantity' => collect($this->quantity)->pluck('quantity')->sum(),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'datetime' => $this->orderdate,
            'delivery_time' => $this->delivery_time,
            'address' => $this->getAddress($this->user),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'services' => $this->MainServices($this->whenLoaded('services')->pluck('service_id'), $this->id),
            'questions' => $this->MainQuestion($this->whenLoaded('questions'), $this->whenLoaded('services')),
            'service_type' => Service::whereIn('id', $this->services->pluck('service_id'))->pluck('service_type'),
        ];
    }
    public function MainServices($service_ids, $order_id)
    {
        $services =   Service::with('serviceImage')->whereIn('id', $service_ids)->select('id', 'service_type', 'title', 'basic_price', 'slug', 'duration')->get();

        $newservices = [];

        foreach ($services as $key => $service) {
            $quantity = OrderQuantity::where('order_id', $order_id)->where('service_id', $service->id)->first();
            $price = OrderPrice::where('order_id', $order_id)->where('service_id', $service->id)->first();
            $varient = OrderVarient::where('order_id', $order_id)->where('service_id', $service->id)->first();
            $newservices[$key]['id'] = $service->id;
            $newservices[$key]['title'] = $service->title;
            $newservices[$key]['image'] = count($service->serviceImage) > 0 ? $service->serviceImage[0]->image : null;
            $newservices[$key]['duration'] = $service->duration;
            $newservices[$key]['slug'] = $service->slug;
            $newservices[$key]['code'] = $service->service_type;
            $newservices[$key]['quantity'] = $quantity ? $quantity->quantity : '';
            $newservices[$key]['total'] = $price ? $price->item_price : ''; 
            $newservices[$key]['varient'] = $varient ? ['name'=> $varient->name, 'value'=> $varient->value] : ''; 
        }
        return  $newservices;
    }
    public function MainQuestion($questions, $services)
    {

        $collection = collect($questions);
        $questions_grouped = $collection->groupBy('service_title');
        $newQuestion = [];
        foreach ($questions_grouped as $key => $que) {
            $newQuestion[$key]['service_title'] = $key;
            foreach ($que as $k => $q) {
                $question = ServiceQuestion::where('id', $q->question_id)->where('service_id', $q->service_id)->first();
                if ($question) {
                    $option = QuestionOption::where('id', $q->option_id)->where('question_id', $question->id)->first();
                    if ($option) {
                        $newQuestion[$key]['question'][$k]['name'] = $question->name;
                        $newQuestion[$key]['question'][$k]['title'] = $option->title;
                        $newQuestion[$key]['question'][$k]['price'] = $option->price;
                    }
                }
            }
        }
        return $newQuestion;
    }
    public function getAddress($user)
    {
        return $user->address . ', ' . $user->city . ', ' . $user->state . ', ' . $user->zipcode . ', USA';
    }
}