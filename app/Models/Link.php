<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * These fields on the link table are open to receive data 
     */
    protected $fillable = [
        'user_id',
        'original_url',
        'short_url',
        'title',
        'description',
        'link_group_id',
        'link_type_id',
        'expires_at',
        'clicks',
        'denomination_id',
    ];

    /**
     * The user account that the link belongs to
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link_type()
    {
        return $this->belongsTo(LinkType::class);
    }
    public function link_group()
    {
        return $this->belongsTo(LinkGroup::class);
    }
    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }
}
