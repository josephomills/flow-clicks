<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    /** @use HasFactory<\Database\Factories\ZoneFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'country'];

    public function denominations()
    {
        return $this->hasMany(Denomination::class);
    }

    public function clicks()
{
    return $this->hasManyThrough(
        LinkClick::class,       // The target model we're accessing
        Denomination::class,    // The intermediate model
        'zone_id',             // Foreign key on denominations table
        'denomination_id',     // Foreign key on link_clicks table
        'id',                  // Local key on zones table
        'id'                  // Local key on denominations table
    );
}

}
