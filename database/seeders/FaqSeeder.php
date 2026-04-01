<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question'=>'How long does it take to build a website?','answer'=>'Depending on complexity, a standard website takes 4-8 weeks. Simple landing pages can be done in 1-2 weeks, while complex web applications may take 3-6 months.','category'=>'General','sort_order'=>0],
            ['question'=>'What technologies do you use?','answer'=>'We work with modern technologies including Laravel, React, Vue.js, Flutter, React Native, and cloud platforms like AWS and Google Cloud. We choose the best technology for each project.','category'=>'Technical','sort_order'=>1],
            ['question'=>'Do you provide ongoing support?','answer'=>'Yes! We offer maintenance and support packages to keep your application secure and up-to-date. Our support team is available Monday-Friday during business hours.','category'=>'Support','sort_order'=>2],
            ['question'=>'Can you work with our existing systems?','answer'=>'Absolutely. We specialize in integrations and can connect our solutions to your existing CRM, ERP, payment systems, or any third-party service with an API.','category'=>'Technical','sort_order'=>3],
            ['question'=>'How much does a mobile app cost?','answer'=>'Mobile app costs vary based on features, platforms, and complexity. A basic app starts from $5,000, while feature-rich apps can range from $15,000-$50,000+. We provide detailed quotes after understanding your requirements.','category'=>'Pricing','sort_order'=>4],
            ['question'=>'Do you offer payment plans?','answer'=>'Yes, we offer flexible payment structures. Typically we require 40% upfront, 30% at midpoint, and 30% upon completion. We can discuss custom arrangements for larger projects.','category'=>'Pricing','sort_order'=>5],
            ['question'=>'Is my data secure with you?','answer'=>'Data security is our top priority. We follow industry best practices including encryption, secure coding standards, regular backups, and compliance with relevant data protection regulations.','category'=>'Security','sort_order'=>6],
            ['question'=>'Do you work with international clients?','answer'=>'Yes! While we are based in Zanzibar, we work with clients across East Africa and internationally. We use remote collaboration tools and accommodate different time zones.','category'=>'General','sort_order'=>7],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_active' => true])
            );
        }
    }
}
