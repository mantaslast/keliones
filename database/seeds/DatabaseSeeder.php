<?php

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
        $this->call(CategorySeeder::class);

        factory(App\User::class, 10)->create();

        factory(App\Offer::class, 20)->create();
        factory(App\Rating::class, 20)->create();
    }
}
