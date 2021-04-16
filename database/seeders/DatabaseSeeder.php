<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CitySeeder::class,
            ConstantSeeder::class,
            CategorySeeder::class,
            CountriesSeeder::class,
            CurrenciesSeeder::class,
            LanguagesSeeder::class,

            subCategorySeeder::class,
            SubCategoryLevelThreeSeeder::class,
        ]);
    }
}
