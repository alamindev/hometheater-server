<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareCount extends Model
{
    use HasFactory;
    public function share_counts()
    {
        return $this->hasMany(Gallery::class);
    }
}
