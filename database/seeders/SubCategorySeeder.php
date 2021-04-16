<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('sub_categories')->truncate();

        $rows = array(
            array('uuid' => \Str::uuid(), 'cat_id' => '1', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
            array('uuid' => \Str::uuid(), 'cat_id' => '3', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
        );

        \DB::table('sub_categories')->insert($rows);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
