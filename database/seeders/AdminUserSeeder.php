<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = New User();

        $user->name = 'Super Admin';
        $user->email = 'superadmin@sellx';
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->phone_verified_at = \Carbon\Carbon::now();
        $user->password = bcrypt('superadmin');
        $user->is_social = 0;

        $user->save();

        $user = New User();

        $user->name = 'Super Admin';
        $user->email = 'admin@sellx';
        $user->email_verified_at = \Carbon\Carbon::now();
        $user->phone_verified_at = \Carbon\Carbon::now();
        $user->password = bcrypt('admin');
        $user->is_social = 0;

        $user->save();          
    }
}
