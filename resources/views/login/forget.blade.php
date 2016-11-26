@extends('login.login')

@section('content')
	<div class="tab-content clearfix" id="tab-login">
        <div class="panel panel-default nobottommargin">
        	<div class="panel-body" style="padding: 40px;">
        		<form id="login-form" name="login-form" class="nobottommargin" action="{{url('forget')}}" method="post">

                    <div class="col_full">
                        <label for="login-form-username">邮箱:</label>
                        <input type="email" id="login-form-username" name="email" value="" class="form-control" />
                    </div>

                    <div class="col_full nobottommargin">
                        <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">发送验证邮件</button>
                        {{csrf_field()}}
                    </div>

                </form>
        	</div>
        </div>
    </div>
@endsection