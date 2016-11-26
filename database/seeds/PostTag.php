<?php

use Illuminate\Database\Seeder;

class PostTag extends Seeder
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
                'post_id' => rand(1,20),
                'tag_id' => rand(1,20)
            ];
        }
        //执行插入
        DB::table('post_tag')->insert($data);
    }
}
