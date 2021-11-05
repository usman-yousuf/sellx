<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::statement('truncate table users');
        \DB::statement('truncate table profiles');

        // Super Admin
        User::create([
            'uuid'              => \Str::uuid(),
            'email'             => 'superadmin@sellx.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'phone_verified_at' => date('Y-m-d H:i:s'),
            'active_profile_id' => '1',
            'is_social'         => '0',
            'social_type'       => null,
            'social_email'      => null,
            'phone_code'        => null,
            'phone_number'      => null,
            'password'          => bcrypt('admin123'),
            'created_at'        => date('Y-m-d H:i:s'),
            'remember_token'    => '0',
        ]);
 
        Profile::create([
            'uuid'               => \Str::uuid(),
            'first_name'         => 'Sellx',
            'last_name'          => 'Administration',
            'auction_house_name' => 'Administration',
            'username'           => 'superadmin',
            'gender'             => 'male',
            'user_id'            => '1',
            'profile_type'       => 'auctioneer',
            'dob'                => null,
            'created_at'         => date('Y-m-d H:i:s'),
        ]);

        // Admin
        User::create([
            'uuid'              => \Str::uuid(),
            'email'             => 'admin@sellx.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'phone_verified_at' => date('Y-m-d H:i:s'),
            'active_profile_id' => '2',
            'is_social'         => '0',
            'social_type'       => null,
            'social_email'      => null,
            'phone_code'        => null,
            'phone_number'      => null,
            'password'          => bcrypt('admin123'),
            'created_at'        => date('Y-m-d H:i:s'),
            'remember_token'    => '0',
        ]);

        Profile::create([
            'uuid'               => \Str::uuid(),
            'first_name'         => 'Sellx',
            'last_name'          => 'Administration',
            'auction_house_name' => 'Administration',
            'username'           => 'admin',
            'gender'             => 'male',
            'user_id'            => '2',
            'profile_type'       => 'auctioneer',
            'dob'                => null,
            'created_at'         => date('Y-m-d H:i:s'),
        ]);

        $faker = Faker::create();
        foreach (range(3,10) as $index) {
            \DB::table('users')->insert([
                'name' => $faker->name,
                'uuid' => \Str::uuid(),
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'phone_verified_at' => date('Y-m-d H:i:s'),
                'active_profile_id' => $index,
                'is_social'         => '0',
                'social_type'       => null,
                'social_email'      => null,
                'phone_code'        => null,
                'phone_number'      => null,
                'created_at'        => date('Y-m-d H:i:s'),
                'remember_token'    => '0',
                'id' => $index
            ]);            
            \DB::table('profiles')->insert([
                'uuid' => \Str::uuid(),
                'first_name'         => $faker->firstName,
                'last_name'          => $faker->lastName,
                'auction_house_name' => $faker->name,
                'username'           => $faker->userName,
                'gender'             => 'male',
                'user_id'            => $index,
                'profile_type'       => 'auctioneer',
                'dob'                => null,
                'created_at'         => date('Y-m-d H:i:s'),
                'id' => $index
            ]);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');       
    }
}
