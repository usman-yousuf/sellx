<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('categories')->truncate();

		$categories = array(
			array('id' => '1','uuid' => \Str::uuid(), 'name' => 'Arts','slug' => 'Arts','status' => '1', 'created_at' => date('Y-m-d H:i:s')),
			array('id' => '2','uuid' => \Str::uuid(), 'name' => 'Sneaker','slug' => 'Sneaker','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '3','uuid' => \Str::uuid(), 'name' => 'Cars','slug' => 'Cars','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '4','uuid' => \Str::uuid(), 'name' => 'Furniture','slug' => 'Furniture','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '5','uuid' => \Str::uuid(), 'name' => 'Perfumes','slug' => 'Perfumes','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '6','uuid' => \Str::uuid(), 'name' => 'Antique','slug' => 'Antique','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '7','uuid' => \Str::uuid(), 'name' => 'Paintings','slug' => 'Paintings','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '8','uuid' => \Str::uuid(), 'name' => 'Watches','slug' => 'Watches','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '9','uuid' => \Str::uuid(), 'name' => 'Jewelry','slug' => 'Jewelry','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
		);

		\DB::table('categories')->insert($categories);
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
