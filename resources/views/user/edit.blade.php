@extends('admin.index')

@section('content')
	<div class="mws-panel grid_8">
    	<div class="mws-panel-header">
        	<span>用户修改</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" method="post" enctype="multipart/form-data" action="{{url('admin/user/update')}}">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">用户名</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="name" value="{{$info['name']}}">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">邮箱</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="email" value="{{$info['email']}}">
        				</div>
        			</div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">头像</label>
                        <div class="mws-form-item">
                            <img src="{{$info['profile']}}" width="100" alt="">
                            <input type="file" class="small" name="profile">
                        </div>
                    </div>
        		</div>
        		<div class="mws-button-row">
        			{{csrf_field()}}
                    <input type="hidden" name="id" value="{{$info['id']}}">
        			<input type="submit" value="修改" class="btn btn-danger">
        			<input type="reset" value="重置" class="btn ">
        		</div>
        	</form>
        </div>    	
    </div>
@endsection