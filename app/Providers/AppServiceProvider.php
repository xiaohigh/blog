<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        DB::listen(function($sql, $bindings, $time){
            //写入sql
            file_put_contents('.sqls', "[".date('Y-m-d H:i:s')."]".$sql."\r\n", FILE_APPEND);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
