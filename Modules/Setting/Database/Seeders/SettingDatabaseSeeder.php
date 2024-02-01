<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'company_name' => 'Pub Market',
            'company_email' => 'company@test.com',
            'company_phone' => '012345678901',
            'notification_email' => 'notification@test.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'user_id' => 1,
            'footer_text' => 'Pub Market © 2024 || Developed by <strong><a target="_blank" href="https://www.facebook.com/JosephM.Tanquilan">Joseph</a></strong>',
            'company_address' => 'Tangail, Bangladesh'
        ]);
    }
}
