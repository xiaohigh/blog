<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Hash;
use Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class LoginController extends Controller
{
    /**
     * 前台登录页面显示
     */
    public function login()
    {
        return view('login.login');
    }

    /**
     * 登录操作
     */
    public function logining(Request $request)
    {
        //读取用户名的相关信息
        $info = User::where('email',$request->input('email'))->first();
        //如果结果为空证明用户名不存在
        if(empty($info)) {
            return back()->with('error','用户名不存在')->withInput();
        }
        //获取密码
        $pass = $info->password;
        //检测密码
        if(Hash::check($request->input('password'), $pass)) {
            $this->loginUser($info);
            return redirect('/');
        }else{
            return back()->with('error','登录失败')->withInput();
        }
    }

    /**
     * 注册页面显示
     */
    public function register(Request $request)
    {
        //显示添加页面
        return view('login.register');
    }

    /**
     * 注册用户
     */
    public function regist(RegisterRequest $request)
    {
        //创建用户模型
        $user = new User;
        //设置
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->remember_token = str_random(50);
        //写入数据库
        if($user->save()) {
            //写入登录状态
            $this->loginUser($user);
            //跳转到首页
            return redirect('/');
        }else{
            return back()->withInput();            
        }
    }

    /**
     * 前台用户登录
     */
    private function loginUser(User $user)
    {
        session(['uid'=> $user->id]);
    }

    /**
     * 检测用户是否登录
     */
    private function checkUserLogin(User $user)
    {
        return session($user->id);
    }

    /**
     * 显示找回密码页面
     */
    public function forget(Request $request)
    {
        //显示页面
        if(!$request->input('_token')){
            return view('login.forget');
        } else {
            //获取邮箱地址发送邮件
            $email = $request->input('email');
            //查询数据库
            $res = User::where('email', $email)->first();
            //判断
            if(empty($res)) {
                return back()->with('error','错误');
            }else{
                //  http://b.com/reset?id=1&remember_token=1slfdjlkas190210
                $result = Mail::send('mail.password', ['user'=>$res->toArray()], function($message)use($email){
                    $message -> subject('找回密码');
                    $message -> to($email);
                });

                //判断
                if($result) {
                    return display('发送成功');
                } else {
                    return back()->with('error','发送失败');
                }
            }
        }
    }

    /**
     * 重置
     */
    public function reset(Request $request)
    {
        //获取参数创建模型
        $user = User::find($request->input('id'));
        //检测是否为post请求
        if(!$request->input('_token')) {
            //检测是否一致
            if($user->remember_token == $request->input('remember_token')) {
                return view('login.reset', ['id' => $user->id, 'remember_token'=>$request->input('remember_token')]);
            } 
            abort(403);
        } else {
            if($user->remember_token != $request->input('remember_token')) {
                abort(403);
            } 
            $user -> password = Hash::make($request->input('password')) ; 
            $user -> remember_token = str_random(50);
            if($user->save()) {
                return display('修改成功');
            } else {
                return back()->with('info','修改失败');
            }
        }
    }


}
