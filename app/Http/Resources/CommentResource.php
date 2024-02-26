<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\UserResource;
class CommentResource extends JsonResource
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
            'comment' => $this->comment,  
            'date' => Carbon::parse($this->created_at)->diffForHumans(),  
            'user' => new UserResource($this->user)
        ];
    }
}
