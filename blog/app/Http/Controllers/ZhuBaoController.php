<?php

namespace App\Http\Controllers;

use App\Model\User;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use Mail;
use \Log;
use Illuminate\Support\Facades\Redis;
class ZhuBaoController extends Controller
{
    //微店 注册
    public function register()
    {
        if(\request()->Post()){
            $data = \request()->all();
//            dd($data);
            $type = \request()->type;
            if($type==1){
                //验证码与手机号
                $tel = \request()->session()->get('tel');
                if($data['tel']!=$tel['tel']||$data['code']!=$tel['code']){
                    return ['msg'=>'验证码或手机号不正确','code'=>5];die;
                }else{
                    \request()->session()->forget('tel');
                }
            }else{
                //验证码与邮箱
                $email = \request()->session()->get('email');
                if($data['tel']!=$email['email']||$data['code']!=$email['code']){
                    return ['msg'=>'验证码或邮箱不正确','code'=>5];die;
                }else{
                    \request()->session()->forget('email');
                    $data['email']=$data['tel'];
                    unset($data['tel']);
                }
            }

            //密码与确认密码
            if($data['password']!==$data['repassword']){
                return ['msg'=>'确认密码与密码不一致','code'=>5];die;
            }else{
                $data['password']=encrypt($data['password']);
            }
            unset($data['repassword'],$data['type']);
//            dd($data);
            $res = DB::table('user')->insert($data);
            if($res){
                return ['msg'=>'注册成功','code'=>6];
            }else{
                return ['msg'=>'注册失败','code'=>5];
            }
//            dd($res);
        }else{
            return view('zhubao.login.register');
        }
    }
    //短信发送获取验证码
    public function telgetcode(){
        $tel = \request()->tel;
        $host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "61f7ac94b3ba42c58641a53f06c33c67";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $rand = rand(100000,999999);
        $querys = "mobile=".$tel."&param=code%3A".$rand."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
//        dd($url);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
//        var_dump(curl_exec($curl));
        $data = json_decode(curl_exec($curl),true);
        if($data['return_code']==00000){
            \request()->session()->put('tel',['tel'=>$tel,'code'=>$rand]);
            return ['msg'=>'发送成功','code'=>6];
        }else{
            return ['msg'=>'发送失败','code'=>5];
        }
    }
    //邮箱发送获取验证码
    public function emailgetcode(){
        $tel = \request()->tel;
        $rand=rand(100000,999999);
        if($tel){
            Mail::send('zhubao.login.emailcode',['code'=>$rand],function($message)use($tel) {
                //设置主题
                $message->subject("邮箱注册验证码");
                //设置接收方
                $message->to($tel);
            });
            $data=['email'=>$tel,'code'=>$rand];
            \request()->session()->put('email',$data);
            return ['msg'=>'邮箱注册成功','code'=>6];
        }else{
            return ['msg'=>'请选择一个邮箱注册','code'=>5];
        }


    }
    //微店 登录
    public function login()
    {
        if(\request()->Post()){
            $tel_email = \request()->tel_email;
            $password = \request()->password;
            if($tel_email==''&&$password==''){
                echo "<script>alert('必填项不能为空');location.href='/zhubao/login'</script>";die;
            }
            $where1=[
                'tel'=>$tel_email
            ];
            $where2=[
                'email'=>$tel_email
            ];
            $res=DB::table('user')->where($where1)->orWhere($where2)->first();
//            dd($res);
            if(!$res){
                echo "<script>alert('此账号还未注册，请注册再重新登录');</script>";
            }else{
                if($password==decrypt($res->password)){
                    $user=[
                        'name'=>$tel_email,
                        'user_id'=>$res->id
                    ];
                    \request()->session()->put('user',$user);
                    echo "<script>alert('登录成功');location.href='/zhubao/'</script>";
                }else{
                    echo "<script>alert('登录失败');location.href='/zhubao/login'</script>";
                }
            }
        }else{
            return view('zhubao.login.login');
        }
    }

    public function getcode(){
        //1.用户同意授权，获取code
        $appid = env('APPID');
        $uri = urlencode("http://47.93.2.112/zhubao/wxlogin");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=12345#wechat_redirect";
        //跳转到回调地址的方法里
        header('location:'.$url);
    }

    /**
     * @content 微信授权登录
     */
    public function wxlogin()    {
        $code = \request()->code;
        $appid = env('APPID');
        $secret = env('APPSECRET');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $re = file_get_contents($url);
        $token = json_decode($re,true)['access_token'];
        $openid = json_decode($re,true)['openid'];
        $user_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $user_re = file_get_contents($user_url);
        $data = json_decode($user_re,true);
        $userinfo = User::where('openid',$openid)->first();
        if(empty($userinfo)){
            $data = serialize($data);
            return view('admin/binding',compact('data'));
        }else{
           return redirect('/');
        }


    }
    /**
     * @content 执行授权登录
     */
    public function bindingdo()
    {
        $name = \request()->name;
        $user = \request()->user;
        $info =unserialize($user);
        $where1=[
            'tel'=>$name
        ];
        $where2=[
            'email'=>$name
        ];
        $userinfo = User::where($where1)->orWhere($where2)->first();
        if(empty($userinfo)){
            echo "<script>alert('无此用户，请先注册');location.href='/zhubao/register'</script>";
        }else{
            $data = [
                'openid'=>$info['openid'],
                'nickname'=>$info['nickname'],
                'headimgurl'=>$info['headimgurl'],
                'address'=>$info['country'].$info['province'].$info['city']
            ];
            $res = User::where($where1)->orWhere($where2)->update($data);
            if($res){
                $info['user_id']=$userinfo->user_id;
                \request()->session()->put('user',$info);
                echo "<script>alert('绑定成功');location.href='/'</script>";
            }else{
                echo "<script>alert('绑定失败');location.href='/zhubao/getcode'</script>";
            }
        }

    }

    //微店
    public function index()
    {
        //获取session值
        $data=request()->session()->get('user');
        if(!$data){
           return redirect('/zhubao/register');
        }
        //获取分类数据
        $date = DB::table('fenlei')->where('pid',0)->get();
        //获取热卖商品数据
        $host = DB::table('goods')->where('goods_hots',1)->get();
        //获取精品商品数据
        $best = DB::table('goods')->where('goods_best',1)->get();
        //获取所有商品图片
        $img = DB::table('goods')->select('goods_id','goods_img')->get();
        //获取所有商品个数
        $count = DB::table('goods')->where('goods_up',1)->count();
//        dd($img);
        return view('zhubao.index.index',compact('data','date','host','best','img','count'));
    }
    //微店详情
    public function detail($id)
        {
//            Redis::set('name','zhangsan');
//            dd(Redis::get('name'));
            //缓存取数据
            $data = cache('data_'.$id);
            if(!$data){
                $data = DB::table('goods')->where('goods_id',$id)->first();
                cache(['data_'.$id=>$data],60*24);
            }
            $imgs = $data->goods_imgs;
           $goods_imgs=explode('|',rtrim($imgs,'|'));
            return view('zhubao.index.detail',compact('data','goods_imgs'));
        }
    //所有商品
    public function allshop($id=0){
        $goods_name = \request()->goods_name ?? '';
        $res = cache('res_'.$id);
        if(!$res){
            if($id!=0){
//                dump($goods_name);
                $where=[
                    ['goods_name','like',"%$goods_name%"],
                ];

                //查询所有商品
                $data = DB::table('fenlei')->get()->toArray();
                //查询传来id的子类
                $date = $this->getson($data,$id);
                //获取子类的id
                $fenlei_id=array_column($date,'fenlei_id');
//                    dd($fenlei_id);
                //根据id查商品
                if($goods_name==''){
                    $res = DB::table('goods')->whereBetween('fenlei_id',$fenlei_id)->get();
                }else{
                    $res = DB::table('goods')->whereBetween('fenlei_id',$fenlei_id)->where($where)->get();
                }

//            dump($res);
            }else{
                if($goods_name==''){
                    $where=[
                        'goods_up'=>1
                    ];
                }else{
                    $where=[
                        ['goods_name','like',"%$goods_name%"],
                        ['goods_up',1]
                    ];
                }
                $res = DB::table('goods')->where($where)->get();
            }
            cache(['res_'.$id=>$res],60*24);
        }

        return view('zhubao.allshop.index',compact('res','id'));
    }
    //所有商品+条件
    public function allshops(){
        $type=request()->input();
        dd($type);
        $feilei_id=$type['feilei_id'];
        $data=DB::table('fenlei')->get()->toArray();
        $data=$this->getson($data,$feilei_id);
        $fenlei_id=array_column($data,'fenlei_id');

        if($type['type']==1){
            if($feilei_id!=0) {
                $data = DB::table('goods')->whereBetween('fenlei_id', $fenlei_id)->get()->toArray();
            }else{
                $data = DB::table('goods')->where('goods_new',1)->get()->toArray();
            }
            return view('zhubao.allshop/div',compact('data'));
        }else if($type['type']==2){
            if($feilei_id!=0){
                $data = DB::table('goods')->whereBetween('fenlei_id',$fenlei_id)->orderBy('goods_num','desc')->get();
            }else{
                $data = DB::table('goods')->orderBy('goods_num','desc')->get();
            }
            return view('zhubao.allshop/div',compact('data'));
        }else if($type['type']==3){
            if($feilei_id!=0) {
                $data = DB::table('goods')->whereBetween('fenlei_id', $fenlei_id)->orderBy('goods_price', 'desc')->get();
            }else{
                $data = DB::table('goods')->orderBy('goods_price', 'desc')->get();
            }
            return view('zhubao.allshop/div',compact('data'));
        }

    }
    //获取总价格
    public function getallprice(){
        $goods_id = \request()->goods_id;
        if($goods_id==''){
            return 0;
        }
        if(strpos($goods_id,',')==false){
            $allprice = DB::table('goods as g')
                ->join('cart as c', 'c.goods_id', '=', 'g.goods_id')
                ->get()
                ->toArray();
            foreach ($allprice as $k => $v) {
                if($v->goods_id==$goods_id){
                    $price=$v->goods_price*$v->buy_number;
                }
            }
        }else{
            $goods_id = explode(',',$goods_id);
            $allprice = DB::table('goods as g')
                ->select('g.goods_price', 'c.buy_number','g.goods_id')
                ->join('cart as c', 'c.goods_id', '=', 'g.goods_id')
                ->get()
                ->toArray();
            $price = 0;
            foreach ($allprice as $k => $v) {
                foreach ($goods_id as $key => $val) {
                    if ($v->goods_id == $val) {
                        $price += $v->goods_price * $v->buy_number;
                    }
                }
            }
        }
        return $price;
    }
    //无限极分类查子数据
    public function getson($data,$pid){
        static $son=[];
        foreach ($data as $k=>$v){
            if(($v->pid)==$pid){
                $son[]=$v;
                $this->getson($data,$v->fenlei_id);
            }
        }
        return $son;
    }
    //购物车
    public function car(){
        $user = \request()->session()->get('user');
        if(!$user){
            echo "<script>alert('请先登录');location.href='/zhubao/login'</script>";
        }
            $data = DB::table('cart')
                ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->where(['cart_status'=>1,'user_id'=>$user['user_id']])
                ->get();
            $count = DB::table('cart')
                ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
                ->where(['cart_status'=>1,'user_id'=>$user['user_id']])
                ->count();
        return view('zhubao.car.index',compact('data','count'));
    }
    //加入购物车
    public function addcar($id){
        $data = \request()->all();
//        dd($data);
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        $data['user_id']=$user['user_id'];
        $where=[
            'user_id'=>$user['user_id'],
            'goods_id'=>$data['goods_id'],
            'goods_guige'=>$data['goods_guige'],
            'cart_status'=>1
        ];
        //查询数据库中是否有该条数据
        $date = DB::table('cart')->where($where)->first();
//        dd($date);
        $allnum=DB::table('goods')->where(['goods_id'=>$id])->value('goods_num');//库存
        if($date){//有责购买数量递增
            //判断是否超过库存
//            $this->getcount($id,$data['buy_number'],$date->buy_number);//id  购买的  已有的
            $buy_number = $data['buy_number']+$date->buy_number;
            if($buy_number > $allnum){
                $pop=($allnum) - ($date->buy_number);
                return ['msg'=>"你购买的商品数量已超过库存，最多还可以购买 $pop 件",'code'=>5];die;
            }else {
                $res = DB::table('cart')->where($where)->update(['buy_number'=>$buy_number]);            }
        }else{
            if($data['buy_number'] > $allnum){
                return ['msg'=>"你购买的商品数量已超过库存，最多还可以购买 $allnum 件",'code'=>5];die;
            }else {
                $data['create_time'] = time();
                $res = DB::table('cart')->insert($data);
            }
        }
        if($res){
            return ['msg'=>'加入购物车成功','code'=>6];
        }else{
            return ['msg'=>'加入购物车失败','code'=>5];
        }
    }
    //删除购物车
    public function delcart(){
        $goods_id = \request()->goods_id;
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        $id = strpos($goods_id,',');
        if($id==false){
            $res = DB::table('cart')->where('goods_id',$goods_id)->update(['cart_status'=>2]);
        }else{
            $goods_id = explode(',',$goods_id);
            $res = DB::table('cart')->whereIn('goods_id',$goods_id)->update(['cart_status'=>2]);
        }
        if($res){
            return ['msg'=>'删除成功','code'=>6];
        }else{
            return ['msg'=>'删除失败','code'=>5];
        }
    }
    //结算
    public function pay($id){
        $user=request()->session()->get('user');
        if($user==''){
            echo "<script>alert('请先登录');location.href='/zhubao/login'</script>>";
        }
        $address = DB::table('address')->where('user_id',$user['user_id'])->get()->toArray();
//        dd($address);
        if(!$address){
//            dd(111);
            echo "<script>alert('请添加收货地址');location.href='/zhubao/address/$id'</script>";
        }
        $goods_id=explode(',',$id);
        $data=DB::table('goods')->whereIn('goods_id',$goods_id)->get()->toArray();
        //如果没找到则提示没有商品信息
        if($data==''){
            echo "<script>alert('暂无商品信息');location.href='/zhubao/car'</script>>";
        }
        //查询购物车的相应商品的购买数量
        $cart=DB::table('cart')->whereIn('goods_id',$goods_id)->get()->toArray();
        $allprice=0;
        foreach($data as $k => $v){
            foreach($cart as $key=>$val){
                if($v->goods_id == $val->goods_id){
                    $data[$k]->buy_number=$val->buy_number;
                    $allprice+=$data[$k]->buy_number * $v->goods_price;
                }
            }
        }
        //默认收货人
        $address = DB::table('address')->where('is_result',1)->get()->toArray();
//        dd($address);
        if(!$address){
            $address_id = DB::table('address')->select('address_id')->where('user_id',$user['user_id'])->orderBy('address_id','desc')->first();
            $data =DB::table('address')->where('address_id',$address_id->address_id)->update(['is_result'=>1]);
            $address = DB::table('address')->where('is_result',1)->get()->toArray();
        }
            foreach ($address as $k=> $v){
                $v->province=DB::table('area')->where('id',$v->province)->value('name');
                $v->city= DB::table('area')->where('id',$v->city)->value('name');
                $v->area=DB::table('area')->where('id',$v->area)->value('name');

        }

//        dd($address);
        return view('zhubao.car.pay',compact('data','allprice','address'));
    }
    //提交订单
    public function paydo(){
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        DB::beginTransaction();
        try {
            //加入订单表
            $user = \request()->session()->get('user');
            $data['user_id'] = $user['user_id'];//用户id
            $data['order_no']=time().rand(10000,99999);//订单号
            $data['order_amount'] = \request()->allprice;//总价格
            $data['create_time']=time();//添加时间
            $res1 = DB::table('order')->insert($data);
            if($res1 ==false){
                  throw new \Exception('加入订单表失败');
            }
            //订单收货地址表
            $order_id=DB::getPdo()->lastInsertId();//订单id
            $order_address = DB::table('address')->select('address_name','address_tel','address_detail','address_mail','province','city','area')->where('is_result',1)->first();
            $order_address->order_id =$order_id;
            $order_address->user_id = $user['user_id'];//用户id
            $order_address->create_time = time();//添加时间
            $order_address = json_decode(json_encode($order_address),true);
            $res2 = DB::table('orderaddress')->insert($order_address);
            if($res2 ==false){
                throw new \Exception('加入订单收货地址表失败');
            }
            //加入商品详情表
            $goods_id = explode(',',\request()->goods_id);
            $data = DB::table('cart')
                ->select('buy_number','goods.goods_id','goods_price','goods_name','goods_img')
                ->join('goods','cart.goods_id','=','goods.goods_id')
                ->get();
            $date=[];
            foreach ($data as $k=>$v){
                foreach ($goods_id as $key=>$val){
                    if($v->goods_id == $val){
                        $v->order_id=$order_id;
                        $v->create_time=time();
                        $v->user_id=$user['user_id'];
                        $date[]=$v;
                    }
                }
            }
            $date = json_decode(json_encode($date),true);
           $res3 = DB::table('detail')->insert($date);
            if($res3 ==false){
                throw new \Exception('加入商品详情表失败');
            }
            //减少商品对应库存
            $data2 = DB::table('cart')
                ->select('cart.buy_number','goods.goods_num','cart.goods_id')
                ->join('goods','cart.goods_id','=','goods.goods_id')
                ->where(['cart_status'=>1,'user_id'=>$user['user_id']])
                ->get();
            foreach($data2 as $k=>$v){
                foreach ($goods_id as $key=>$val){
                    if($v->goods_id == $val){
                        $v->goods_num = $v->goods_num - $v->buy_number;
                        $res = DB::table('goods')->where('goods_id',$val)->update(['goods_num'=>$v->goods_num]);
                    }
                }
            }
            if($res ==0){
                throw new \Exception('减少库存失败');
            }
//            删除购物车相应数据
            $id= \request()->goods_id;
//            dd(strpos($goods_id,','));
            if(strpos($id,',') == false){
                $res4 = DB::table('cart')->where('goods_id',$id)->update(['cart_status'=>2]);
            }else{
                $res4 = DB::table('cart')->whereIn('goods_id',$goods_id)->update(['cart_status'=>2]);
            }
            if($res4 ==0){
                throw new \Exception('删除购物车数据失败');
            }
            DB::commit();
            request()->session()->put('order',['order_id'=>$order_id,'allprice'=>\request()->allprice]);
            return ['msg'=>'提交订单成功','code'=>6];
        } catch (\Exception $e) {
            DB::rollback();
            $message = report($e);
            return ['msg'=>$e->getMessage(),'code'=>5];
        };
    }
    //去支付
    public function gopay($id){
        //总价格
        $allprice = DB::table('order')->where('order_no',$id)->value('order_amount');

        if(!$allprice){
            echo "<script>alert('没有此订单信息');location.href='/zhubao/car'</script>";die;
        }
        if($allprice<=0){
            echo "<script>alert('此订单无效');location.href='/zhubao/car'</script>";die;
        }
//        require_once app_path(dirname(__FILE__)).'/config.php';
        require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');
        require_once app_path('libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no =$id;

        //订单名称，必填
        $subject = '1810支付测试';

        //付款金额，必填
        $total_amount = $allprice;

        //商品描述，可空
        $body = '';

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService(config('alipay'));

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));
//        dd($response);
        //输出表单
        var_dump($response);

    }
    //同步跳转
    public function treturn(){
        $arr=$_GET;
        $out_trade_no = trim($_GET['out_trade_no']);//订单号
        $total_amount = trim($_GET['total_amount']);//订单金额
        require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');
        $alipaySevice = new \AlipayTradeService(config('alipay'));
        $result = $alipaySevice->check($arr);

        $data=DB::table('order')->where(['order_no'=>$out_trade_no,'order_amount'=>$total_amount])->first();
        if(!$data){
            echo "<script>alert('付款错误，此订单不存在');location.href='/zhubao/paydo'</script>";
        }
        if(trim($_GET['seller_id']) !=config('alipay.seller_id') || trim($_GET['app_id']) != config('alipay.app_id')){
            echo "<script>alert('付款错误，商家或买家错误');location.href='/zhubao/paydo'</script>";
        }
        Log::channel('alipayreturn')->info("//验证成功<br />支付宝交易号：".$out_trade_no);
        return redirect('/zhubao/car');
    }
    //异步跳转
    public function notify(){
        require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');
        $arr=$_POST;
//        dd($arr);
        $alipaySevice = new \AlipayTradeService(config('alipay'));
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);

    }
    //新增收货地址
    public function address($id=0){
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        if(\request()->Post()){
            $id=\request()->id;
            $data=$this->getcityinfo($id);
            $data=$data->toJson();
            return $data;
        }else{
            $city=DB::table('area')->where('pid',0)->get();
            return view('zhubao.car.address',compact('city','id'));
        }

    }
    //新增地址执行
    public function addaddress(){
        $user=request()->session()->get('user');
        $id=request()->id;
        $data=request()->except('id');
        $data['user_id']=$user['user_id'];
        $data['create_time']=time();
        if($data['is_result']==1){
            $res=DB::table('address')->update(['is_result'=>2]);
        }
        $res=DB::table('address')->insert($data);
        if($res){
            return ['msg'=>'新增成功','code'=>6,'id'=>$id];
        }else{
            return ['msg'=>'新增失败','code'=>5];
        }
    }
    //三级联动地址
    public function getcityinfo($id){
        $data=DB::table('area')->where('pid',$id)->get();
        return $data;
    }
    //收货地址列表
    public function addresslist(){
        $user = \request()->session()->get('user');
        if(!$user){
           echo "<script>alert('请先登录');location.href='/zhubao/login'</script>";
        }
        $data = DB::table('address')->where(['address_status'=>1,'user_id'=>$user['user_id']])->get();
        //获取市区县id对应的名字
        foreach ($data as $k=> $v){
            $v->province=DB::table('area')->where('id',$v->province)->value('name');
            $v->city= DB::table('area')->where('id',$v->city)->value('name');
            $v->area=DB::table('area')->where('id',$v->area)->value('name');
        }
//        dd($data);
        return view('zhubao.user.addresslist',compact('data'));
    }
    //修改收货地址
    public function updaddress($id){
        $user = \request()->session()->get('user');
        if(!$user){
            echo "<script>alert('请先登录');location.href='/zhubao/login'</script>";
        }
        $data = DB::table('address')->where('address_id',$id)->first();
        //获取所有省
        $province=DB::table('area')->where('pid',0)->get();
        //获取所有市
        $city=$this->getcityinfo($data->province);
        //获取所有区
        $area=$this->getcityinfo($data->city);
//        dd($area);
        return view('zhubao.user.updaddress',compact('city','province','area','data'));
    }
    //执行修改地址
    public function upddoaddress(){
        $data = \request()->all();
        if($data['is_result']==1){
            $res=DB::table('address')->update(['is_result'=>2]);
        }
        $res = DB::table('address')->where('address_id',$data['address_id'])->update($data);
        if($res){
            return ['msg'=>'修改成功','code'=>6];
        }else{
            return ['msg'=>'修改失败','code'=>5];
        }
    }
    //删除地址
    public function deladdress($id){
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        $res = DB::table('address')->where('address_id',$id)->update(['address_status'=>2]);
        if($res){
            return ['msg'=>'删除成功','code'=>6];
        }else{
            return ['msg'=>'删除失败','code'=>5];
        }
    }
    //提交订单
    public function success(){
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];
        }
        $order = request()->session()->get('order');
        $order_id = $order['order_id'];
        $allprice = $order['allprice'];
        $data = DB::table('order')->where('order_id',$order_id)->first();
//        dd($data);
        return view('zhubao.car.success',compact('data','allprice'));
    }
    //我的
    public function user()
    {
        //获取session值
        $data=request()->session()->get('user');
        return view('zhubao.user.index',compact('data'));
    }
    //我的订单
    public function order(){
        $user = \request()->session()->get('user');
        if(!$user){
            echo "<script>alert('请先登录');location.href='/zhubao/login'</script>";
        }
        //查询订单信息
        $data = DB::table('order')
            ->select('detail.order_id','goods_name','goods_price','goods_img','order.create_time','order.order_no')
            ->join('detail','order.order_id','=','detail.order_id')
            ->where(['order.status'=>1,'order.user_id'=>$user['user_id']])
            ->get();
        return view('zhubao.user.order',compact('data'));
    }
    //取消订单
    public function delorder($id){
        $user = \request()->session()->get('user');
        if(!$user){
            return ['msg'=>'请先登录','code'=>4];die;
        }
        $data1 = DB::table('order')->where('order_no',$id)->update(['status'=>2]);
        $order_id = DB::table('order')->where(['order_no'=>$id,'user_id'=>$user['user_id']])->value('order_id');
        $data2 = DB::table('detail')->where(['order_id'=>$order_id,'user_id'=>$user['user_id']])->update(['status'=>2]);
        if($data1!=0 && $data2!=0){
            return ['msg'=>'取消成功','code'=>6];
        }else{
            return ['msg'=>'取消失败','code'=>5];
        }
    }
    //我的优惠券
    public function quan(){
        return view('zhubao.user.quan');
    }
    //我的收藏
    public function shoucang(){
        return view('zhubao.user.shoucang');
    }
    //我的提现
    public function tixian(){
        return view('zhubao.user.tixian');
    }
    //退出登录
    public function editlogin(){
        \request()->session()->forget('user');
        echo "<script>alert('退出成功');location.href='/zhubao/login'</script>";
    }

//    public function text(){
//        \request()->session()->put('user',['tel'=>12345,'code'=>123445]);
//        dd(\request()->session()->get('user'));
//    }

    //测试列表
    public function lists(){
        $request = request()->all();
        $where=[];
       $goods_name = $_GET['goods_name'] ?? '';
       if($goods_name){
           $where[]=['goods_name','like',"%$goods_name%"];
       }
        $goods_desc = $_GET['goods_desc'] ?? '';
        if($goods_desc){
            $where[]=['goods_desc','like',"%$goods_desc%"];
        }
      $data = DB::table('goods')->where($where)->paginate(1);
    return view('text.lists',compact('data','request'));
}
    //详情
    public function details($id){
        $data = cache('data_'.$id);
        if(!$data){
            echo 11;
            $data = DB::table('goods')->where(['goods_id'=>$id])->first();
            cache(['data_'.$id => $data],60);
        }
        return view('text.details',compact('data'));
}
    //删除
    public function del($id){
            $data = DB::table('goods')->where(['goods_id'=>$id])->delete();
            if($data){
                cache(['data_'.$id=>''],1);
                echo "<script>alert('删除成功');location.href='/list'</script>";die;
            }else{
                echo "<script>alert('删除失败');location.href='/list'</script>";die;
            }
    }
    //修改
    public function upd($id){
        $data = cache('data_'.$id);
        if(!$data){
            echo 11;
            $data = DB::table('goods')->where('goods_id',$id)->first();
        }
        return view('text.upd',compact('data'));
    }
    //修改执行
    public function upddo(){
        $data = \request()->except('_token');
        if(request()->hasFile('goods_img')){
            $data['goods_img'] = $this->uploads(request(),'goods_img');
        }else{
            $data['goods_img']=$data['img'];
        }
        unset($data['img']);
        dd($data);
        $data = DB::table('goods')->where(['goods_id'=>$data['goods_id']])->update($data);
        if($data){
            cache(['data_'.$data['goods_id']=>$data],60);
            echo "<script>alert('修改成功');location.href='list'</script>";
        }else{
            echo "<script>alert('修改失败');location.href='/upd'</script>";
        }
    }
    //文件上传
    public function uploads(Request $request,$name){
        if ($request->file($name)->isValid()) {
            $photo = $request->file($name);
            $extension = $photo->extension();
            //$store_result = $photo->store('photo');
            $store_result = $photo->storeAs(date("Ymd"),date("YmdHis").rand(100,999).'.'.$extension);
            return $store_result;
        }
    }

    public function wxshop()
    {
        echo 1112;
    }
}
