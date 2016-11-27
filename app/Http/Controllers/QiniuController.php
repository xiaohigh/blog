<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QiniuController extends Controller
{
    //
    public function callbacks()
    {
        //获取请求内容
        $_body = file_get_contents('php://input');
        file_put_contents(storage_path('logs').'/qiniu.log', $_body."\r\n\r\n", FILE_APPEND);
        //进行json解析
//        $data = json_decode($_body, true);
//        //查看数据
//        $video = Video::where('video',$data['inputKey'])->firstOrFail();
//        //
//        $video -> m3u8 = $data['items'][0]['key'];
//        if($video -> save()) {
//            return 'ok';
//        }else{
//            return 'fail';
//        }
    }
}
