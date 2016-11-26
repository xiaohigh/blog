<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link rel="stylesheet" href="{{asset('/f/css/bootstrap.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/style.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/css/dark.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/css/font-icons.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/css/animate.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/css/magnific-popup.css')}}" type="text/css" />

	<link rel="stylesheet" href="{{asset('/f/css/responsive.css')}}" type="text/css" />
	<link rel="stylesheet" href="{{asset('/f/sheet.css')}}" type="text/css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="{{asset('/f/js/jquery.js')}}"></script>
	<script type="text/javascript" src="{{asset('/f/js/plugins.js')}}"></script>

	<!-- Document Title
	============================================= -->
	<title>{{config('app.blogname')}}</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		{!!view('layout.header', ['cates'=>App\Http\Controllers\CateController::cates()])!!}

		<!-- Page Title
		============================================= -->
		

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

                        <div class="tab-container">
							@if (count($errors) > 0)
							    <div class="alert alert-danger">
							        <ul style="list-style:none">
							            @foreach ($errors->all() as $error)
							                <li>{{ $error }}</li>
							            @endforeach
							        </ul>
							    </div>
							@endif
                            <div class="tab-content clearfix" id="tab-register">
                                <div class="panel panel-default nobottommargin">
                                	<div class="panel-body" style="padding: 40px;">
										
                                		<form id="register-form" name="register-form" class="nobottommargin" action="{{url('regist')}}" method="post">

				                            <div class="col_full">
				                                <label for="register-form-name">昵称:</label>
				                                <input type="text" id="register-form-name" name="name" value="{{old('name')}}" class="form-control" />
				                                <p class="text-danger text-right" style="font-size:12px"></p>
				                            </div>

				                            <div class="col_full">
				                                <label for="register-form-email">邮箱:</label>
				                                <input type="text" id="register-form-email" name="email" value="{{old('email')}}" class="form-control" />
				                            </div>

				                            <div class="col_full">
				                                <label for="register-form-password">密码:</label>
				                                <input type="password" id="register-form-password" name="password" value="" class="form-control" />
				                            </div>

				                            <div class="col_full">
				                                <label for="repassword">确认密码:</label>
				                                <input type="password" id="register-form-repassword" name="register-form-repassword" value="" class="form-control" />
				                            </div>

				                            <div class="col_full nobottommargin">
				                            	{{csrf_field()}}
				                                <button class="button button-3d button-black nomargin" id="register-form-submit" value="register">注册</button>
				                            </div>

				                        </form>
                                	</div>
                                </div>
                            </div>

                        </div>

                    </div>

				</div>

			</div>

		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_half">
						Copyrights &copy; 2014 All Rights Reserved by Canvas Inc.<br>
						<div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-vimeo">
								<i class="icon-vimeo"></i>
								<i class="icon-vimeo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-yahoo">
								<i class="icon-yahoo"></i>
								<i class="icon-yahoo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-linkedin">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>
						</div>

						<div class="clear"></div>

						<i class="icon-envelope2"></i> info@canvas.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> +91-11-6541-6369 <span class="middot">&middot;</span> <i class="icon-skype2"></i> CanvasOnSkype
					</div>

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="{{asset('/f/js/functions.js')}}"></script>

</body>
</html>