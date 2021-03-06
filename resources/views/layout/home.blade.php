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
    <script type="text/javascript" src="{{asset('/f/js/holder.js')}}"></script>

    <!-- Document Title
    ============================================= -->
    <title>{{config('app.blogname')}}</title>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

{!!\App\Http\Controllers\IndexController::header()!!}

    <!-- Content
    ============================================= -->
    @section('con')
        <section id="content">

            <div class="content-wrap ">

                <div class="container clearfix">

                    <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

                        <div class="tab-container">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <ul style="list-style:none">
                                        <li>{{ session('error') }}</li>
                                    </ul>
                                </div>
                            @endif

                            @section('content')
                                <div class="tab-content clearfix" id="tab-login">
                                    <div class="panel panel-default nobottommargin">
                                        <div class="panel-body" style="padding: 40px;">
                                            <form id="login-form" name="login-form" class="nobottommargin" action="{{url('logining')}}" method="post">

                                                <div class="col_full">
                                                    <label for="login-form-username">邮箱:</label>
                                                    <input type="email" id="login-form-username" name="email" value="" class="form-control" />
                                                </div>

                                                <div class="col_full">
                                                    <label for="login-form-password">密码:</label>
                                                    <input type="password" id="login-form-password" name="password" value="" class="form-control" />
                                                </div>

                                                <div class="col_full nobottommargin">
                                                    <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">登录</button>
                                                    {{csrf_field()}}
                                                    <a href="{{url('forget')}}" class="fright">忘记密码</a>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @show
                        </div>

                    </div>

                </div>

            </div>

        </section><!-- #content end -->
    @show
<!-- Footer
		============================================= -->
    <footer id="footer" class="dark">

        <!-- Copyrights
        ============================================= -->
        <div id="copyrights">

            <div class="container clearfix">

                <div class="col_half" id="power">
                    <div>Powered By XiaoHigh</div>
                    <div class="copyright-links">京ICP备13041202号</div>
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