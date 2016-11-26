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
        	<span>文章添加</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" method="post" action="{{url('admin/post/insert')}}" enctype="multipart/form-data">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">文章标题</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="title" value="{{old('name')}}">
        				</div>
        			</div>
        			
                    <div class="mws-form-row">
                        <label class="mws-form-label">图片</label>
                        <div class="mws-form-item">
                            <input type="file" class="small" name="pic">
                        </div>
                    </div>
                    
                    <div class="mws-form-row">
                        <label class="mws-form-label">文章分类</label>
                        <div class="mws-form-item">
                            <select class="small" name="cate_id">
                                <option value="0">请选择</option>
                                @foreach($cates as $k=>$v)
                                <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">文章详情</label>
                        <div class="mws-form-item">
                            <textarea id="editor" name="content" type="text/plain" style="width:800px;height:500px;"></textarea>
                        </div>
                    </div>
                    <script type="text/javascript">
                        // var ue = UE.getEditor('editor');
                    </script>

                    <div class="mws-form-row">
                        <label class="mws-form-label">标签</label>
                        <div class="mws-form-item clearfix">
                            <ul class="mws-form-list inline" id="tags">
                                @foreach($tags as $k=>$v)
                                <li><label><input type="checkbox" name="tag_id[]" value="{{$v['id']}}"> <span>{{$v['name']}}</span></label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">快速添加标签</label>
                        <div class="mws-form-item">
                            <input id="addTag" type="text" class="small" name="" value="">
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

@section('js')
    <script type="text/javascript">
    $('#addTag').blur(function(){
        //获取元素的值
        var name = $(this).val();
        //如果为空 直接返回
        if(name == '') return;
        //发送给ajax 服务器添加
        $.get('{{url("admin/tag/ajax-insert")}}', {name:name}, function(data){
            if(data['code'] == '0') {
                //动态创建元素
                var newLi = $('#tags li').eq(0).clone(true);
                //修改值
                newLi.find('input').val(data['data']['id']);
                //修改文本
                newLi.find('span').html(name);
                console.log(newLi);
                //执行插入
                $('#tags').append(newLi);
            }
        },'json')
        //清空原来的值
        $(this).val('');
    })

    </script>
@endsection