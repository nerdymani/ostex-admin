<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['label'=>'Projects Completed','value'=>'150+','icon'=>'briefcase','description'=>'Successful projects delivered','sort_order'=>0],
            ['label'=>'Happy Clients','value'=>'80+','icon'=>'users','description'=>'Satisfied clients across Tanzania','sort_order'=>1],
            ['label'=>'Years Experience','value'=>'5+','icon'=>'calendar','description'=>'Years in the industry','sort_order'=>2],
            ['label'=>'Team Members','value'=>'20+','icon'=>'user-group','description'=>'Expert professionals','sort_order'=>3],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(
                ['label' => $stat['label']],
                array_merge($stat, ['is_active' => true])
            );
        }
    }
}
