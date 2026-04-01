<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key'=>'site_name',       'value'=>'Ostex Global Technologies','type'=>'text',   'group'=>'general','label'=>'Site Name'],
            ['key'=>'site_tagline',    'value'=>'Transforming Zanzibar Through Technology','type'=>'text','group'=>'general','label'=>'Tagline'],
            ['key'=>'site_email',      'value'=>'info@ostexs.com',  'type'=>'text',   'group'=>'contact','label'=>'Contact Email'],
            ['key'=>'site_phone',      'value'=>'+255 000 000 000', 'type'=>'text',   'group'=>'contact','label'=>'Phone'],
            ['key'=>'site_address',    'value'=>'Zanzibar, Tanzania','type'=>'text',  'group'=>'contact','label'=>'Address'],
            ['key'=>'social_facebook', 'value'=>'',   'type'=>'text',   'group'=>'social', 'label'=>'Facebook URL'],
            ['key'=>'social_twitter',  'value'=>'',   'type'=>'text',   'group'=>'social', 'label'=>'Twitter/X URL'],
            ['key'=>'social_linkedin', 'value'=>'',   'type'=>'text',   'group'=>'social', 'label'=>'LinkedIn URL'],
            ['key'=>'social_instagram','value'=>'',   'type'=>'text',   'group'=>'social', 'label'=>'Instagram URL'],
            ['key'=>'site_logo',       'value'=>null, 'type'=>'image',  'group'=>'general','label'=>'Site Logo'],
            ['key'=>'site_favicon',    'value'=>null, 'type'=>'image',  'group'=>'general','label'=>'Favicon'],
            ['key'=>'maintenance_mode','value'=>'0',  'type'=>'boolean','group'=>'general','label'=>'Maintenance Mode'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
