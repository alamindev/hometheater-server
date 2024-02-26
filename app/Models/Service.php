<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function serviceInclude()
    {
        return $this->hasMany('App\Models\ServiceInclude');
    }
     public function serviceQuestion()
    {
        return $this->hasMany('App\Models\ServiceQuestion');
    }

     public function serviceImage()
    {
        return $this->hasMany('App\Models\ServiceImage');
    }
     public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }


}