<?php

use Illuminate\Database\Seeder;

class PostViews extends Seeder
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
                'post_id' => $i+1,
                'views' => rand(1,100)
            ];
        }
        //执行插入
        DB::table('post_views')->insert($data);
    }
}
