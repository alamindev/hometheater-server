<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'social_id',
        'service'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}