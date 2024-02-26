<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    use HasFactory;
      public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
     public function question_option()
    {
        return $this->hasMany('App\Models\QuestionOption', 'question_id');
    }

}