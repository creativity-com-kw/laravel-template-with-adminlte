<?php

use Illuminate\Database\Seeder;

class CoachApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CoachApplication::class)->state('pending')->create();
        factory(App\CoachApplication::class)->state('rejected')->create();
    }
}
