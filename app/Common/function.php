<?php 
	
	//自定义函数 返回内容提醒
	function display($notification, $url = '') 
	{
		return view('layout.reminder', ['info'=>$notification]);
	}

	/**
	 * 显示评论列表
	 */
	function showComment($comment, $level)
	{
		$str = '';
		//遍历数组
		foreach ($comment as $key => $value) {
			$str .= '<li class="comment even thread-even depth-1" id="li-comment-1">

                            <div id="comment-1" class="comment-wrap clearfix">

                                <div class="comment-meta">

                                    <div class="comment-author vcard">

                                        <span class="comment-avatar clearfix">
                                            <img width="40" data-src="holder.js/40x40?theme=sky" src="'.$value['profile'].'">
                                        </span>

                                    </div>

                                </div>

                                <div class="comment-content clearfix">

                                    <div class="comment-author">'.$value['names'].'<span><a href="#" title="Permalink to this comment">'.$value['created_at'].'</a></span></div>

                                    <p>'.$value['content'].'</p>

                                    <a class="comment-reply-link" pid="'.$value['id'].'" href="#respond"><i class="icon-reply"></i></a>

                                </div>

                                <div class="clear"></div>

                            </div>';
            if(!empty($value['sub'])) {
            	$str .= '<ul class="children">';
                $str .= showComment($value['sub'], $value['id']);          
                $str .= '</ul>';
            }
            $str .= '</li>';
		}
        return $str;
	}

	/**
	 * 显示侧边栏
	 */
	function slider()
	{
		//获取最新的五篇文章
		$last = \App\Model\Post::orderBy('created_at', 'desc')->limit(5)->get();
		//获取最热的五篇文章
		$hotids = \DB::table('post_views')->orderBy('views','desc')->limit(5)->lists('post_id');

		$hottest = \DB::table('posts')
			->join('post_views','posts.id','=','post_views.post_id')
			->select('posts.*','post_views.views')
			->whereIn('id', $hotids)
			->get();

		//获得所有的标签
		$tags = \App\Http\Controllers\TagController::getTags();

		return view('layout.slider', [
			'lastest' => $last, 
			'hottest' => $hottest, 
			'tags' => $tags
			]); 
	}

	/**
	 * 定义函数
	 */
	function qiniu($url)
	{
		return 'http://oh7d5rfex.bkt.clouddn.com'.$url;
	}

	/**
	 * markdown语法转换
	 */
	function markToHtml($content)
	{
		return \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($content);
	}

	
 ?>