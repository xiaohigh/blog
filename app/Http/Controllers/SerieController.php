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

class SerieController extends Controller
{

    /**
     * 用户的添加页面显示
     */
    public function getAdd()
    {
        return view('serie.add', ['token'=>PublicController::getQiniuImgToken()]);
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
        return view('serie.index', ['series'=>$series, 'request'=>$request]);
    }

    /**
     * 用户的修改显示
     */
    public function getEdit($id)
    {
        return view('serie.edit', ['serie'=>Serie::findOrFail($id),'token'=>PublicController::getQiniuImgToken()]);
    }

    /**
     * 用户的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $serie = Serie::findOrFail($request->id);
        //设置
        $serie->title = $request->input('title');
        $serie->profile = $request->input('profile');
        $serie->intro = $request->input('intro');
        if($serie->profile){
            $serie->profile = $request->input('profile');
        }


        //更新成功
        if($serie->save()) {
            return redirect('admin/serie/index')->with('success','更新成功');
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

    /**
     * @param $id 专辑id
     */
    public function show($id)
    {
        //获取专辑信息
        $serie = Serie::findOrFail($id);
        $videos = $serie->video;
        //解析模板
        return view('serie.show', ['serie'=>$serie, 'videos'=>$videos]);
    }

    /**
     * 视频专辑列表显示
     */
    public function lists()
    {
        //获取专辑列表
        $series = Serie::paginate(9);
        return view('serie.lists', ['series'=>$series]);
    }

}
