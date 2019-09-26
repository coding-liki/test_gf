<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $available_days = [
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
            'Воскресенье'
        ];
        for ($i = 0; $i < 10; $i++) {
            $days = [];

            foreach ($available_days as $day) {
                if (rand(0, 2) == 1) {
                    $days[] = $day;
                }
            }
            DB::table('tariffs')->insert([
            'name' => "Тариф (".Str::random(10).")",
            'price' => rand(1000, 3000),
            'days' => json_encode($days)
        ]);
        }
    }
}
