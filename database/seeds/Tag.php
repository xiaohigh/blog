<?php

use Illuminate\Database\Seeder;

class Tag extends Seeder
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
        for($i = 0;$i < 30; $i++) {
            $data[] = [
                'name' => str_random(5),
            ];
        }
        //执行插入
        DB::table('tags')->insert($data);
    }
}
