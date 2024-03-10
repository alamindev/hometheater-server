<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function order_service()
    {
        return $this->hasMany(OrderService::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }
    public function quantity()
    {
        return $this->hasMany(OrderQuantity::class);
    }
    public function varients()
    {
        return $this->hasMany(OrderVarient::class);
    }
    public function prices()
    {
        return $this->hasMany(OrderPrice::class);
    }
    public function services()
    {
        return $this->hasMany(OrderService::class);
    }
    public function questions()
    {
        return $this->hasMany(OrderQuestion::class);
    }
    public function images()
    {
        return $this->hasMany(OrderImage::class);
    }
       public function orderdate()
    {
        return $this->hasMany(OrderDate::class);
    }

}