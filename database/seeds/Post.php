<?php

use Illuminate\Database\Seeder;

class Post extends Seeder
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
        for($i=0;$i<50;$i++){
            $data[] = [
                    'title'=>str_random(10),
                    'content'=>str_random(100),
                    'info'=>str_random(20),
                    'cate_id' => rand(1,5),
                    'author'=> rand(1,5),
                    'status'=>1
                    ];
        }
        DB::table('posts')
                ->insert($data);
    }
}
