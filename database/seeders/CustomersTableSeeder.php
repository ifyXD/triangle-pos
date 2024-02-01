<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\People\Database\factories\CustomerFactory;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed only one customer
        DB::table('customers')->insert([
            'customer_name' => 'Anonymous',
            'customer_email' => 'anonymous@example.com',
            'customer_phone' => '123456789',
            'city' => 'Blank City',
            'country' => 'Blank Country',
            'address' => 'Blank Address',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // gamtion ang factory sht to create 4 more customers sht with the same user_id
        CustomerFactory::new()
            ->count(19)
            ->create(['user_id' => 1]);
    }
}
