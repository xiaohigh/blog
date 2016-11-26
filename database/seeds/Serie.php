<?php

use Illuminate\Database\Seeder;

class Serie extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        for($i = 0;$i < 20; $i++) {
            $data[] = [
                'title' => str_random(10),
                'profile' => 'o_1b2geitma1qvd2vqbdm7qi18ct9.png',
                'intro' => str_random(100),
            ];
        }
        //执行插入
        DB::table('series')->insert($data);
    }
}
