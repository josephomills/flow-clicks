<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /** @use HasFactory<\Database\Factories\InviteFactory> */
    use HasFactory;

    protected $fillable = [
        'email', 'token',
    ];
}
