<?php

use Illuminate\Database\Seeder;

class Video extends Seeder
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
                'title' => str_random(5),
                'm3u8' => 'ABWmQpyMmswTbgCCYn1D7Tc9V3I=/FnHcizNnXYxzKzyxQY3QpCkGk9H2',
                'url' => 'o_1b2hh8glb1cu41e5g12e81sqn1kj79.mp4',
                'serie_id' => rand(1,10),
                'pos' => rand(1,10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        DB::table('videos')->insert($data);
    }
}
