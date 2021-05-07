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
			array('id' => '1','uuid' => \Str::uuid(), 'name' => 'Arts','slug' => 'arts','status' => '1', 'created_at' => date('Y-m-d H:i:s')),
			array('id' => '2','uuid' => \Str::uuid(), 'name' => 'Sneaker','slug' => 'sneaker','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '3','uuid' => \Str::uuid(), 'name' => 'Cars','slug' => 'cars','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '4','uuid' => \Str::uuid(), 'name' => 'Furniture','slug' => 'furniture','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '5','uuid' => \Str::uuid(), 'name' => 'Perfume','slug' => 'perfume','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '6','uuid' => \Str::uuid(), 'name' => 'Antique','slug' => 'antique','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '7','uuid' => \Str::uuid(), 'name' => 'Paintings','slug' => 'paintings','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '8','uuid' => \Str::uuid(), 'name' => 'Watches','slug' => 'watches','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '9','uuid' => \Str::uuid(), 'name' => 'Jewellery','slug' => 'jewellery','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '10','uuid' => \Str::uuid(), 'name' => 'Bike','slug' => 'bike','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '11','uuid' => \Str::uuid(), 'name' => 'Big Vehicle','slug' => 'big_vehicle','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '12','uuid' => \Str::uuid(), 'name' => 'Plate Number','slug' => 'plate_number','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '13','uuid' => \Str::uuid(), 'name' => 'Leatherette','slug' => 'leatherette','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '14','uuid' => \Str::uuid(), 'name' => 'Wallet','slug' => 'wallet','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '15','uuid' => \Str::uuid(), 'name' => 'Bags','slug' => 'bags','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '16','uuid' => \Str::uuid(), 'name' => 'Pens','slug' => 'pens','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '17','uuid' => \Str::uuid(), 'name' => 'Perfume','slug' => 'perfume','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '18','uuid' => \Str::uuid(), 'name' => 'Oud','slug' => 'oud','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '19','uuid' => \Str::uuid(), 'name' => 'Animals','slug' => 'animals','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),
			array('id' => '20','uuid' => \Str::uuid(), 'name' => 'Properties','slug' => 'properties','status' => '1', 'created_at' =>  date('Y-m-d H:i:s')),

		);

		\DB::table('categories')->insert($categories);
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
