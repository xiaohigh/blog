<?php

use Illuminate\Database\Seeder;

class Comment extends Seeder
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
        for($i = 0;$i < 50; $i++) {
            $data[] = [
                'post_id' => rand(1,10),
                'content' => str_random(100),
                'pid' => 0,
                'user_id'=>rand(1,5)
            ];
        }
        //执行插入
        DB::table('comments')->insert($data);
    }
}
