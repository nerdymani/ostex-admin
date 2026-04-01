<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;
use Illuminate\Support\Str;

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'=>'Basic',
                'slug'=>'basic',
                'price'=>499.00,
                'price_label'=>'$499',
                'billing_cycle'=>'one-time',
                'description'=>'Perfect for small businesses and startups looking to establish their online presence.',
                'features'=>['5-page website','Mobile responsive design','Contact form','Basic SEO setup','1 month support','Hosting guidance'],
                'is_featured'=>false,
                'is_active'=>true,
                'sort_order'=>0,
                'cta_label'=>'Get Started',
            ],
            [
                'name'=>'Professional',
                'slug'=>'professional',
                'price'=>1499.00,
                'price_label'=>'$1,499',
                'billing_cycle'=>'one-time',
                'description'=>'Ideal for growing businesses that need a robust online platform with advanced features.',
                'features'=>['Up to 20 pages','Custom design','CMS integration','E-commerce ready','Advanced SEO','API integrations','3 months support','Performance optimization'],
                'is_featured'=>true,
                'is_active'=>true,
                'sort_order'=>1,
                'cta_label'=>'Most Popular',
            ],
            [
                'name'=>'Enterprise',
                'slug'=>'enterprise',
                'price'=>null,
                'price_label'=>'Custom',
                'billing_cycle'=>'custom',
                'description'=>'Tailored solutions for large organizations with complex requirements.',
                'features'=>['Unlimited pages','Custom development','Enterprise integrations','Dedicated team','Priority support','SLA guarantee','Cloud infrastructure','Training & documentation'],
                'is_featured'=>false,
                'is_active'=>true,
                'sort_order'=>2,
                'cta_label'=>'Contact Us',
            ],
        ];

        foreach ($plans as $plan) {
            PricingPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
