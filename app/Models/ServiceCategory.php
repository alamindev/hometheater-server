<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

     /**
      *
     * Get the services
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
    public function album()
    {
        return $this->hasMany(Album::class, 'category_id');
    }
}
