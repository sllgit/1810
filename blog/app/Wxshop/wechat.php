<?php

namespace App\Wxshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use DB;
class wechat extends Model
{
    /*
     * @content 回复信息
     * */
    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @param $content 回复信息的内容
     * @return string  返回文本的json数据包
     */
    public static function sendTextMessage($fromusername,$tousername,$content)
    {
        $time = time();
        $texttpl = "<xml>
                          <ToUserName><![CDATA[$fromusername]]></ToUserName>
                          <FromUserName><![CDATA[$tousername]]></FromUserName>
                          <CreateTime>$time</CreateTime>
                          <MsgType><![CDATA[text]]></MsgType>
                          <Content><![CDATA[$content]]></Content>
                        </xml>";
        return $texttpl;
    }
    /*
     * @content 图灵机器人
     * */
    /**
     * @param $keywords 关键字
     * @param $url url接口
     * @return mixed 返回获得的数据的内容
     */
    public static function rbot($keywords,$url)
    {
        $data = [
            'reqType'=>0,
            'perception'=>[
                'inputText'=>[
                    'text'=>$keywords,
                ],
            ],
            'userInfo'=>[
                'apiKey'=>'459c874157374cc48b1b3944357f7947',
                'userId'=>'tuling'
            ]
        ];
        $post_data = json_encode($data,JSON_UNESCAPED_UNICODE);
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        $data = json_decode($data,true);
        return $data['results'][0]['values']['text'];
    }
    /*
     * @content CURL post 请求
     * */
    /**
     * @param $url url接口
     * @param $post_data post数据
     * @return bool|mixed|string 返回获得的数据的内容
     */
    public static function HttpPost($url,$post_data)
    {
            //初始化
            $curl = curl_init();
            //dd($curl);
            //设置抓取的url
            curl_setopt($curl, CURLOPT_URL, $url);
            //设置头文件的信息作为数据流输出
            curl_setopt($curl, CURLOPT_HEADER, 0);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //忽略SSL证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            //执行命令
            $data = curl_exec($curl);
        //关闭URL请求
            curl_close($curl);
            //显示获得的数据
            $data = json_decode($data,true);
        return $data;

    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @return string 图片的模板
     */
    public static function sendImageMessage($fromusername,$tousername)
    {
        $res = DB::table('huifu')->where(['type'=>'image'])->orderBy('create_time','desc')->first();
        $media_id = $res->media_id;
        $time = time();
        $imagetpl ="<xml>
                      <ToUserName><![CDATA[$fromusername]]></ToUserName>
                      <FromUserName><![CDATA[$tousername]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[$media_id]]></MediaId>
                      </Image>
                    </xml>";
        echo $imagetpl;die;
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @return string 语音消息模板
     */
    public static function sendVoiceMessage($fromusername,$tousername)
    {
            $res = DB::table('huifu')->where(['type'=>'voice'])->orderBy('create_time','desc')->first();
            $media_id = $res->media_id;
        $time = time();
        $voicespl = "<xml>
                      <ToUserName><![CDATA[$fromusername]]></ToUserName>
                      <FromUserName><![CDATA[$tousername]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[voice]]></MsgType>
                      <Voice>
                        <MediaId><![CDATA[$media_id]]></MediaId>
                      </Voice>
                    </xml>";
        echo $voicespl;die;
    }

    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @return string 视频图文模板
     */
    public static function sendNewsMessage($fromusername,$tousername,$data)
    {
//        dump($data->title);
        $time = time();
        $item ="<item>
                   <Title><![CDATA[$data->title]]></Title>
                   <Description><![CDATA[$data->desc]]></Description>
                   <PicUrl><![CDATA[$data->url]]></PicUrl>
                   <Url><![CDATA[$data->returnurl]]></Url>
                 </item>";
        $newstpl = "<xml>
                      <ToUserName><![CDATA[$fromusername]]></ToUserName>
                      <FromUserName><![CDATA[$tousername]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[news]]></MsgType>
                      <ArticleCount>1</ArticleCount>
                      <Articles>
                        $item
                      </Articles>
                    </xml>";
        return $newstpl;
    }

    /**
     * @param $keywords 关键字
     * @return mixed 订单号
     */
    public static function getOrderNum($keywords)
    {
//        echo $keywords;
        $res = '/^订单(\\d+)$/';
        preg_match($res,$keywords,$re);
        return $re[1];
    }

    /**
     * @param $orderdetail 订单详情的数据
     * @return mixed 返回的模板需要的字段
     */
    public static function getTplColumn($orderdetail)
    {
        $data =DB::table('order as o')
            ->select('o.order_id','d.goods_id','o.order_no','d.goods_price','d.goods_name','d.buy_number','o.order_amount','o.pay_status')
            ->join('detail as d','d.order_id','=','o.order_id')
            ->where('o.order_status',1)
            ->get();
        foreach ($data as $k=>$v){
                if($orderdetail->order_id == $v->order_id){
                    $data = $v;
            }
        }
       return $data;
    }
    /**
     * @param $fromusername 发送人
     * @param $tousername 接收人
     * @param $data 订单的数据内容
     * @return  返回json数据包
     */
    public static function GetOrderMessage($fromusername,$tousername,$data)
    {
//        dd($data);
        $status =[
            '提交未支付',
            '已支付',
            '订单商品已发货',
            '已收货'
        ];
        $pay_status = $data->pay_status;
      $data = [
          'touser'=>"$fromusername",
           'template_id'=>'bqsV5OTYqGTgxlIztx_eQfgt1uGnp20SP2Yw1Sbc6k8',
           'url'=>"http://47.93.2.112/zhubao/detail/".$data->goods_id,
       'data' =>[
           'order_no'=>[
               'value'=>$data->order_no,
               "color"=>"blue"
           ],
           'goods_name'=>[
               'value'=>$data->goods_name,
               "color"=>"blue"
           ],
           'goods_price'=>[
               'value'=>$data->goods_price,
               "color"=>"blue"
           ],
           'buy_number'=>[
               'value'=>$data->buy_number,
               "color"=>"blue"
           ],
           'order_amount'=>[
               'value'=>$data->order_amount,
               "color"=>"blue"
           ],
           'pay_status'=>[
               'value'=>$status["$pay_status"],
               "color"=>"blue"
           ],
           ]
       ];
       $data = json_encode($data,JSON_UNESCAPED_UNICODE);
       $token = json_decode(self::GetAccessToken(),true)['access_token'];
       $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
       $re = self::HttpPost($url,$data);
       return $re;
    }

    /**
     * @cotent 获取access_token
     * @return false|string  返回token值
     */
    public static function GetAccessToken()
    {
        //获取token.txt的路径
       $fileName = public_path()."/token.txt";
        //获取文件的内容
        $str = file_get_contents($fileName);
        //获取token expire (过期时间)  存字符串
        $info = json_decode($str,true);
        $redis = cache('info');
        if($info['expire']<time() || !$redis){

            //过期了 需要重新生成
            $token = self::CreateAccessToken();
            $expire = time()+7000;
            $data = ['token'=>$token,'expire'=>$expire];
            $info = json_encode($data);
            //把token和repire过期时间存入文件中
            file_put_contents($fileName,$info);
            //把token和repire过期时间存入redis中
            cache(['info'=>$info],7000);
        }else{
            //没过期 拿出来
            $token = $info['token'];
        }
         return $token;
    }

    /**
     * @content 生成access_token
     * @return false|string 返回生成的access_token
     */
    static private function CreateAccessToken()
    {
        $appid = env('APPID');
        $appsecret = env('APPSECRET');
        $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        //可以发起个头请求的方式 ajax href src curl file_get_contents guzzle
        //把生成的access_token写入字符串中
        return file_get_contents($token_url);
    }

    /**
     * @content 文件上传
     * @param $file 文件的信息
     * @return array  返回文件类型和路径的数组
     */
    public static function UploadsFile($file)
    {
        //获取上传文件的后缀  image/jpg
        $ext = $file->getclientoriginalextension();
        //获取上传文件的类型
        $type = $file->getClientMimeType();
        //获取当前文件的位置
        $path = $file->getRealPath();
        //拼接新文件路径
        $newPath = "/wechat/".date("Ymd")."/".rand(10000,99999).".".$ext;
        //降临时文件移动到对应文件夹
        $re = Storage::disk('uploads')->put($newPath,file_get_contents($path));
//        dd($re);
        if($re){
            $data = [
                'ext'=>$type,
                'path'=>$newPath
            ];
            return $data;
        }else{
            echo "<script>alert('操作失败，请重试');location.href='/admin/add'</script>";die;
        }
    }

    /**
     * @content 获取素材所需要的类型
     * @param $ext 文件类型和路径的数组
     * @return mixed 返回文件的类型
     */
    public static function GetMaterialType($ext)
    {
      $info = explode('/',$ext);
      $type =$info[0];

//      dd($type);
      $arr_type = ['image','audio','video'];
      if(in_array($type,$arr_type)){
          $return_type =[
              'image'=>'image',
              'audio'=>'voice',
              'video'=>'video'
          ];
          return $return_type[$type];
      }else{
          echo "<script>alert('文件格式不允许，请重新上传');location.href='/admin/add'</script>";die;
      }
    }

    /**
     * @content 获取天气名称
     * @param $keywords 关键字
     * @return string 天气名称
     */
    public static function getCityName($keywords)
    {
        $data = explode('天气',$keywords);
        $city = empty($data[0])? '北京' : $data[0];
        return $city;
    }


    /**
     * @content 获取天气的消息
     * @param $fromusername 发送人
     * @param $cityname 城市名称
     * @return bool|false|mixed|string 天气的json数据包
     */
    public static function sendSkyMessage($fromusername,$cityname)
    {
        $url = "https://www.tianqiapi.com/api/?version=v1&city=$cityname";
        $re = file_get_contents($url);
        $data = json_decode($re,true);

        $date = [
            'touser'=>"$fromusername",
            'template_id'=>'MrektQ1RjviodNABQJH2nGX-sHuqH4TTXfT_Kw73uAU',
            'data' =>[
                'city'=>[//城市
                    'value'=>$data['city'],
                    "color"=>"blue"
                ],
                'date'=>[//日期
                    'value'=>$data['data']['0']['date'].' '.$data['data']['0']['week'],
                    "color"=>"blue"
                ],
                'wea'=>[//天气情况
                    'value'=>$data['data'][0]['wea'],
                    "color"=>"blue"
                ],
                'high'=>[//最高温度
                    'value'=>$data['data']['0']['tem1'],
                    "color"=>"blue"
                ],
                'low'=>[//最低温度
                    'value'=>$data['data']['0']['tem2'],
                    "color"=>"blue"
                ],
                'win'=>[//风向
                    'value'=>$data['data'][0]['win'][0].$data['data'][0]['win_speed'],
                    "color"=>"blue"
                ],
                'out'=>[//出行建议
                    'value'=>$data['data'][0]['air_tips'],
                    "color"=>"blue"
                ],
            ]
        ];
        $data = json_encode($date,JSON_UNESCAPED_UNICODE);
        $token = json_decode(self::GetAccessToken(),true)['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
        $re = self::HttpPost($url,$data);
//        dd($re);
        return $re;
    }

    /**
     * @content  获取群发消息的openid
     * @return mixed 返回openid
     */
    public static function GetOpenIDlist()
    {
        $token = cache('token_');
        if(!$token){
            $token = json_decode(self::GetAccessToken(),true)['access_token'];
            cache(['token_'=>$token],60*24);
        }
        $url="https://api.weixin.qq.com/cgi-bin/user/get?access_token=$token";
        $data = file_get_contents($url);
        $data = json_decode($data,true);
//dd($data);
        return $data['data']['openid'];
    }
}
