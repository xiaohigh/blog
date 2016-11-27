<?php

namespace App\Http\Controllers;

use Config;
use Hash;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertPostRequest;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use App\Model\Serie;
use App\Model\Video;

class VideoController extends Controller
{
    /**
     * 用户的添加页面显示
     */
    public function getAdd()
    {
        // 构建鉴权对象
        $auth = new Auth(env('QINIU_KEY'), env('QINIU_SECRET'));

        // 要上传的空间
        $bucket = 'videos';

        $pipeline = 'hls-videos';
        $pfop = "avthumb/m3u8/segtime/10/ab/128k/ar/44100/acodec/libfaac/r/30/vb/240k/vcodec/libx264/stripmeta/0/";

        $policy = array(
            'persistentOps' => $pfop,
            'persistentNotifyUrl' => '',
            'persistentPipeline' => $pipeline
        );

        // 生成上传 Token
        $token = $auth->uploadToken($bucket,null,3600,$policy);
        return view('video.add', ['token'=>$token, 'series' => Serie::get()]);
    }

    /**
     * 用户的添加操作
     */
    public function postInsert(Request $request)
    {
        //创建模型
        $video = new Video;
        //设置
        $video->title = $request->input('title');
        $video->url = $request->input('url');
        $video->serie_id = $request->input('serie_id');
        $video->pos = $request->input('pos');


        //插入数据库
        if($video->save()) {
            //设置角色
            //跳转到用户的列表页
            return redirect('admin/serie/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回用户的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 用户的列表操作
     */
    public function getIndex(Request $request)
    {
        //创建模型
        $video = new Video;
        //读取数据
        $videos = $video->orderBy('id','desc')->where(function($query)use($request){
            //如果存在关键字
            $keywords = $request->input('keywords');
            if($keywords){
                $query->where('title','like','%'.$keywords.'%');
            }
        })->paginate($request->input('num', 10));
        //分配数据并且进行模版显示
        return view('video.index', ['videos'=>$videos, 'request'=>$request]);
    }

    /**
     * 用户的修改显示
     */
    public function getEdit($id)
    {
        return view('video.edit', ['info'=>Video::findOrFail($id), 'series'=>Serie::get(), 'token'=>PublicController::getQiniuImgToken()]);
    }

    /**
     * 用户的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $video = Video::findOrFail($request->id);
        //设置
        $video->title = $request->input('title');
        $video->url = $request->input('url');
        $video->serie_id = $request->input('serie_id');
        $video->pos = $request->input('pos');

        //更新成功
        if($video->save()) {
            return redirect('admin/video/index')->with('success','更新成功');
        } else {
            return back()->with('error', '更新失败');
        }
    }

    /**
     * 用户的删除操作
     */
    public function getDelete($id)
    {
        //创建模型
        if(Video::where('id', $id)->delete()) {
            return back()->with('success','删除成功');
        }else{
            return back()->with('error','删除失败');
        }
    }

    /**
     * 视频前台显示
     */
    public function show($id)
    {
        //获取当前分类下的所有视频
        $video = Video::findOrFail($id);
        $videos = Video::where('serie_id', $video->serie_id)->get();
        return view('video.show', ['video'=>$video, 'videos'=>$videos, 'id'=>$id]);
    }

}
