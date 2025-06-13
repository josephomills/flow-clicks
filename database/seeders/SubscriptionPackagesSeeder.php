<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriptionPackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $packages = [
            [
                'name' => 'free',
                'description' => 'Basic features for casual users',
                'monthly_price' => null,
                'annual_price' => null,
                'max_links' => 50,
                'max_clicks_per_month' => 1000,
                'link_expiration_days' => 20,
                'custom_domains_allowed' => false,
                'custom_domains_limit' => 20, 
                'utm_parameters_allowed' => false,
                'password_protection_allowed' => false,
                'api_access' => false,
                'analytics_dashboard' => false,
                'priority_support' => false,
                'is_featured' => false,
                'is_active' => true,
               
            ],
            [
                'name' => 'basic',
                'description' => 'Essential tools for growing businesses',
                'monthly_price' => 9.99,
                'annual_price' => 99.99, // ~17% discount
                'max_links' => 500,
                'max_clicks_per_month' => 10000,
                'link_expiration_days' => 90,
                'custom_domains_allowed' => false,
                'custom_domains_limit' => 50,
                'utm_parameters_allowed' => true,
                'password_protection_allowed' => true,
                'api_access' => false,
                'analytics_dashboard' => true,
                'priority_support' => false,
                'is_featured' => true,
                'is_active' => true,
               
            ],
            [
                'name' => 'pro',
                'description' => 'Advanced features for professionals',
                'monthly_price' => 29.99,
                'annual_price' => 299.99, // ~17% discount
                'max_links' => 5000,
                'max_clicks_per_month' => 100000,
                'link_expiration_days' => 365,
                'custom_domains_allowed' => true,
                'custom_domains_limit' => 70,
                'utm_parameters_allowed' => true,
                'password_protection_allowed' => true,
                'api_access' => true,
                'analytics_dashboard' => true,
                'priority_support' => true,
                'is_featured' => true,
                'is_active' => true,
              
            ],
            [
                'name' => 'enterprise',
                'description' => 'Custom solutions for large organizations',
                'monthly_price' => 99.99,
                'annual_price' => 999.99, // ~17% discount
                'max_links' => null, // Unlimited
                'max_clicks_per_month' => null, // Unlimited
                'link_expiration_days' => null, // Never expires
                'custom_domains_allowed' => true,
                'custom_domains_limit' => 100, // Unlimited
                'utm_parameters_allowed' => true,
                'password_protection_allowed' => true,
                'api_access' => true,
                'analytics_dashboard' => true,
                'priority_support' => true,
                'is_featured' => false, // Typically enterprise isn't publicly featured
                'is_active' => true,
               
            ]
        ];

        SubscriptionPackage::insert($packages);
    }
}