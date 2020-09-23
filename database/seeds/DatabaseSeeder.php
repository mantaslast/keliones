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
        // $this->call(CategorySeeder::class);

        // factory(App\User::class, 10)->create()->each(function ($user) {
        //     $profile = factory(App\Profile::class)->make();
        //     $user->profile()->save($profile);
        // });

        factory(App\Offer::class, 20)->create();
    }
}
