<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;
     protected $fillable = ['facebook', 'twitter', 'messenger','instagram','user_id'];   

     public function users()
    {
        return $this->hasMany(User::class);
    }
}
