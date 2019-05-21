<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝收货地址列表</title>
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
            <h1>收货地址</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="{{asset('images/head.jpg')}}" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><a href="/zhubao/address" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
            <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"></td>
        </tr>
    </table>

    <div class="dingdanlist">
        <table>
        @foreach($data as $k => $v)
            @if($v->is_result == 1)
                    <tr style="color:red;">
                        <td width="50%">
                            <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
                            <time  style="color:red;">{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</time>
                        </td>
                        <td align="right"><a href="javascript:;" class="del" class="hui">删除信息</a><a href="/zhubao/updaddress/{{$v->address_id}}" class="hui xiu" aid="{{$v->address_id}}"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
                    </tr>
            @else

            <tr>
                <td width="50%">
                    <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
                    <time>{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</time>
                </td>
                <td align="right"><a href="javascript:;" class="del" class="hui">删除信息</a><a href="/zhubao/updaddress/{{$v->address_id}}" class="hui xiu" aid="{{$v->address_id}}"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
            </tr>
                @endif
        @endforeach
        </table>
    </div><!--dingdanlist/-->

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
            $('.del').click(function () {
                var address_id = $(this).next('a').attr('aid');
                $.post(
                    "/zhubao/deladdress/"+address_id,
                    function (res) {
                        if(res.code==6){
                            layer.msg(res.msg,{icon:res.code},function () {
                                location.href="/zhubao/addresslist";
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