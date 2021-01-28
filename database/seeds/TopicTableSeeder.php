<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\Client;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 10000; $i++) {
            DB::disableQueryLog();

            $topic =Topic::create([
                'device_id' =>'5',
                'message' =>  'Arduino/cpu/usage',
                'value' => $faker->numberBetween($min = 100, $max = 100),
                'client_id' => 'Arduino1281s',
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Antartica/Vostok')


            ]);
            DB::setEventDispatcher(new Illuminate\Events\Dispatcher());

            error_log("inserted".$topic);
        }
    }
}
