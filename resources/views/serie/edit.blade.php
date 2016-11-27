@extends('layout.admin')

@section('content')
    <script src="/b/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/f/plupload/js/plupload.full.min.js"></script>
    <script src="/f/js/qiniu.js"></script>
    <div class="mws-panel grid_8">
        <div class="mws-panel-header">
            <span>系列添加</span>
        </div>
        <div class="mws-panel-body no-padding">
            <form class="mws-form" method="post" action="{{url('admin/serie/update')}}" enctype="multipart/form-data">
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">系列名称</label>
                        <div class="mws-form-item">
                            <input type="text" class="small" name="title" value="{{$serie->title}}">
                        </div>
                    </div>
                </div>
                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">系列主图</label>
                        <div class="mws-form-item">
                            <div id="container">
                                <img src="{{env('IMG_URL')}}/{{$serie->profile}}" width="200" alt=""><br>
                                <button class="btn btn-info" id="pickfiles" href="javascript:;">选择文件</button>
                                <input type="hidden" name="profile" id="profile">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mws-form-inline">
                    <div class="mws-form-row">
                        <label class="mws-form-label">系列介绍</label>
                        <div class="mws-form-item">
                            <textarea name="intro" class="small" id="" cols="30" rows="10">{{$serie->intro}}</textarea>
                        </div>
                    </div>
                </div>


                <div class="mws-button-row">
                    {{csrf_field()}}
                    <input type="submit" value="更新" class="btn btn-danger">
                    <input type="hidden" name="id" value="{{$serie->id}}">
                    <input type="reset" value="重置" class="btn ">
                </div>
            </form>
            <script type="text/javascript">
                var uploader = Qiniu.uploader({
                    runtimes: 'html5,flash,html4',      // 上传模式,依次退化
                    browse_button: 'pickfiles',         // 上传选择的点选按钮，**必需**
                    uptoken : '<?php echo $token; ?>', // uptoken 是上传凭证，由其他程序生成
                    get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
                    unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
                    domain: 'sss',     // bucket 域名，下载资源时用到，**必需**
                    container: 'container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
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