@extends('login.login')

@section('content')
	<div class="tab-content clearfix" id="tab-login">
		<div class="panel panel-default nobottommargin">
        	<div class="panel-body" style="padding: 40px;">
        	<div class="alert alert-warning" role="alert">{{$info}}</div>
			</div>
		</div>
    </div>
@endsection