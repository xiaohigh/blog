<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', "LoginController@login");
Route::post('logining', "LoginController@logining");
Route::get('register', "LoginController@register");
Route::post('regist', "LoginController@regist");
Route::get('forget', "LoginController@forget");
Route::post('forget', "LoginController@forget");
Route::get('reset', "LoginController@reset");
Route::post('reset', "LoginController@reset");

//文章操作
Route::get('post/{id}', 'IndexController@show')->where('id','[0-9]+');
Route::get('post/list', 'IndexController@lists');
Route::get('/markdown', 'IndexController@markdown');

//后台的登录页面
Route::get('admin/login', "AdminController@login");
Route::post('admin/login', "AdminController@login");
Route::get('admin/logout', "AdminController@logout");

//添加评论
Route::post('comment/insert', [
	'uses' => 'CommentController@insert',
	'middleware' => 'login'
	]);

//测试
Route::get('test', 'IndexController@test');
Route::get('sub', 'IndexController@sub');
Route::get('pub', 'IndexController@pub');

//在线订票
Route::get('/piao', 'PiaoController@index');//订票首页
Route::get('/cp', 'PiaoController@createPiaos');//创建票
Route::post('/order', 'PiaoController@order');//创建票


//后台相关操作 需要登录 验证
Route::group(['middleware'=>['login']], function(){

	//后台首页
	Route::get('admin', 'AdminController@index');

	//后台用户管理
	Route::controller('admin/user', 'UserController');

	//后台分类管理
	Route::controller('admin/cate', 'CateController');

	//文章管理
	Route::controller('admin/post', 'PostController');

	//标签管理
	Route::controller('admin/tag', 'TagController');

	//权限管理
	Route::controller('admin/auth', 'AuthController');

	//角色管理
	Route::controller('admin/role', 'RoleController');

	//权限规则管理
	Route::controller('admin/permission', 'PermissionController');

	//歌词i采集
	Route::controller('sougou', 'SougouController');
});
	