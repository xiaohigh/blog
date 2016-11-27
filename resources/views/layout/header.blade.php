<!-- Header
============================================= -->
<header id="header" class="full-header sticky-header">
	<div id="header-wrap">
		<div class="container clearfix">
			<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

			<!-- Logo
			============================================= -->
			<div id="logo">
				<a href="/" class="">小high博客</a>
			</div><!-- #logo end -->

			<!-- Primary Navigation
			============================================= -->
			<nav id="primary-menu">
				<ul>
					@foreach($cates as $k=>$v)
					<li><a class="@if(!empty($request['cid']) && $request['cid'] == $v['id'])
						active
					@endif" href="{{url('/post/list')}}?cid={{$v['id']}}"><div>{{$v['name']}}</div></a>
						@if($v['subcate'])
						<ul>
							@foreach($v['subcate'] as $a=>$b)
							<li>
								<a href="index-corporate.html"><div>{{$b['name']}}</div></a>
								@if($b['subcate'])
								<ul>
									@foreach($b['subcate'] as $key => $value)
									<li><a href="index-corporate.html"><div>{{$value['name']}}</div></a></li>
									@endforeach
								</ul>
								@endif
							</li>
							@endforeach
						</ul>
						@endif
					</li>
					@endforeach
					<li><a href="/series">视频教程</a></li>
				</ul>

				<div id="top-search">
					<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
					<form action="{{url('post/list')}}" method="get">
						<input type="text" name="keywords" class="form-control" value="" placeholder="输出关键字">
					</form>
				</div><!-- #top-search end -->

			</nav><!-- #primary-menu end -->

		</div>

	</div>
</header><!-- #header end -->