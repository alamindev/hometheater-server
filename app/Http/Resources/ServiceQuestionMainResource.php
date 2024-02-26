<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ServiceQuestionMainResource extends JsonResource
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
            "id" => Str::random(),
            'title' => $this['title'],
            'service_id' => $this['service_id'],
            'questions' => ServiceQuestionResource::collection($this['questions']),
        ];
    }
}