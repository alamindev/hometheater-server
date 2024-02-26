<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceQuestionResource extends JsonResource
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
            'title' => $this->name,
            'service_id' => $this->service_id,
            'option' => QuestionOptionResource::collection($this->whenLoaded('question_option')),
        ];
    }
}