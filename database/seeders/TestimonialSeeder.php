<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name'=>'Dr. Amani Juma','role'=>'Director','company'=>'Zanzibar Tourism Board','message'=>'Ostex transformed our online presence completely. The tourism portal they built has increased our visitor inquiries by 300%. Professional, responsive, and highly skilled team.','rating'=>5,'is_approved'=>true,'is_featured'=>true],
            ['name'=>'Mohammed Al-Barwani','role'=>'CEO','company'=>'Zuri Retail Ltd','message'=>'The e-commerce platform Ostex built for us is exceptional. Sales have doubled since launch, and the admin panel makes managing our catalog effortless.','rating'=>5,'is_approved'=>true,'is_featured'=>true],
            ['name'=>'Fatma Rashid','role'=>'Head of IT','company'=>'Mnazi Mmoja Hospital','message'=>'Implementing the hospital management system was seamless. Ostex understood our complex requirements and delivered a solution that our staff loves using.','rating'=>5,'is_approved'=>true,'is_featured'=>true],
            ['name'=>'Ibrahim Khalid','role'=>'Principal','company'=>'Al-Noor Schools','message'=>'The school management system has eliminated so much paperwork. Parents appreciate the transparency, and our staff saves hours every week.','rating'=>5,'is_approved'=>true,'is_featured'=>true],
            ['name'=>'Zuwena Omar','role'=>'Chairperson','company'=>'Zanzibar Fishermen\'s Cooperative','message'=>'The analytics dashboard gives us real insights into our operations. We can now make data-driven decisions that have improved our efficiency by 40%.','rating'=>4,'is_approved'=>true,'is_featured'=>false],
            ['name'=>'Hassan Makame','role'=>'Manager','company'=>'Zanzibar Hospitality Group','message'=>'Our booking system has streamlined reservations completely. Integration with our existing systems was smooth, and customer satisfaction has noticeably improved.','rating'=>5,'is_approved'=>true,'is_featured'=>false],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name'], 'company' => $t['company']],
                array_merge($t, ['sort_order' => $i])
            );
        }
    }
}
