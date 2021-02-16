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
			array('id' => '1','uuid' => null, 'name' => 'Arts','slug' => 'Arts','status' => '1'),
			array('id' => '2','uuid' => null, 'name' => 'Sneaker','slug' => 'Sneaker','status' => '1'),
			array('id' => '3','uuid' => null, 'name' => 'Cars','slug' => 'Cars','status' => '1'),
			array('id' => '4','uuid' => null, 'name' => 'Furniture','slug' => 'Furniture','status' => '1'),
			array('id' => '5','uuid' => null, 'name' => 'Perfumes','slug' => 'Perfumes','status' => '1'),
			array('id' => '6','uuid' => null, 'name' => 'Antique','slug' => 'Antique','status' => '1'),
			array('id' => '7','uuid' => null, 'name' => 'Paintings','slug' => 'Paintings','status' => '1'),
			array('id' => '8','uuid' => null, 'name' => 'Watches','slug' => 'Watches','status' => '1'),
			array('id' => '9','uuid' => null, 'name' => 'Jewelry','slug' => 'Jewelry','status' => '1')
		);

		\DB::table('categories')->insert($categories);
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
