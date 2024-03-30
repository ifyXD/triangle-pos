<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        // DB::table('customers')->insert([
        //     'customer_name' => 'Anonymous',
        //     'customer_email' => 'anonymous@example.com',
        //     'customer_phone' => '123456789',
        //     'city' => 'Blank City',
        //     'country' => 'Blank Country',
        //     'address' => 'Blank Address',
        //     'user_id' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('suppliers')->insert([
        //     'supplier_name' => 'Anonymous',
        //     'supplier_email' => 'anonymous@example.com',
        //     'supplier_phone' => '123456789',
        //     'city' => 'Blank City',
        //     'country' => 'Blank Country',
        //     'address' => 'Blank Address',
        //     'user_id' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
