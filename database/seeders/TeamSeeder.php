<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name'=>'Amina Hassan','role'=>'Chief Executive Officer','department'=>'Management','bio'=>'Amina leads Ostex with over 10 years of technology and business experience in East Africa.'],
            ['name'=>'Juma Salim','role'=>'Chief Technology Officer','department'=>'Technology','bio'=>'Juma oversees all technical operations and drives innovation at Ostex.'],
            ['name'=>'Fatuma Omar','role'=>'Head of Design','department'=>'Design','bio'=>'Fatuma creates beautiful, user-centered experiences for all Ostex products.'],
            ['name'=>'Ali Mohammed','role'=>'Lead Developer','department'=>'Technology','bio'=>'Ali specializes in full-stack development and leads our engineering team.'],
            ['name'=>'Zainab Khalid','role'=>'Business Development Manager','department'=>'Sales','bio'=>'Zainab builds relationships and grows Ostex\'s client base across Tanzania.'],
            ['name'=>'Hassan Mwinyi','role'=>'IT Infrastructure Lead','department'=>'Technology','bio'=>'Hassan manages cloud infrastructure and ensures 99.9% uptime for all client systems.'],
        ];

        foreach ($members as $i => $member) {
            TeamMember::updateOrCreate(
                ['slug' => Str::slug($member['name'])],
                array_merge($member, ['slug' => Str::slug($member['name']), 'is_active' => true, 'show_on_site' => true, 'sort_order' => $i])
            );
        }
    }
}
