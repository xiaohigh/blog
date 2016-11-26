<?php

use Illuminate\Database\Seeder;

class User extends Seeder
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
                'name' => str_random(3),
                'email' => str_random(10).'@gmail.com',
                'remember_token' => str_random(50),
                'password' => bcrypt('secret'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        DB::table('users')->insert($data);
    }
}
