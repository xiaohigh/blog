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
    <script src="/b/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/f/plupload/js/plupload.full.min.js"></script>
    <script src="/f/js/qiniu.js"></script>
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
                            <img src="{{env('IMG_URL')}}/{{$info['pic']}}" width="200" alt=""><br>
                            <button class="btn btn-info" id="pickfiles">选择图片</button>
                            <input type="hidden" name="pic" id="pic">
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
                        var uploader = Qiniu.uploader({
                            runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                            browse_button: 'pickfiles',         // 上传选择的点选按钮，**必需**
                            uptoken : '<?php echo $token; ?>', // uptoken 是上传凭证，由其他程序生成
                            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                            unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
                            domain: 'sss',     // bucket 域名，下载资源时用到，**必需**
                            max_file_size: '100mb',             // 最大文件体积限制
                            flash_swf_url: '/f/plupload/js/Moxie.swf',  //引入 flash,相对路径
                            max_retries: 3,                     // 上传失败最大重试次数
                            dragdrop: true,                     // 开启可拖曳上传
                            drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                            chunk_size: '4mb',                  // 分块上传时，每块的体积
                            auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                            init: {
                                'FilesAdded': function(up, files) {
                                    plupload.each(files, function(file) {
                                        // 文件添加进队列后,处理相关的事情
                                    });
                                },
                                'BeforeUpload': function(up, file) {
                                    // 每个文件上传前,处理相关的事情
                                },
                                'UploadProgress': function(up, file) {
                                    // 每个文件上传时,处理相关的事情
                                },
                                'FileUploaded': function(up, file, info) {
                                    // 每个文件上传成功后,处理相关的事情
                                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                                    // {
                                    //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                                    //    "key": "gogopher.jpg"
                                    //  }
                                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html

                                    var res = $.parseJSON(info);
                                    if(res.key) {
                                        $('#pic').val(res.key);
                                        alert('图片上传成功');
                                    }else{
                                        alert('图片上传失败');
                                    }
                                },
                                'Error': function(up, err, errTip) {
                                    //上传出错时,处理相关的事情
                                },
                                'UploadComplete': function() {
                                    //队列文件处理完毕后,处理相关的事情
                                },
                                'Key': function(up, file) {
                                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                                    // 该配置必须要在 unique_names: false , save_key: false 时才生效

                                    var key = "";
                                    // do something with key here
                                    return key
                                }
                            }
                        });
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