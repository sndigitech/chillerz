<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call(PlacetypeSeeder::class);
        $this->call(ArtisttypeSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MenuitemSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
