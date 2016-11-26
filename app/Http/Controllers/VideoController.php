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
        $serie = new Serie;
        //设置
        $serie->title = $request->input('title');
        $serie->profile = $request->input('profile');
        $serie->intro = $request->input('intro');

        //插入数据库
        if($serie->save()) {
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
        $serie = new Serie;
        //读取数据
        $series = $serie->orderBy('id','desc')->where(function($query)use($request){
            //如果存在关键字
            $keywords = $request->input('keywords');
            if($keywords){
                $query->where('name','like','%'.$keywords.'%');
            }
        })->paginate($request->input('num', 10));
        //分配数据并且进行模版显示
        return view('video.index', ['series'=>$series, 'request'=>$request]);
    }

    /**
     * 用户的修改显示
     */
    public function getEdit($id)
    {
        //return view('user.edit', ['info'=>User::find($id)]);
        return '完善中。。。。。';
    }

    /**
     * 用户的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $user = new User;
        //首先读取内容
        $res = $user::find($request->input('id'));
        //设置属性
        $res -> name = $request -> input('name');
        $res -> email = $request -> input('email');
        //检测是否有图片上传
        if($request->hasFile('profile')) {
            $res -> profile = $this->uploadProfile($request);
        }
        //更新成功
        if($res->save()) {
            return redirect('admin/user/index')->with('success','更新成功');
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
        if(Serie::where('id', $id)->delete()) {
            return back()->with('success','删除成功');
        }else{
            return back()->with('error','删除失败');
        }
    }

}
