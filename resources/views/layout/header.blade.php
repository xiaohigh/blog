<!-- Header
============================================= -->
<header id="header" class="full-header sticky-header">
	<div id="header-wrap">
		<div class="container clearfix">
			<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

			<!-- Logo
			============================================= -->
			<div id="logo">
				<a href="index.html" class="standard-logo" data-dark-logo="images/logo-dark.png">小high博客</a>
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
				</ul>

				<!-- Top Cart
				============================================= -->
				<!-- <div id="top-cart">
					<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
					<div class="top-cart-content">
						<div class="top-cart-title">
							<h4>Shopping Cart</h4>
						</div>
						<div class="top-cart-items">
							<div class="top-cart-item clearfix">
								<div class="top-cart-item-image">
									<a href="#"><img src="images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
								</div>
								<div class="top-cart-item-desc">
									<a href="#">Blue Round-Neck Tshirt</a>
									<span class="top-cart-item-price">$19.99</span>
									<span class="top-cart-item-quantity">x 2</span>
								</div>
							</div>
							<div class="top-cart-item clearfix">
								<div class="top-cart-item-image">
									<a href="#"><img src="images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
								</div>
								<div class="top-cart-item-desc">
									<a href="#">Light Blue Denim Dress</a>
									<span class="top-cart-item-price">$24.99</span>
									<span class="top-cart-item-quantity">x 3</span>
								</div>
							</div>
						</div>
						<div class="top-cart-action clearfix">
							<span class="fleft top-checkout-price">$114.95</span>
							<button class="button button-3d button-small nomargin fright">View Cart</button>
						</div>
					</div>
				</div> --><!-- #top-cart end -->

				<!-- Top Search
				============================================= -->
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