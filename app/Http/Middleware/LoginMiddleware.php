<?php

namespace App\Http\Middleware;

use Closure;
use Crypt;
use DB;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取session
        if(!$request->session()->get('uid') && !$this->checkLoginCookie($request)) {
            return redirect('login')->with('error','您还没有登录');
        }

        return $next($request);
    }

    /**
     * 通过持久cookie来检测用户的权限
     */
    public function checkLoginCookie($request)
    {
        //检测是否有用户的登录cookie 
        $auth = $request->cookie('auth');
        //如果为空 直接返回false
        if(empty($auth)) {
            return false;
        } else {
            //解密  username:password
            $res = explode(':', Crypt::decrypt($auth));
            // 查询数据库
            $res = DB::table('users')
                ->where('name', $res[0])
                ->where('password', $res[1])
                ->first();
            //如果没有查询到 返回false
            if(!$res) {
                return false;
            }
            //如果存在则直接写入session
            $request->session()->put('uid', $res->id);
            return true;
        }
    }
}
