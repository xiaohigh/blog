@extends('admin.index')

@section('content')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>权限规则修改</span>
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
            <form class="mws-form" method="post" action="{{url('admin/permission/update')}}" enctype="multipart/form-data">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">权限规则名</label>
                        <div class="mws-form-item">
                            <input type="text" class="small" name="display_name" value="{{$info['display_name']}}">
                        </div>
                    </div>
                </div>
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">权限规则标识</label>
                        <div class="mws-form-item">
                            <input type="text" class="small" name="name" value="{{$info['name']}}">
                        </div>
                    </div>
                </div>
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">介绍</label>
                        <div class="mws-form-item">
                            <textarea name="description" id="" class="small" cols="30" rows="10">{{$info['description']}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mws-button-row">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$info['id']}}">
                    <input type="submit" value="更新" class="btn btn-danger">
                    <input type="reset" value="重置" class="btn ">
                </div>
            </form>
        </div>      
    </div>
@endsection