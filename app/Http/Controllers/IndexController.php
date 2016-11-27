<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Redis;
use App\Http\Requests;
use App\User;
use App\Model\Post;
use Predis\predis;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    

    /**
     * 浏览数自增操作
     */
    private function addViews($id)
    {
        //检索表
        $count = DB::table('post_views')->where('post_id', $id)->count();
        //如果大于0
        if($count > 0){
            DB::table('post_views')->where('post_id', $id)->increment('views');
        } else {
            DB::table('post_views') -> insert([
                'post_id' => $id,
                ]);
        }
    }



    /**
     * 显示页面的头部
     */
    public static function header()
    {
        //获取分类信息
        $cates = CateController::cates();
        //获取请求对象
        $request = Request::capture()->all();
        //解析模版
        return view('layout.header', ['cates'=>$cates,'request'=>$request]);
    }

    public static function slider()
    {

        //获取最新的五篇文章
        $last = \App\Model\Post::orderBy('created_at', 'desc')->limit(5)->get();

        //获得所有的标签
        $tags = \App\Http\Controllers\TagController::getTags();

        return view('layout.slider', [
            'lastest' => $last,
            'tags' => $tags
        ])->render();
    }


   
}
