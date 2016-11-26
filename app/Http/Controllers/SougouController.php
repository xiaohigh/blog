<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Lyric;
use Curl\curl;

/**
 * 采集php100的内容
 */
class SougouController extends Controller
{
    /**
     *  错误代码
     *  1000 获取字母列表源代码失败
     *  1001 获取字母列表链接失败
     */
    public $errorCode = 0;

    /**
     * 初始化操作
     */
    public function __construct()
    {
        //创建curl对象
        $this -> c = new Curl;
        $this -> c -> setHeader('User-Agent','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36');
        $this -> c -> setHeader('Connection','keep-alive');
        //获取现有的歌手列表
        $this->singers = Lyric::groupBy('singer')->lists('singer')->toArray();
    }

    /**
     * 获取字母列表页的源代码
     */
    public function getLetterHtml()
    {
        //获取页面源代码
        if(!($html = Cache::get('letterListHtml'))){
            //获取歌词列表页内容
            $ecode = $this -> c -> get('http://www.kuwo.cn/geci/artist.htm');
            //判断 如果没有错误信息的话
            if($ecode == null){
                $html = $this -> c -> response;
                //将结果写入缓存中
                Cache::put('letterListHtml', $html, 60*24*5);
            }else{
                $this->errorCode = 1000;
                return;
            }
        }
        //返回
        return $html;
    }

    /**
     * 首页显示
     */
    public function getLetterListLink()
    {
        //检测是否有缓存
        $res = Cache::get('letterLinks');
        if(!$res){
            //获取html
            $html = $this->getLetterHtml();
            //解析源代码获取歌词链接
            preg_match_all('/<a id="word_.*".*href="(.*)">.*<\/a>/isU', $html, $res);
            //判断结果
            if($res[1]){
                Cache::put('letterLinks', $res[1], 60*24*5);
                return $res[1];            
            }else{
                $this->errorCode = 1001;
                return;
            }
        }
        return $res;
    }

    /**
     * 入口程序
     */
    public function getMain()
    {
        set_time_limit(0);
        //获取字母列表链接
        $links = $this->getLetterListLink();
        //遍历所有的字母链接
        foreach ($links as $key => $value) {
            if($key == 0) continue;
            //获取字母
            $letter = $this->getLetterByUrl($value);
            //获取列表页的最大页数
            $maxPages = $this->getListSingerMaxPages('http://www.kuwo.cn'.$value);
            //遍历拼接列表页链接获取数据
            for($i = 1;$i <= $maxPages; $i++){
                //拼接url
                $url = 'http://www.kuwo.cn/geci/artist_'.$letter.'_'.$i.'.htm';                
                //通过url
                $singers = $this->getListSingerLinks($url);

                
                $len = count($singers);
                for($j = 0; $j<= $len-1; $j++) {
                    //通过歌手url获取歌手的id
                    // $sid = $this->getSingerId($singers[$j]);
                    //检测是否已经采集过
                    // $status = $this->checkExistsBySid($sid);
                    // if($status) continue;
                    //通过url获取歌手的所有歌曲
                    $songs = $this->getSingerSongList($singers[$j]);
                    //遍历数组
                    foreach ($songs as $k => $v) {
                        //通过歌的id获取歌词信息
                        $data = $this->getLyricByRid($v['rid']);
                        if($data){
                            $this->insertDb($data);
                        }
                    }
                }

            }
        }


        // $res = $this->getSingerSongList('http://www.kuwo.cn/geci/a_70594/');

        // foreach ($res as $key => $value) {
        //     //    
        //     $data = $this->getLyricByRid($value['rid']);

        //     if($data){
        //         $this->insertDb($data);
        //     }
        // }
    }

    /**
     * 通过sid检测是否已经存在
     */
    private function checkExistsBySid($sid)
    {
        //通过sid获取歌手的名称
        $name = $this->getNameBySid($sid);
        //检测是否已经存在
        if(in_array($name, $this->singers)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 通过sid获取名称
     */
    private function getNameBySid($sid)
    {
        //拼接
        $url = 'http://www.kuwo.cn/geci/a_'.$sid.'/';
        //获取内容
        $data = $this->getHTML($url);
        //提取结果
        preg_match('/<h3>(.*)歌词<\/h3>/isU', $data, $tmp);
        //返回结果
        if($tmp[1]){
            return $tmp[1];
        }
    }

    /**
     * 根据url获取当前的字母
     */
    public function getLetterByUrl($url)
    {
        preg_match('/artist_(\w).htm/isU', $url, $tmp);
        return $tmp[1] ? $tmp[1] : null;
    }

    /**
     * 在字母列表页中获取信息
     */
    public function getListSingerLinks($url)
    {
        //获取源代码
        $html = $this->getHTML($url);

        //局部获取html
        preg_match('/<ul class="songer_list">(.*)<\/ul>/isU', $html, $tmp);

        //提取a链接
        preg_match_all('/<li><a.*href="(.*)".*target="_blank".*>.*<\/a><\/li>/isU', $tmp[1], $temp);

        //返回a链接
        if($temp[1]){
            return $temp[1];
        }
    }

    /**
     * 在字母列表页中获取总的页码
     */
    private function getListSingerMaxPages($url)
    {
        //获取源代码
        $html = $this->getHTML($url);

        //获取局部的链接html
        preg_match('/<a href="\/geci\/artist_.*_(\d+).htm">末页<\/a>/isU', $html, $tmp);

        //返回最大的页码
        return $tmp[1];
    }

    /**
     * 获取歌手详情中的歌曲列表a链接
     */
    private function getSingerSongList($url)
    {
        //获取歌手的id
        $sid = $this->getSingerId($url);

        //根据歌手id获取最大的页数
        $maxPages = $this->getSingerSongTotalPage($sid);

        $data = array();
        //遍历获取数据
        for($i = 1;$i<=$maxPages;$i++) {
            //请求接口
            $api = 'http://www.kuwo.cn/geci/wb/getJsonData?type=artSong&artistId='.$sid.'&page='.$i;
            //获取结果
            $res = $this->getHTML($api);
            //解析数据
            $d = json_decode($res, true);
            if(is_array($d['data'])){
            //
                $data = array_merge($data, $d['data']);
            }
        }
        return $data;
    }

    /**
     * 根据url获取歌手的id
     */
    private function getSingerId($url)
    {
        //根据url获取歌手的id
        preg_match('/a_(\d+)/is', $url, $t);
        //返回歌手的id
        return $t[1];
    }

    /**
     * 根据歌手的id获取歌曲的总的页数
     */
    private function getSingerSongTotalPage($sid)
    {
        //请求结果获取结果
        $api = 'http://www.kuwo.cn/geci/wb/getJsonData?type=artSong&artistId='.$sid.'&page=1';
        //获取结果
        $res = $this->getHTML($api);
        //解析结果
        $data = json_decode($res, true);
        //返回
        return $data['totalPage'];
    }

    /**
     * 根据rid获取歌词
     */
    private function getLyricByRid($rid)
    {
        //拼接url
        $url = 'http://www.kuwo.cn/geci/l_'.$rid;
        //获取源代码
        $html = $this->getHTML($url);
        //提取信息
        preg_match('/<h1>.*《(.*)》.*— (.*)<\/h1>.*<div id="lrc_yes" class="lrc">(.*)<\/div>/isU', $html, $tmp);
        //判断结果
        if($tmp){
            return [
                'name'=>$tmp[1],
                'singer'=>$tmp[2],
                'lyric'=>$tmp[3]
                ];
        }
    }

    /**
    * 将数据存入数据库
    */   
    private function insertDb($data)
    {
        //创建对象
        $Lyric = new Lyric;
        $Lyric -> name = $data['name']; 
        $Lyric -> singer = $data['singer']; 
        $Lyric -> lyric = $data['lyric'];
        $Lyric -> save(); 
    }

    /**
     * 获取源代码并且缓存
     */
    private function getHTML($url)
    {
        //获取
        $code = $this->c->get($url);
        //检测
        if($code == null){
            return $this->c->response;
        }
        return;
    }

}
