<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'super.admin@test.com',
            'password' => bcrypt('12345678'),
            'is_active' => 1,
            'reg_requirements' => null,
        ]);

        $superAdminRole = Role::where('name', 'Super Admin')->where('guard_name', 'web')->first();

        if (!$superAdminRole) {
            // Role does not exist, create it
            $superAdminRole = Role::create([
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]);
        }

        $user->assignRole($superAdminRole);

        // $user = User::create([
        //     'name' => 'Rico Ni',
        //     'email' => 'ricobregildo@gmail.com',
        //     'password' => bcrypt('rico1234'),
        //     'is_active' => 1,
        //     'reg_requirements' => null,
        // ]);

        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();

        if (!$adminRole) {
            // Role does not exist, create it
            $adminRole = Role::create([
                'name' => 'Admin',
                'guard_name' => 'web',
            ]);
        }

        $user->assignRole($adminRole);
        
    }
}
