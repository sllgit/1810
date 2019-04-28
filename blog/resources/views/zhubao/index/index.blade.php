<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝商城</title>
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
    <div class="head-top">
        <img src="{{asset('images/head.jpg')}}" />
        <dl>
            <dt><a href="user.html"><img src="{{asset('images/touxiang.jpg')}}" /></a></dt>
            <dd>
                @if($user=='')
                <h1 class="username">还没登陆就来？滚去<a href="/zhubao/login" style="color:red;">登陆</a></h1>
                @else
                    <h1 class="username">欢迎 <a href="/zhubao/user" style="color:red;">{{$user['name']}}</a>登陆</h1>
                @endif
                <ul>
                    <li><a href="/zhubao/allshop"><strong>{{$count}}</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="/zhubao/allshop" method="get" class="search">
        <input type="text" name="goods_name" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    @if($user=='')
    <ul class="reg-login-click">
        <li><a href="/zhubao/login">登录</a></li>
        <li><a href="/zhubao/register" class="rlbg">注册</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
    @else
    @endif
    <div id="sliderA" class="slider">
        @foreach($img as $k => $v)
            <img src="http://uploads.com/{{$v->goods_img}}" class="img"  goods_id="{{$v->goods_id}}"/>
        @endforeach

    </div><!--sliderA/-->
    <ul class="pronav">
        {{--分类pid=0--}}
        @foreach($data as $k=>$v)
        <li><a href="/zhubao/allshop/{{$v->fenlei_id}}">{{$v->fenlei_name}}</a></li>
        @endforeach
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($host as $k=>$v)
        <div class="index-pro1-list">
            <dl>
                <dt><a href="/zhubao/detail/{{$v->goods_id}}"><img src="http://uploads.com/{{$v->goods_img}}" /></a></dt>
                <dd class="ip-text"><a href="/zhubao/detail">{{$v->goods_name}}</a></dd>
                <dd class="ip-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_markprice}}</span></dd>
            </dl>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="prolist">
        @foreach($best as $k=>$v)
        <dl>
            <dt><a href="/zhubao/detail/{{$v->goods_id}}"><img src="http://uploads.com/{{$v->goods_img}}" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="/zhubao/detail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
                <div class="prolist-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_markprice}}</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
       @endforeach
    </div><!--prolist/-->
    <div class="joins"><a href="fenxiao.html"><img src="{{asset('images/jrwm.jpg')}}" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

    <div class="height1"></div>
    @include('zhubao.public.footer')
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/style.js')}}"></script>
<!--焦点轮换-->
<script src="{{asset('js/jquery.excoloSlider.js')}}"></script>
<script>
    $(function () {
        $("#sliderA").excoloSlider();
    });
</script>
</body>
</html>
<script>
    $('.img').click(function () {
        var id=$(this).attr('goods_id');
        location.href="/zhubao/detail/"+id;
    })
</script>