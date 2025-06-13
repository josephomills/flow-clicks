<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPackage extends Model
{
    use HasFactory;
    
    /**
     * These fields on the link table are open to receive data 
     */
    protected $fillable = [
        'name',
        'description',

        'monthly_price',
        'annual_price',
        'lifetime_price',

        'max_links',
        'max_clicks_per_month',

        'link_expiration_days',

        'custom_domains_allowed',
        'custom_domains_limit',
        
        'utm_parameters_allowed',
        'password_protection_allowed',
        'api_access',
        'analytics_dashboard',
        'priority_support',
        'is_featured',
        'is_active',
    ];
}
