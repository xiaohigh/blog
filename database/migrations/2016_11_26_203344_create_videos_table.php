<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('视频的标题');
            $table->string('m3u8') -> comment('视频文件地址')->nullable();
            $table->string('url') -> comment('视频文件地址');
            $table->string('serie_id')->comment('系列id');
            $table->string('pos')->comment('视频的顺序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
