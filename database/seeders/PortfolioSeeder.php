<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioItem;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title'=>'Zanzibar Tourism Portal','description'=>'A comprehensive tourism platform connecting visitors with local experiences.','client'=>'Zanzibar Tourism Board','category'=>'Web Development','technologies'=>['Laravel','Vue.js','MySQL','AWS'],'is_featured'=>true,'completed_at'=>'2024-06-01'],
            ['title'=>'Stone Town Mobile App','description'=>'Mobile guide app for exploring Stone Town\'s historic sites.','client'=>'Stone Town Heritage Trust','category'=>'Mobile Development','technologies'=>['Flutter','Firebase','Google Maps'],'is_featured'=>true,'completed_at'=>'2024-08-15'],
            ['title'=>'Ostex E-Commerce Platform','description'=>'Full-featured e-commerce solution for a leading retail chain.','client'=>'Zuri Retail Ltd','category'=>'Web Development','technologies'=>['Laravel','React','Stripe','Redis'],'is_featured'=>true,'completed_at'=>'2024-09-30'],
            ['title'=>'Hospital Management System','description'=>'Complete hospital management including patient records and billing.','client'=>'Mnazi Mmoja Hospital','category'=>'Enterprise Software','technologies'=>['Laravel','MySQL','Vue.js'],'is_featured'=>true,'completed_at'=>'2024-03-20'],
            ['title'=>'School Management System','description'=>'Comprehensive school ERP covering admissions, fees, and academics.','client'=>'Al-Noor Schools','category'=>'Enterprise Software','technologies'=>['Laravel','React','PostgreSQL'],'is_featured'=>false,'completed_at'=>'2023-12-15'],
            ['title'=>'Fishing Industry Dashboard','description'=>'Real-time analytics dashboard for the fishing cooperative.','client'=>'Zanzibar Fishermen\'s Cooperative','category'=>'Data Analytics','technologies'=>['Python','React','PostgreSQL','D3.js'],'is_featured'=>false,'completed_at'=>'2024-01-10'],
            ['title'=>'Government Document Portal','description'=>'Secure portal for citizens to access and submit government documents online.','client'=>'Zanzibar Government','category'=>'Web Development','technologies'=>['Laravel','MySQL','AWS S3'],'is_featured'=>false,'completed_at'=>'2023-10-05'],
            ['title'=>'Hotel Booking System','description'=>'Custom booking engine integrated with local hotels and guesthouses.','client'=>'Zanzibar Hospitality Group','category'=>'Mobile Development','technologies'=>['Flutter','Laravel API','Stripe'],'is_featured'=>false,'completed_at'=>'2024-04-22'],
        ];

        foreach ($items as $i => $item) {
            PortfolioItem::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                array_merge($item, ['slug' => Str::slug($item['title']), 'is_active' => true, 'sort_order' => $i, 'body' => $item['description']])
            );
        }
    }
}
