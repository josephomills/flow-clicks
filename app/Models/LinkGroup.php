<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkGroup extends Model
{
        protected $fillable = [
            "name",
            "user_id",
            "description",
            "original_url"
            ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function links()
    {
        return $this->hasMany(Link::class);
    }
}
