<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class PublicController extends Controller
{
    /**
     * 获取图片token
     */
    public static function getQiniuImgToken()
    {
        // 构建鉴权对象
        $auth = new Auth(env('QINIU_KEY'), env('QINIU_SECRET'));
        // 要上传的空间
        $bucket = env('IMG_BUCKET');
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        return $token;
    }
}
