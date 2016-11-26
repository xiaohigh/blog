@extends('layout.admin')

@section('content')
    <script src="/b/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/f/plupload/js/plupload.full.min.js"></script>
    <script src="/f/js/qiniu.js"></script>
	<div class="mws-panel grid_8">
    	<div class="mws-panel-header">
        	<span>视频添加</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" method="post" action="{{url('admin/video/insert')}}" enctype="multipart/form-data">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">视频名称</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="title" value="{{old('title')}}">
        				</div>
        			</div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">视频地址</label>
                        <div class="mws-form-item">
                            <div id="container">
                                <button class="btn btn-info" id="pickfiles" href="javascript:;">选择文件</button>
                                <input type="hidden" name="url" id="profile">
                            </div>
                        </div>
                    </div>

                    <div class="mws-form-row">
                        <label class="mws-form-label">系列</label>
                        <div class="mws-form-item">
                            <select name="serie_id" id="" class="small">
                                @foreach($series as $k => $v)
                                    <option value="{{$v['id']}}">{{$v['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>



        		<div class="mws-button-row">
        			{{csrf_field()}}
        			<input type="submit" value="添加" class="btn btn-danger">
        			<input type="reset" value="重置" class="btn ">
        		</div>
        	</form>
            <script type="text/javascript">
                var uploader = Qiniu.uploader({
                    runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                    browse_button: 'pickfiles',         // 上传选择的点选按钮，**必需**
                    // 在初始化时，uptoken, uptoken_url, uptoken_func 三个参数中必须有一个被设置
                    // 切如果提供了多个，其优先级为 uptoken > uptoken_url > uptoken_func
                    // 其中 uptoken 是直接提供上传凭证，uptoken_url 是提供了获取上传凭证的地址，如果需要定制获取 uptoken 的过程则可以设置 uptoken_func
                    uptoken : '<?php echo $token; ?>', // uptoken 是上传凭证，由其他程序生成
                    // uptoken_url: '/uptoken',         // Ajax 请求 uptoken 的 Url，**强烈建议设置**（服务端提供）
                    // uptoken_func: function(file){    // 在需要获取 uptoken 时，该方法会被调用
                    //    // do something
                    //    return uptoken;
                    // },
                    get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                    // downtoken_url: '/downtoken',
                    // Ajax请求downToken的Url，私有空间时使用,JS-SDK 将向该地址POST文件的key和domain,服务端返回的JSON必须包含`url`字段，`url`值为该文件的下载地址
                    unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
                    // save_key: true,                  // 默认 false。若在服务端生成 uptoken 的上传策略中指定了 `sava_key`，则开启，SDK在前端将不对key进行任何处理
                    domain: 'sss',     // bucket 域名，下载资源时用到，**必需**
                    container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
                    max_file_size: '100mb',             // 最大文件体积限制
                    flash_swf_url: '/f/plupload/js/Moxie.swf',  //引入 flash,相对路径
                    max_retries: 3,                     // 上传失败最大重试次数
                    dragdrop: true,                     // 开启可拖曳上传
                    drop_element: 'container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
                    chunk_size: '4mb',                  // 分块上传时，每块的体积
                    auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
                    x_vars : {
                        //自定义变量，参考http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html


                    },
                    "persistentOps":        "avthumb/m3u8/segtime/10/ab/128k/ar/44100/acodec/libfaac/r/30/vb/240k/vcodec/libx264/stripmeta/0",
                    "persistentNotifyUrl" : 'http://xdl.xiaohigh.com/notify.php',
                    "persistentPipeline" : "hls-videos",
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
                                $('#profile').val(res.key);
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
    </div>
@endsection