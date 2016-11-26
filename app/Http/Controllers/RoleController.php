<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertRoleRequest;

class RoleController extends Controller
{
    /**
     * 获取所有的角色
     */
    public static function getRoles()
    {
        return Role::get();
    }

    /**
     * 角色的添加页面显示
     */
    public function getAdd()
    {
        return view('role.add',['permissions'=>PermissionController::getPermissions()]);
    }

    /**
     * 角色的添加操作
     */
    public function postInsert(Request $request)
    {
        //创建验证对象
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:roles',
            'display_name'=>'required'
            ],
            [
            'name.required'=>'角色标识必须填写',
            'display_name.required'=>'角色名必须填写',
            'name.unique'=>'角色标识已经存在,请更换'
            ]);
        //验证数据
        if($validator->fails()) {
            return redirect('admin/role/add')
                    ->withErrors($validator)
                    ->withInput();
        }
        //创建模型
        $role = new Role;
        //设置
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        
        //插入数据库
        if($role->save()) {
            //添加权限
            $role->perms()->sync($request->input('permission_id'));

            //跳转到角色的列表页
            return redirect('admin/role/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回角色的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 角色的列表操作
     */
    public function getIndex(Request $request)
    {
        //创建模型
        $role = new Role;
        //获取每页显示的数据
        $data['num'] = $request->input('num', 10);
        $data['keywords'] = $request->input('keywords');
        //读取数据
        $roles = $role->orderBy('id','desc')->where(function($query){
            //获取关键字
            $keywords = Request::capture()->input('keywords');
            //如果存在关键字
            if($keywords){
                $query->where('name','like','%'.$keywords.'%')
                    ->orWhere('display_name','like','%'.$keywords.'%');
            }
        })->paginate($data['num']);
        //分配数据并且进行模版显示
        return view('role.index', ['roles'=>$roles,'data'=>$data]);
    }

    /**
     * 角色的修改显示
     */
    public function getEdit($id)
    {
        return view('role.edit', [
            'info'=>Role::find($id),
            'permissions' => PermissionController::getPermissions(),
            'curperm' => DB::table('permission_role')->where('role_id', $id)->lists('permission_id')]);
    }

    /**
     * 角色的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建验证对象
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'display_name'=>'required'
            ],
            [
            'name.required'=>'角色标识必须填写',
            'display_name.required'=>'角色名必须填写',
            'name.unique'=>'角色标识已经存在,请更换'
            ]);
        //验证数据
        if($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        //创建模型
        $role = Role::find($request->id);
        //设置
        // $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        
        //插入数据库
        if($role->save()) {
            $role->perms()->sync($request->input('permission_id'));
            //跳转到角色的列表页
            return redirect('admin/role/index')->with('success', '更新成功');
        }else{
            //如果失败则跳转回角色的添加页面
            return back()->with('error','更新失败');
        }
    }

    /**
     * 角色的删除操作
     */
    public function getDelete($id)
    {
        //创建模型
        if(Role::where('id', $id)->delete()) {
            return back()->with('success','删除成功');            
        }else{
            return back()->with('error','删除失败');            
        }
    }

}
