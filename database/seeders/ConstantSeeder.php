<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConstantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('constants')->truncate();

		$constants = array(
			array('id' => '1','uuid' => null, 'name' => 'test','value' => 'test','type' => null,'image_path' => null,'status' => '1'),
		);

		\DB::table('constants')->insert($constants);
		\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
