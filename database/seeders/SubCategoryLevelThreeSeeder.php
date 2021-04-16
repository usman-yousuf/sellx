<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubCategoryLevelThreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('sub_categories_level_3')->truncate();

        $rows = array(
            array('uuid' => \Str::uuid(), 'sub_cat_id' => '1', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
            array('uuid' => \Str::uuid(), 'sub_cat_id' => '2', 'name' => 'Other', 'slug' => 'other', 'status' => '1', 'created_at' => date('Y-m-d H:i:s')),
        );

        \DB::table('sub_categories_level_3')->insert($rows);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
