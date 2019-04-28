<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝所有商品</title>
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
            <form action="" method="get" class="prosearch">
                <input type="text" name="goods_name" style="width:91%;"/>
                <button>搜索</button>
            </form>
        </div>
    </header>
    <ul class="pro-select"> {{--class="pro-selCur"--}}
        <li><a href="javascript:;" class="tiaojian" type="1">新品</a></li>
        <li><a href="javascript:;" class="tiaojian" type="2">销量</a></li>
        <li><a href="javascript:;" class="tiaojian" type="3">价格</a></li>
    </ul><!--pro-select/-->
    <input type="hidden" id="fenlei_id" value="{{$id}}">
    <div class="prolist">
        @foreach($res as $k=>$v)
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
    $(function () {
        //条件查询
        $('.tiaojian').click(function () {
            var _this=$(this);
            var type=_this.attr('type');
            var feilei_id=$('#fenlei_id').val();
            _this.addClass('pro-selCur').siblings('li').removeClass('pro-selCur');
            $.post(
                "/zhubao/allshops",
                {type:type,feilei_id:feilei_id},
                function (res) {
                    // console.log(res);
                    $('.prolist').html(res);
                }
            )
            // console.log(type);
        })
        // //搜索
        // $('#seach').blur(function () {
        //     var goods_name=$(this).val();
        //     $.get(
        //
        //     )
        //     alert(goods_name);
        // })
    })
</script>