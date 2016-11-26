@extends('admin.index')

@section('content')
	<div class="mws-panel grid_8">
    	<div class="mws-panel-header">
        	<span>用户添加</span>
        </div>
        <div class="mws-panel-body no-padding">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div class="mws-form-message error">
                            {{$error}}
                        </div>
                    @endforeach
            </div>
        @endif
        	<form class="mws-form" method="post" action="{{url('admin/user/insert')}}" enctype="multipart/form-data">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">用户名</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="name" value="{{old('name')}}">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">密码</label>
        				<div class="mws-form-item">
        					<input type="password" class="small" name="password">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">确认密码</label>
        				<div class="mws-form-item">
        					<input type="password" class="small" name="repassword">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">邮箱</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="email">
        				</div>
        			</div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">角色</label>
                        <div class="mws-form-item">
                            <select name="role_id" id="" class="small">
                                @foreach($roles as $k => $v)
                                <option value="{{$v['id']}}">{{$v['display_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">头像</label>
                        <div class="mws-form-item">
                            <input type="file" class="small" name="profile">
                        </div>
                    </div>
        		</div>
        		<div class="mws-button-row">
        			{{csrf_field()}}
        			<input type="submit" value="添加" class="btn btn-danger">
        			<input type="reset" value="重置" class="btn ">
        		</div>
        	</form>
        </div>    	
    </div>
@endsection