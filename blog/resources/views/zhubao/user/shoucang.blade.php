<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝收藏列表</title>
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
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>我的收藏</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="{{asset('images/head.jpg')}}" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">收藏栏共有：<strong class="orange">1</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">全部删除</a></td>
        </tr>
    </table>

    <div class="dingdanlist" onClick="window.location.href='/zhubao/detail'">
        <table>
            <tr>
                <td colspan="2" width="65%"></td>
                <td width="35%" align="right"><div class="qingqu"><a href="javascript:;" class="orange">取消收藏</a></div></td>
            </tr>
            <tr>
                <td class="dingimg" width="15%"><img src="{{asset('images/pro1.jpg')}}" /></td>
                <td width="50%">
                    <h3>三级分销农庄有机瓢瓜400g</h3>
                    <time>下单时间：2015-08-11  13:51</time>
                </td>
                <td align="right"><img src="{{asset('images/jian-new.png')}}" /></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">¥36.60</strong></th>
            </tr>
        </table>
    </div><!--dingdanlist/-->

    <div class="height1"></div>
    <div class="footNav">
        <dl>
            <a href="/zhubao">
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