<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AuthMiddleware
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
        //获取路径
        $path = $request -> path();
        //检测权限
        $user = User::find($request->session()->get('uid'));
        $res = $user->can($path);
        //
        if($res){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
