<?php 
	
	//自定义函数 返回内容提醒
	function display($notification, $url = '') 
	{
		return view('layout.reminder', ['info'=>$notification]);
	}

	/**
	 * 显示侧边栏
	 */
	function slider()
	{
		//获取最新的五篇文章
		$last = \App\Model\Post::orderBy('created_at', 'desc')->limit(5)->get();

		//获得所有的标签
		$tags = \App\Http\Controllers\TagController::getTags();

		return view('layout.slider', [
			'lastest' => $last, 
			'tags' => $tags
			]); 
	}

	/**
	 * 定义函数
	 */
	function qiniu($url)
	{
		return env('IMG_URL').'/'.$url;
	}

	/**
	 * markdown语法转换
	 */
	function markToHtml($content)
	{
		return \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($content);
	}

	
 ?>