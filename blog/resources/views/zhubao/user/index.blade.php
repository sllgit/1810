<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝我的</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />

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
    <div class="userName">
        <dl class="names">
            <dt><img src="{{$data['headimgurl']}}" /></dt>
            <dd>
                @if($data=='')
                    <h4>还未登陆就来？滚去<a href="/zhubao/login">登陆</a></h4>
                @else
                    <h4>昵称：{{$data['nickname']}}</h4><br>
                    <h4>地址：{{$data['country']}}{{$data['province']}}{{$data['city']}}</h4>
                @endif
            </dd>
            <div class="clearfix"></div>
        </dl>
        <div class="shouyi">
            <dl>
                <dt>我的余额</dt>
                <dd>0.00元</dd>
            </dl>
            <dl>
                <dt>我的积分</dt>
                <dd>0</dd>
            </dl>
            <div class="clearfix"></div>
        </div><!--shouyi/-->
    </div><!--userName/-->

    <ul class="userNav">
        <li><span class="glyphicon glyphicon-list-alt"></span><a href="/zhubao/order">我的订单</a></li>
        <div class="height2"></div>
        <li><span class="glyphicon glyphicon-usd"></span><a href="/zhubao/quan">我的优惠券</a></li>
        <li><span class="glyphicon glyphicon-map-marker"></span><a href="/zhubao/addresslist">收货地址管理</a></li>
        <li><span class="glyphicon glyphicon-star-empty"></span><a href="/zhubao/shoucang">我的收藏</a></li>
        <li><span class="glyphicon glyphicon-heart"></span><a href="shoucang.html">我的浏览记录</a></li>
        <li><span class="glyphicon glyphicon-usd"></span><a href="/zhubao/tixian">余额提现</a></li>
    </ul><!--userNav/-->

    <div class="lrSub">
        <a href="/zhubao/editlogin">退出登录</a>
    </div>

    <div class="height1"></div>
    @include('zhubao.public.footer')
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