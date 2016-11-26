@extends('admin.index')

@section('content')
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>分类添加</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="{{url('admin/cate/update')}}" enctype="multipart/form-data">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">分类名</label>
                        <div class="mws-form-item">
                            <input type="text" class="small" name="name" value="{{$info['name']}}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <label class="mws-form-label">父级分类</label>
                        <div class="mws-form-item">
                            <select class="small" name="pid">
                                <option value="0">请选择</option>
                                @foreach($cates as $k=>$v)
                                <option value="{{$v['id']}}"
                                    @if($info['pid'] == $v['id'])
                                        selected="selected" 
                                    @endif
                                >{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mws-button-row">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$info['id']}}">
                    <input type="submit" value="添加" class="btn btn-danger">
                    <input type="reset" value="重置" class="btn ">
                </div>
            </form>
        </div>      
    </div>
@endsection