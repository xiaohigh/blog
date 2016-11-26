<?php

use Illuminate\Database\Seeder;

class Cate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for($i = 0;$i < 5; $i++) {
            $data[] = [
                'name' => strtoupper(str_random(1)),
                'pid' => 0,
                'path' => '0',
            ];
        }
        //执行插入
        DB::table('cates')->insert($data);
    }
}
