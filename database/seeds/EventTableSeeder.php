<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Event::class)->create([
            'name' => 'Spinning Cycle Event',
        ])->eventSchedule()->save(factory(App\EventSchedule::class)->create([
            'coach_id' => User::select('id')->whereType(2)->whereCoachType(1)->first(),
            'start_date' => Carbon::now()->addDay()->format('Y-m-d') . ' 19:00:00',
            'end_date' => Carbon::now()->addDay()->format('Y-m-d') . ' 20:00:00',
            'weekday' => Carbon::now()->addDay()->format('w')
        ]));
    }
}
