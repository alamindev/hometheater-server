<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

     public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

   public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

   public function share_counts()
    {
        return $this->hasOne(ShareCount::class);
    }
}
