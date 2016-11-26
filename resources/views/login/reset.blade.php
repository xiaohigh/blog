@extends('login.login')

@section('content')
<div class="tab-content clearfix" id="tab-login">
    <div class="panel panel-default nobottommargin">
    	<div class="panel-body" style="padding: 40px;">
    		<form id="login-form" name="login-form" class="nobottommargin" action="{{url('reset')}}" method="post">

                <div class="col_full">
                    <label for="login-form-username">密码:</label>
                    <input type="password" id="login-form-username" name="password" value="" class="form-control" />
                </div>

                <div class="col_full">
                    <label for="login-form-password">确认密码:</label>
                    <input type="password" id="login-form-password" name="repassword" value="" class="form-control" />
                </div>

                <div class="col_full nobottommargin">
                	<input type="hidden" name="id" value="{{$id}}">
                	<input type="hidden" name="remember_token" value="{{$remember_token}}">
                    <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">重置</button>
                    {{csrf_field()}}
                </div>

            </form>
    	</div>
    </div>
</div>

@endsection