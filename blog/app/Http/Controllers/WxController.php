<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wxshop\wechat;
use DB;
class WxController extends Controller
{
    /*
     * @content 判断是否接入成功 关注后调用回复
     * */
    public function wxshop(Request $request)
    {
        $echostr = $request->echostr;
        if(isset($echostr)){
            if($this->checkSigbature($request)){
                echo $echostr;
            }
        }else{
            $this->responseMsg();
        }

    }
    /*
     * @content 接收微信消息推送
     * */
    public function responseMsg()
    {
        //接收推送过来的信息
        $postStr = file_get_contents("php://input");

//        is_dir('logs') or mkdir('logs',0777,true);
//        file_put_contents('logs/wx.text',$postStr,FILE_APPEND);
        //处理xml
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
//        dd($postObj);
        $FromUserName = $postObj->FromUserName;
        $ToUserName = $postObj->ToUserName;
        $keywords = $postObj->Content;
        //判断是不是事件
        if($postObj->MsgType == 'event'){
            //判断是不是关注事件
            if($postObj->Event == 'subscribe') {
                $settype = config('wechat.responsetype');
            $res = DB::table('huifu')->where(['type'=>$settype])->orderBy('create_time','desc')->first();
//                dd($res);
            $type = ucfirst($res->type);
            $getMessage = 'send'.$type.'Message';
            switch ($settype)
            {
                case 'text':
                    $data = $res->content;
                    echo wechat::$getMessage($FromUserName,$ToUserName,$data);
                    break;
                case 'image':
                    $data = $res->media_id;
                    echo wechat::$getMessage($FromUserName,$ToUserName,$data);
                    break;
                case 'voice':
                    $data = $res->media_id;
                    echo wechat::$getMessage($FromUserName,$ToUserName,$data);
                    break;
                case 'news':
                    $data = $res;
                    echo wechat::$getMessage($FromUserName,$ToUserName,$data);
                    break;

            }
        }
        }
//        //自定义关键字回复
        if($keywords == '你好'){
            $content = "他好,你也好";
            echo wechat::sendTextMessage($FromUserName,$ToUserName,$content);
        }elseif ($keywords == '图片'){
            wechat::sendImageMessage($FromUserName,$ToUserName);
        }elseif ($keywords == '语音'){
            wechat::sendVoiceMessage($FromUserName,$ToUserName);
        }elseif (strstr($keywords,'订单')) {
            //获取订单号
            $order_no = wechat::getOrderNum($keywords);
            //根据订单id查询有没有此订单
            $orderdetail = DB::table('order')->where('order_no', $order_no)->first();
            if (empty($orderdetail)) {
                //没有
                $content = "请检查订单号是否正确啊 亲";
                echo wechat::sendTextMessage($FromUserName, $ToUserName, $content);
            } else {
                //有 获取模板所需要的字段
                $data = wechat::getTplColumn($orderdetail);
                wechat::GetOrderMessage($FromUserName, $ToUserName, $data);

            }
        }elseif (strstr($keywords,'天气')){
            //获取城市名称
            $cityname = wechat::getCityName($keywords);
            //根据天气名称查询天气
             wechat::sendSkyMessage($FromUserName,$cityname);
        }elseif($keywords == '登录'){
            $appid = env('APPID');
            $uri = urlencode("http://47.93.2.112/zhubao/wxlogin");
            $content = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=12345#wechat_redirect";
            echo wechat::sendTextMessage($FromUserName,$ToUserName,$content);
    }else{
            //没有该关键字则图灵机器人回复
            $url ="http://openapi.tuling123.com/openapi/api/v2";//接口地址
           $content = wechat::rbot($keywords,$url);
            echo wechat::sendTextMessage($FromUserName,$ToUserName,$content);

        }
    }

    /*
     * @content 处理微信第一次接入
     * @return 成功返回true 失败返回false
     * */
    public function checkSigbature(Request $request)
    {
        $signature = $request->signature;
        $nonce = $request->nonce;
        $timestamp = $request->timestamp;
        $token = env('TOKEN');
//        dd($token);
        $tmpArr  = array($token,$timestamp,$nonce);
        sort($tmpArr ,SORT_STRING);
        $tmpStr = implode($tmpArr );
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

}
