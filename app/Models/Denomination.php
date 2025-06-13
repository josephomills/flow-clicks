<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    /** @use HasFactory<\Database\Factories\DenominationFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'population','city', 'country', 'zone_id' ];
    public function clicks()
    {
        return $this->hasMany(LinkClick::class);
    }

    public function users()
    {
        return $this->hasMany(User::class,  'denomination_user');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

   public function youtube_clicks()
{
    return $this->hasMany(LinkClick::class)->whereHas('link_type', function ($query) {
        $query->where('name', 'youtube');
    });
}
   public function facebook_clicks()
{
    return $this->hasMany(LinkClick::class)->whereHas('link_type', function ($query) {
        $query->where('name', 'facebook');
    });
}

}
