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
            array('id' => '1', 'uuid' => \Str::uuid(), 'cat_id' => '1', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
            array('id' => '2', 'uuid' => \Str::uuid(), 'cat_id' => '3', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
        );

        \DB::table('sub_categories')->insert($rows);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
