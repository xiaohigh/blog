<?php

namespace App\Http\Controllers;

use Config;
use Hash;
use DB;
use Illuminate\Http\Request;
use App\Model\Cate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    /**
     * 成员属性
     */
    protected static $instance = null;

    /**
     * 分类的添加页面显示
     */
    public function getAdd()
    {
        return view('cate.add', ['cates'=>$this->getCates()]);
    }

    /**
     * 获取所有的分类信息
     */
    public function getCates()
    {
        //获取所有的分类
        $cates = Cate::select(DB::raw('b_cates.id, name, pid, path, concat(path,",",id) as paths'))
            ->orderBy('paths')
            ->get()
            ->toArray();
        //遍历
        $res = array();
        foreach ($cates as $key => &$value) {
            //获取层级
            $len = count(explode(',', $value['path']));
            //修改
            $value['name'] = str_repeat('|------', $len-1).$value['name'];
        }
        return $cates;
    }

    /**
     * 单例模式创建对象
     */
    public static function instance()
    {
        return self::$instance ? self::$instance : (new CateController);
    }

    /**
     * 快速获取当前的递归分类数组
     */
    public static function cates()
    {
        return self::instance() -> getCateByPid(0);
    }

    /**
     * 递归方式获取分类的数组
     */
    private function getCateByPid($pid)
    {
        //获取所有的分类信息
        $cates = Cate::get()->toArray();
        //遍历获取父级id为$pid的元素
        $res = array();
        foreach ($cates as $key => $value) {
            if($value['pid'] == $pid) {
                $value['subcate'] = $this->getCateByPid($value['id']);
                $res[] = $value;
            }
        }
        //遍历结果集获取自己分类信息
        // foreach ($res as $key => $value) {
        //     $res[$key]['subcate'] = $this->getCateByPid($value['id']);
        // }

        //返回结果
        return $res;
    }

    /**
     * 分类的添加操作
     */
    public function postInsert(Request $request)
    {
        //创建模型
        $cate = new Cate;
        //设置分类名称
        $cate->name = $request->input('name');
        $cate->pid = $request->input('pid');
        $cate->path = $this->getPathByPid($cate->pid);
        //插入数据库
        if($cate->save()) {
            //跳转到分类的列表页
            return redirect('admin/cate/index')->with('success', '添加成功');
        }else{
            //如果失败则跳转回分类的添加页面
            return back()->with('error','添加失败');
        }
    }

    /**
     * 通过pid获取path路径
     */
    private function getPathByPid($pid)
    {
        if($pid == 0) {
            return '0';
        } else {
            //获取父级分类的信息
            $info = Cate::find($pid);
            return $info['path'].','.$info['id'];
        }
    }

    /**
     * 分类的列表操作
     */
    public function getIndex(Request $request)
    {

        $res = $this->getCateByPid(0);
        //分配数据并且进行模版显示
        return view('cate.index', ['cates'=>$this->getCates()]);
    }

    /**
     * 分类的修改显示
     */
    public function getEdit($id)
    {
        return view('cate.edit', ['info'=>Cate::find($id),'cates'=>$this->getCates()]);
    }

    /**
     * 分类的修改操作
     */
    public function postUpdate(Request $request)
    {
        //创建模型
        $info = Cate::find($request->id);
        //设置内容
        $info->name = $request->name;
        $info->pid = $request->pid;
        $info->path = $this->getPathByPid($info->pid);
        //修改
        if($info->save()){
            return redirect('admin/cate/index')->with('success', '修改成功');
        }else{
            return back()->with('error','修改失败');
        }
    }

    /**
     * 分类的删除操作
     */
    public function getDelete($id)
    {
        //创建模型
        //获取当前的信息
        $info = Cate::find($id);
        $path = $info['path'].','.$info['id'];
        if(Cate::where('id', $id)->delete() ) {
            Cate::where('path','like',$path.'%')->delete();
            return back()->with('success','删除成功');            
        }else{
            return back()->with('error','删除失败');            
        }
    }

}
