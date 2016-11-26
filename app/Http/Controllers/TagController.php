<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tag;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertTagRequest;

class TagController extends Controller
{
    /**
     * 获取所有的标签
     */
    public static function getTags()
    {
        return Tag::orderBy('created_at','desc')->get();
    }

    /**
     * 标签的添加页面显示
     */
    public function getAdd()
    {
        return view('tag.add');
    }

    /**
     * 标签的添加操作
     */
    public function postInsert(InsertTagRequest $request)
    {
        //创建模型
        $tag = new Tag;
        //设置
        $tag->name = $request->input('name');
        
        //插入数据库
        if($tag->save()) {
            //跳转到标签的列表页
            return redirect('admin/tag/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回标签的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 标签的列表操作
     */
    public function getIndex(Request $request)
    {
        //创建模型
        $tag = new Tag;
        //获取每页显示的数据
        $data['num'] = $request->input('num', 10);
        $data['keywords'] = $request->input('keywords');
        //读取数据
        $tags = $tag->orderBy('id','desc')->where(function($query){
            //获取关键字
            $keywords = Request::capture()->input('keywords');
            //如果存在关键字
            if($keywords){
                $query->where('name','like','%'.$keywords.'%');
            }
        })->paginate($data['num']);
        //分配数据并且进行模版显示
        return view('tag.index', ['tags'=>$tags,'data'=>$data]);
    }

    /**
     * 标签的修改显示
     */
    public function getEdit($id)
    {
        return view('tag.edit', ['info'=>Tag::find($id)]);
    }

    /**
     * 标签的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $tag = new Tag;
        //首先读取内容
        $res = $tag::find($request->input('id'));
        //设置属性
        $res -> name = $request -> input('name');
        //更新成功
        if($res->save()) {
            return redirect('admin/tag/index')->with('success','更新成功');
        } else {
            return back()->with('error', '更新失败');
        }
    }

    /**
     * 标签的删除操作
     */
    public function getDelete($id)
    {
        //创建模型
        if(Tag::where('id', $id)->delete()) {
            return back()->with('success','删除成功');            
        }else{
            return back()->with('error','删除失败');            
        }
    }

    /**
     * ajax添加标签
     */
    public function getAjaxInsert(InsertTagRequest $request)
    {
        //创建模型
        $tag = new Tag;
        $tag->name = trim($request->input('name'));

        //添加
        if($tag->save()) { 
            return response()->json(['code'=>0,'msg'=>'ok','data'=>['id'=>$tag->id]]);
        }else{
            return response()->json(['code'=>101,'msg'=>'error','data'=>[]]);
        }
    }

    /**
     * 通过名称来获取文章的id列表
     */
    public static function getPostIdsByTagName($name)
    {
        //通过名称获取tag id
        $tag = Tag::where('name', $name)->first();
        if(empty($tag)) return;
        //通过id获取文章的id
        $posts = $tag->post()->lists('id')->toArray();
        return $posts;
    }


}
