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

class UserController extends Controller
{
    
    /**
     * 用户的添加页面显示
     */
    public function getAdd()
    {
        return view('user.add', ['roles'=>RoleController::getRoles()]);
    }

    /**
     * 用户的添加操作
     */
    public function postInsert(InsertPostRequest $request)
    {
        //创建模型
        $user = new User;
        //设置
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');
        $user->remember_token = str_random(50);
        //检测文件上传
        if($request->hasFile('profile')) {
            $user -> profile = $this->uploadProfile($request);
        }
        //插入数据库
        if($user->save()) {
            //设置角色
            $user->roles()->attach($request->input('role_id'));
            //跳转到用户的列表页
            return redirect('admin/user/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回用户的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 图片上传操作
     */
    private function uploadProfile($request)
    {
        //获取文件名称
        $name = md5(time().rand(0,100000)).'.'.$request->file('profile')->getClientOriginalExtension();
        $request->file('profile')->move(Config::get('app.uploadDir'), $name);
        //设置属性 
        return trim( Config::get('app.uploadDir'),'.' ).$name;
    }

    /**
     * 用户的列表操作
     */
    public function getIndex(Request $request)
    {
        //创建模型
        $user = new User;
        //获取每页显示的数据
        $data['num'] = $request->input('num', 10);
        $data['keywords'] = $request->input('keywords');
        //读取数据
        $users = $user->orderBy('id','desc')->where(function($query){
            //获取关键字
            $keywords = Request::capture()->input('keywords');
            //如果存在关键字
            if($keywords){
                $query->where('name','like','%'.$keywords.'%');
            }
        })->paginate($data['num']);
        //分配数据并且进行模版显示
        return view('user.index', ['users'=>$users,'data'=>$data]);
    }

    /**
     * 用户的修改显示
     */
    public function getEdit($id)
    {
        return view('user.edit', ['info'=>User::find($id)]);
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
        if(User::where('id', $id)->delete()) {
            return back()->with('success','删除成功');            
        }else{
            return back()->with('error','删除失败');            
        }
    }

}
