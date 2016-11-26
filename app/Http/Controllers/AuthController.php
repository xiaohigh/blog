<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Permission;
use App\User;
class AuthController extends Controller
{
    
    /**
     * 角色添加
     */
    public function getAdd()
    {
        //创建角色
        // $owner = new Role();
        // $owner->name         = 'owner';
        // $owner->display_name = 'Project Owner'; // optional
        // $owner->description  = 'User is the owner of a given project'; // optional
        // $owner->save();

        // $admin = new Role();
        // $admin->name         = 'admin';
        // $admin->display_name = 'User Administrator'; // optional
        // $admin->description  = 'User is allowed to manage and edit other users'; // optional
        // $admin->save();

        // $admin = \App\Model\Role::find(1);
        // //查找用户
        // $user = User::first();
        // $user->attachRole($admin);

        // $user->roles()->attach($admin->id);

    }

    /**
     * 创建权限
     */
    public function getPerm()
    {
        $createPost = new Permission();
        $createPost->name         = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional
        // Allow a user to...
        $createPost->description  = 'create new blog posts'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users'; // optional
        // Allow a user to...
        $editUser->description  = 'edit existing users'; // optional
        $editUser->save();

        // $createPost = Permission::find(3);
        // $editUser = Permission::find(4);

        $one = Role::find(1);
        $two = Role::find(2);

        $one->attachPermission($createPost);
        $two->attachPermission($editUser);

    }

    /**
     * 检查权限
     */
    public function getCheck()
    {
        // dd(User::find(1) -> can('edit-user'));
        $user = User::find(1);

        // $res = $user->can('create-post');
        $res = $user->hasRole('owner');

        dd($res);
    }
    


}
