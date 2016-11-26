<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Crypt;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
        return view('admin.index',['user'=>User::find(session('uid'))]);
    }

    /**
     * 后台登录操作
     */
    public function login(Request $request)
    {   
        //如果是get方式 显示页面
        if($request->isMethod('get')){
            //获取cookie
            return view('admin.login');
        }else{
            //如果是post方式 登录网站
            //读取用户名的相关信息
            $info = User::where('name',$request->input('name'))->first();
            //如果结果为空证明用户名不存在
            if(empty($info)) {
                return back()->with('error','用户名不存在');
            }
            //获取密码
            $pass = $info->password;
            //检测密码
            if(Hash::check($request->input('password'), $pass)) {
                //写入session
                $request->session()->put('uid', $info['id']);
                //如果验证成功 并且有记住我的操作 将用户名和密码加密存储在cookie中
                // username:password
                if($request->input('remember_me')) {
                    //加密
                    $auth = Crypt::encrypt($info->name.":".$info->password);
                    //跳转
                    return redirect('admin')
                        ->with('success','登录成功')
                        ->withCookie('auth', $auth, 60*24*30*6);
                }else{
                    return redirect('admin')
                        ->with('success','登录成功');
                }
            }else{
                return back()->with('error','登录失败');
            }
        }
    }

    /**
     * 退出登录操作
     */
    public function logout(Request $request)
    {
        //清空session
        $request->session()->flush();
        //将cookie的auth值清除
        return redirect('admin/login')
                    ->withCookie('auth','',0);
    }

}
