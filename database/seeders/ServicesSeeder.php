<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title'=>'Web Development','short_desc'=>'Custom websites and web applications built with modern technologies.','description'=>'We build responsive, fast, and secure web applications tailored to your business needs. From simple landing pages to complex enterprise systems.','icon'=>'globe-alt','category'=>'Development','is_featured'=>true],
            ['title'=>'Mobile App Development','short_desc'=>'Native and cross-platform mobile apps for iOS and Android.','description'=>'We create intuitive mobile experiences that your users will love. Our team specializes in Flutter, React Native, and native development.','icon'=>'device-phone-mobile','category'=>'Development','is_featured'=>true],
            ['title'=>'IT Consulting','short_desc'=>'Expert technology advice to help your business grow and innovate.','description'=>'Our experienced consultants help you make the right technology decisions. We assess your needs, identify opportunities, and create a roadmap for digital transformation.','icon'=>'light-bulb','category'=>'Consulting','is_featured'=>true],
            ['title'=>'Cloud Solutions','short_desc'=>'Scalable cloud infrastructure and migration services.','description'=>'Move your business to the cloud with confidence. We offer cloud migration, architecture design, and ongoing management for AWS, Azure, and Google Cloud.','icon'=>'cloud','category'=>'Infrastructure','is_featured'=>true],
            ['title'=>'Cybersecurity','short_desc'=>'Protect your business from digital threats and vulnerabilities.','description'=>'Our security experts conduct thorough audits, implement robust defenses, and provide ongoing monitoring to keep your data safe.','icon'=>'shield-check','category'=>'Security','is_featured'=>false],
            ['title'=>'Data Analytics','short_desc'=>'Transform your data into actionable business insights.','description'=>'We help you collect, process, and analyze data to make smarter business decisions. From dashboards to predictive models.','icon'=>'chart-bar','category'=>'Analytics','is_featured'=>false],
            ['title'=>'UI/UX Design','short_desc'=>'Beautiful, user-centered designs that convert and delight.','description'=>'Our design team creates interfaces that are both beautiful and functional. We follow user-centered design principles to ensure your product stands out.','icon'=>'paint-brush','category'=>'Design','is_featured'=>false],
            ['title'=>'Digital Marketing','short_desc'=>'Grow your online presence and reach your target audience.','description'=>'From SEO and social media to paid advertising, we help you connect with customers online and drive measurable results.','icon'=>'megaphone','category'=>'Marketing','is_featured'=>false],
        ];

        foreach ($services as $i => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                array_merge($service, ['slug' => Str::slug($service['title']), 'is_active' => true, 'sort_order' => $i])
            );
        }
    }
}
