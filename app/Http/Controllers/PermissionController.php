<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Permission;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    /**
     * 获取所有的权限规则
     */
    public static function getPermissions()
    {
        return Permission::get();
    }

    /**
     * 权限规则的添加页面显示
     */
    public function getAdd()
    {
        return view('permission.add');
    }

    /**
     * 权限规则的添加操作
     */
    public function postInsert(PermissionRequest $request)
    {
        //创建模型
        $permission = new Permission;
        //设置
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        
        //插入数据库
        if($permission->save()) {
            //跳转到权限规则的列表页
            return redirect('admin/permission/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回权限规则的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 权限规则的列表操作
     */
    public function getIndex(Request $request)
    {
        //创建模型
        $permission = new Permission;
        //获取每页显示的数据
        $data['num'] = $request->input('num', 10);
        $data['keywords'] = $request->input('keywords');
        //读取数据
        $permissions = $permission->orderBy('id','desc')->where(function($query){
            //获取关键字
            $keywords = Request::capture()->input('keywords');
            //如果存在关键字
            if($keywords){
                $query->where('name','like','%'.$keywords.'%')
                    ->orWhere('display_name','like','%'.$keywords.'%');
            }
        })->paginate($data['num']);
        //分配数据并且进行模版显示
        return view('permission.index', ['permissions'=>$permissions,'data'=>$data]);
    }

    /**
     * 权限规则的修改显示
     */
    public function getEdit($id)
    {
        return view('permission.edit', ['info'=>Permission::find($id)]);
    }

    /**
     * 权限规则的修改操作
     */
    public function postUpdate(PermissionRequest $request)
    {
        //创建模型
        $permission = Permission::find($request->id);
        //设置
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        
        //插入数据库
        if($permission->save()) {
            //跳转到权限规则的列表页
            return redirect('admin/permission/index')->with('success', '更新成功');
        }else{
            //如果失败则跳转回权限规则的添加页面
            return back()->with('error','更新失败');
        }
    }

    /**
     * 权限规则的删除操作
     */
    public function getDelete($id)
    {
        //创建模型
        if(Permission::where('id', $id)->delete()) {
            return back()->with('success','删除成功');            
        }else{
            return back()->with('error','删除失败');            
        }
    }

}
