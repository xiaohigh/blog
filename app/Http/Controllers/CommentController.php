<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * 评论添加操作
     */
    public function insert(Request $request)
    {
        //创建模型
        $comment = new Comment;
        //获取参数
        $comment->user_id = session('uid');
        $comment->post_id = $request->input('post_id');
        $comment->pid = $request->input('pid');
        $comment->content = $request->input('content');
        //执行插入
        if($comment->save()) {
            return back();
        } else {
            return back();
        }
    }

    /**
     * 通过文章id获取所有的分类
     */
    public static function getCommentByPostId($post_id)
    {
        return Comment::where('post_id', $post_id)
            ->join('users','users.id','=','comments.user_id')
            ->select('comments.*','users.id as uid','users.name as names','users.profile')
            ->get()->toArray();
    }

    /**
     * 递归方式获取评论数组
     */
    public static function getPostComment($post, $pid)
    {
        $data = array();
        //遍历文章
        foreach ($post as $key => $value) {
            if($value['pid'] == $pid) {
                $value['sub'] = self::getPostComment($post, $value['id']);
                $data[] = $value;
            }
        }
        return $data;
    }



}
