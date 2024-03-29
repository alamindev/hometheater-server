<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function socials()
    {
        return $this->hasMany(SocialUser::class, 'user_id', 'id');
    }

    public function hasSocialLinked($service)
    {
        return (bool) $this->socials->where('service', $service)->count();
    }


    public function comments()
    {

        return $this->hasMany(Comment::class);
    }
    public function likes()
    {

        return $this->hasMany(Like::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function social()
    {
        return $this->hasOne(SocialLink::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
