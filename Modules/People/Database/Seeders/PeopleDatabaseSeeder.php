<?php

namespace Modules\People\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Customer;
use Modules\People\Entities\Supplier;

class PeopleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Customer::factory()->count(15)->create(['user_id' => 1]);
        // Supplier::factory()->count(6)->create(['user_id' => 1]);
    }
}
