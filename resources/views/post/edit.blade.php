@extends('admin.index')

@section('content')
    <script type="text/javascript" charset="utf-8" src="{{asset('/b/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('/b/ueditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('/b/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <style type="text/css">
        .fileinput-holder{
            width:40%;
        }
        .mws-form .mws-form-item .small[type=file]{
            width: 100%;
        }
    </style>
	<div class="mws-panel grid_8">
    	<div class="mws-panel-header">
        	<span>文章修改</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" method="post" action="{{url('admin/post/update')}}" enctype="multipart/form-data">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">文章标题</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="title" value="{{$info['title']}}">
        				</div>
        			</div>
        			
                    <div class="mws-form-row">
                        <label class="mws-form-label">图片</label>
                        <div class="mws-form-item">
                            <img src="{{$info['pic']}}" width="200" alt="">
                            <input type="file" class="small" name="pic">
                        </div>
                    </div>
                    
                    <div class="mws-form-row">
                        <label class="mws-form-label">文章分类</label>
                        <div class="mws-form-item">
                            <select class="small" name="cate_id">
                                <option value="0">请选择</option>
                                @foreach($cates as $k=>$v)
                                <option value="{{$v['id']}}" 
                                @if($v['id'] == $info['cate_id'])
                                    selected 
                                @endif
                                >{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">文章详情</label>
                        <div class="mws-form-item">
                            <textarea id="editor" name="content" type="text/plain" style="width:800px;height:500px;">{!!$info['content']!!}</textarea>
                        </div>
                    </div>
                    <script type="text/javascript">
                        // var ue = UE.getEditor('editor');
                    </script>
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