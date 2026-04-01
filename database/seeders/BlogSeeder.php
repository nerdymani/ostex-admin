<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            ['title'=>'The Future of Tech in Zanzibar','excerpt'=>'How digital transformation is reshaping business in Zanzibar and across Tanzania.','body'=>'<p>Zanzibar is experiencing a technology revolution. With increasing internet penetration and mobile adoption, businesses are embracing digital tools to reach customers and streamline operations.</p><p>At Ostex, we are at the forefront of this transformation, helping local businesses leverage technology to compete globally.</p>','category'=>'Technology','status'=>'published','is_featured'=>true,'published_at'=>now()->subDays(5),'author_name'=>'Amina Hassan'],
            ['title'=>'Why Your Business Needs a Mobile App in 2025','excerpt'=>'Mobile apps are no longer optional — they\'re essential for businesses that want to stay competitive.','body'=>'<p>With over 80% of internet users accessing the web via mobile devices, having a mobile app is critical for business success. In this article, we explore the top reasons why your business needs a mobile app.</p>','category'=>'Mobile','status'=>'published','is_featured'=>true,'published_at'=>now()->subDays(10),'author_name'=>'Ali Mohammed'],
            ['title'=>'Cloud Computing: A Guide for Small Businesses','excerpt'=>'Understanding cloud solutions and how they can save your business money while improving efficiency.','body'=>'<p>Cloud computing offers small businesses enterprise-grade tools at affordable prices. This guide explains the different types of cloud services and how to choose the right one for your needs.</p>','category'=>'Cloud','status'=>'published','is_featured'=>true,'published_at'=>now()->subDays(15),'author_name'=>'Hassan Mwinyi'],
            ['title'=>'Top 5 Cybersecurity Threats in 2025','excerpt'=>'Stay protected from the latest digital threats targeting businesses in East Africa.','body'=>'<p>Cybercrime is on the rise across East Africa. From phishing attacks to ransomware, businesses of all sizes are at risk. Here are the top 5 threats you need to know about.</p>','category'=>'Security','status'=>'published','is_featured'=>false,'published_at'=>now()->subDays(20),'author_name'=>'Juma Salim'],
            ['title'=>'How UI/UX Design Impacts Your Revenue','excerpt'=>'Good design is not just beautiful — it directly drives business results.','body'=>'<p>Studies show that every $1 invested in UX design returns $100. Discover how thoughtful design choices can increase conversions and customer satisfaction.</p>','category'=>'Design','status'=>'published','is_featured'=>false,'published_at'=>now()->subDays(25),'author_name'=>'Fatuma Omar'],
            ['title'=>'Data Analytics for Growing Businesses','excerpt'=>'How to use data to make better decisions and accelerate your growth.','body'=>'<p>Data is the new oil. But many businesses are sitting on vast amounts of data without extracting any value from it. This post explains how to get started with data analytics.</p>','category'=>'Analytics','status'=>'draft','author_name'=>'Amina Hassan'],
            ['title'=>'Building a Digital Marketing Strategy That Works','excerpt'=>'Step-by-step guide to creating a digital marketing plan for your business.','body'=>'<p>Digital marketing doesn\'t have to be complicated. In this guide, we break down the key components of a successful digital marketing strategy.</p>','category'=>'Marketing','status'=>'draft','author_name'=>'Zainab Khalid'],
        ];

        foreach ($posts as $i => $post) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                array_merge($post, ['slug' => Str::slug($post['title'])])
            );
        }
    }
}
