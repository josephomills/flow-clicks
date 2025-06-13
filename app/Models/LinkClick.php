<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    protected $fillable = [
        'link_id',
        'denomination_id',
        'link_type_id',
        'ip_address',
        'device_type',
        'country_code',
        'platform',
        'browser',

    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    public function link_type(): BelongsTo
    {
        return $this->belongsTo(LinkType::class);
    }

    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }

    public function zone()
{
    return $this->hasOneThrough(
        Zone::class,
        Denomination::class,
        'id', // Foreign key on denominations table
        'id', // Foreign key on zones table
        'denomination_id', // Local key on link_clicks table
        'zone_id' // Local key on denominations table (assuming this exists)
    );
}
}
