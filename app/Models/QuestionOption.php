<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;
         public function service_question()
    {
        return $this->belongsTo('App\Models\ServiceQuestion');
    }
}