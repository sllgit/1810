<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝订单</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('layui/layui.js')}}"></script>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/response.css')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>我的订单</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="{{asset('images/head.jpg')}}" />
    </div><!--head-top/-->

    <div class="zhaieq oredereq">
        <a href="javascript:;" class="zhaiCur">待付款</a>
        <a href="javascript:;">待发货</a>
        <a href="javascript:;">已取消</a>
        <a href="javascript:;" style="background:none;">已完成</a>
        <div class="clearfix"></div>
    </div><!--oredereq/-->
    @foreach($data as $K=>$v)
    <div class="dingdanlist">
        <table>
                <tr>
                    <td colspan="2" width="65%">订单号：<strong>{{$v->order_no}}</strong></td>
                    <td width="35%" align="right"><div class="qingqu"><a href="javascript:;" class="orange del">订单取消</a></div></td>
                </tr>
            <tr>
                <td class="dingimg" width="15%"><img src="http://uploads.com/{{$v->goods_img}}" /></td>
                <td width="50%">
                    <h3>{{$v->goods_name}}</h3>
                    <time>下单时间：2015-08-11  13:51{{date("Y-m-d h:i;s",$v->create_time)}}</time>
                </td>
                <td align="right"><img src="{{asset('images/jian-new.png')}}" /></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">¥{{$v->goods_price}}</strong></th>
            </tr>
        </table>
    </div><!--dingdanlist/-->
    @endforeach
    <div class="height1"></div>
    <div class="footNav">
        <dl>
            <a href="/">
                <dt><span class="glyphicon glyphicon-home"></span></dt>
                <dd>微店</dd>
            </a>
        </dl>
        <dl>
            <a href="/zhubao/allshop">
                <dt><span class="glyphicon glyphicon-th"></span></dt>
                <dd>所有商品</dd>
            </a>
        </dl>
        <dl>
            <a href="/zhubao/car">
                <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
                <dd>购物车 </dd>
            </a>
        </dl>
        <dl>
            <a href="/zhubao/user">
                <dt><span class="glyphicon glyphicon-user"></span></dt>
                <dd>我的</dd>
            </a>
        </dl>
        <div class="clearfix"></div>
    </div><!--footNav/-->
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/style.js')}}"></script>
<!--jq加减-->
<script src="{{asset('js/jquery.spinner.js')}}"></script>
<script>
    $('.spinnerExample').spinner({});
</script>
</body>
</html>
<script>
    $(function () {
        layui.use('layer',function () {
            var layer=layui.layer;
            $('.del').click(function () {
               var order_no = $(this).parents('td').prev('td').children('strong').text();
               $.post(
                   "/zhubao/delorder/"+order_no,
                   function (res) {
                       if(res.code==6){
                           layer.msg(res.msg,{icon:res.code},function(){
                               location.href="/zhubao/order";
                           });
                       }else{
                           layer.msg(res.msg,{icon:res.code});
                       }
                   }
               )
            })
        })
    })
</script>