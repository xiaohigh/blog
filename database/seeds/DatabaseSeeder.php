<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(User::class);

        $this->call(Post::class);
        
        $this->call(Tag::class);

        $this->call(Cate::class);

        $this->call(Comment::class);
        
        $this->call(PostViews::class);
        
        $this->call(PostTag::class);

        Model::reguard();
    }
}
