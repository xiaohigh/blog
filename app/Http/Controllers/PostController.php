<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use Config;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class PostController extends Controller
{
    /**
     * 添加页面显示
     */
    public function getAdd()
    {
        //获取分类信息
        $cate = new CateController;
        $cates = $cate->getCates();

        //显示模版
        return view('post.add', [
            'cates'=>$cates,
            'tags'=>TagController::getTags(),
            'token'=> PublicController::getQiniuImgToken()
            ]);
    }

    /**
     * 文章添加操作
     */
    public function postInsert(Request $request)
    {
        //创建模型
        $post = new Post;
        //声明成员属性
        $post->title = $request->title;
        $post->cate_id = $request->cate_id;
        $post->content = $request->content;
        $post->author = $request->session()->get('uid');
        $post->pic = $request->pic;

        //添加操作
        if($post->save()) {
            //插入中间表
            //拼接数组
            if($request->tag_id) {
                //遍历数组拼接数据
                $data = [];
                foreach ($request->tag_id as $key => $value) {
                    $t['post_id'] = $post->id;
                    $t['tag_id'] = $value;
                    $data[] = $t;
                }
                //
                DB::table('post_tag')->insert($data);
            }

            return redirect('admin/post/index')->with('success', '添加成功');
        }else{
            return back()->with('error','添加失败');
        }
    }


    /**
     * 文章列表显示
     */
    public function getIndex(Request $request)
    {
        //获取分类信息
        $cate = new CateController;
        $cates = $cate->getCates();

        //创建模型
        $posts = Post::orderBy('id','desc')
            ->where(function($query) use($request){
                //检测关键字
                $k = $request->input('keywords');
                $cate = $request->input('cate_id');
                //如果不为空
                if(!empty($k)) {
                    $query->where('title','like','%'.$k.'%');
                }    
                if(!empty($cate)) {
                    $query->where('cate_id',$cate);
                }
            })
            ->select('posts.*','cates.name as names')
            ->join('cates','cates.id','=','posts.cate_id')
            ->paginate($request->input('num', 10));
        //显示模版并分配变量
        return view('post.index', [
            'posts'=>$posts, 
            'request'=> $request,
            'cates'=>$cates
            ]);
    }

    /**
     * 文章的修改
     */
    public function getEdit($id)
    {
        //获取当前文章的内容
        $info = Post::find($id);
        //获取分类信息
        $cates = (new CateController)->getCates();
        //解析模版
        return view('post.edit', ['cates'=>$cates, 'info'=>$info, 'token'=>PublicController::getQiniuImgToken()]);
    }

    /**
     * 文章的更新
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $post = Post::find($request->input('id'));
        //声明成员属性
        $post->title = $request->title;
        $post->cate_id = $request->cate_id;
        $post->content = $request->content;
        $post->pic = $request->pic;

        //添加操作
        if($post->save()) {
            return redirect('admin/post/index')->with('success', '更新成功');
        }else{
            return back()->with('error','更新失败');
        }
    }

    /**
     * 文章的更新
     */
    public function getDelete($id)
    {
         if(Post::where('id', $id)->delete()){
             return back()->with('success','删除成功');
         }else{
             return back()->with('error','删除失败');
         }
    }

}
