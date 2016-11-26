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
     * Display a listing of the resource.
     * 文章详情
     */
    public function show($id)
    {
        //文章浏览数自增
        $this->addViews($id);
        
    	$post = Post::find($id);
    	//获取
    	return view('post.show', ['post'=>$post]);
    }

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
     * 文章列表页
     */
    public function lists(Request $request)
    {
        //获取文章的列表显示
        $posts = Post::orderBy('created_at','desc')
            ->where(function($query)use($request){
                //分类id进行筛选
                if($cid = $request -> input('cid')) {
                    $query->where('cate_id', $cid);
                }
                //关键字筛选
                if($keywords = $request->input('keywords')) {
                    $query->where('title','like','%'.$keywords.'%');
                }
                //标签搜索
                if($tag = $request->input('tag')) {
                    $ids = TagController::getPostIdsByTagName($tag);
                    //获取tag
                    $query->whereIn('id', $ids);
                }
            })
            ->paginate(10);
        //将参数压入到页码中    
        $posts->appends($request->all());
        //解析模版
        return view('index.list', ['posts'=>$posts,'input'=>$request->all()]);
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


   
}
