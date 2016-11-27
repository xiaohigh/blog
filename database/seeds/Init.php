<?php

use Illuminate\Database\Seeder;

class Init extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            'name' => 'init',
            'email' => 'init@gmail.com',
            'remember_token' => str_random(50),
            'password' => bcrypt('secret'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        DB::table('users')->insert($data);

    }
}
