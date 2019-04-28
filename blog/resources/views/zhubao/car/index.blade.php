<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝购物车列表</title>
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
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="{{asset('images/head.jpg')}}" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url({{asset('images/xian.jpg')}}) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#00cc00" id="del"></span>
            </td>
        </tr>
    </table>

    <div class="dingdanlist">
        <table>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="checkbox"/> 全选</a></td>
            </tr>
            @foreach($data as $k =>$v)
            <tr>
                <td width="4%"><input type="checkbox" name="1" class="checkbox" gid="{{$v->goods_id}}"/></td>
                <td class="dingimg" width="15%"><a href="/zhubao/detail/{{$v->goods_id}}"><img src="http://uploads.com/{{$v->goods_img}}" /></a></td>
                <td width="50%">
                    <h3><a href="/zhubao/detail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
                    <time>下单时间：{{date("Y-m-d H:i:s",$v->create_time)}}</time>
                </td>
                <td align="right">
                    <span style="color:red;">{{$v->buy_number}}</span>/<span style="font-size:5px;">{{$v->goods_num}}</span>
                    {{--<input type="text" class="spinnerExample" id="jia"/>--}}
                </td>
            </tr>
            <tr>
                <th colspan="4"><strong class="orange">¥{{$v->goods_price}}</strong></th>
            </tr>
            @endforeach
        </table>
    </div><!--dingdanlist/-->

    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr>
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%">总计：¥<strong class="orange allprice">0</strong></td>
                <td width="40%"><a href="javascript:;" class="jiesuan">去结算</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
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
            //点击全选
            $('#checkbox').click(function () {
                var checked = $(this).prop('checked');
                $('.checkbox').prop('checked',checked);
                var check=$('.checkbox');
                var id='';
                check.each(function (index) {
                    if($(this).prop('checked')==true){
                        id +=$(this).attr('gid')+',';
                    }
                })
                goods_id=id.substr(0,id.length-1);
                // console.log(goods_id);
                getallprice(goods_id);
            })
            //点击单选
            $('.checkbox').click(function () {
                var check=$('.checkbox');
                var id='';
                check.each(function (index) {
                    if($(this).prop('checked')==true){
                        id +=$(this).attr('gid')+',';
                    }
                })
                goods_id=id.substr(0,id.length-1);
                // console.log(goods_id);
                getallprice(goods_id);
            })
            //获取总价格
            function getallprice(goods_id) {
                $.post(
                    "/zhubao/getallprice",
                    {goods_id:goods_id},
                    function (res) {
                       $('.allprice').text(res);
                        // console.log(res);
                    }
                )
            }
            //点击删除
            $('#del').click(function () {
                var check=$('.checkbox');
                var id='';
                check.each(function (index) {
                    if($(this).prop('checked')==true){
                        id +=$(this).attr('gid')+',';
                    }
                })
                goods_id=id.substr(0,id.length-1);
                if(goods_id == ''){
                    layer.msg('至少选择一件商品',{icon:5});
                    return false;
                }
                $.post(
                    "/zhubao/delcart",
                    {goods_id:goods_id},
                    function (res) {
                        if(res.code==6){
                            layer.msg(res.msg,{icon:res.code},function () {
                                location.href="/zhubao/car";
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code});
                        }
                    }
                )
            })
            //点击结算
            $('.jiesuan').click(function () {
                var check=$('.checkbox');
                var allprice=$('.allprice').text();
                var id='';
                check.each(function (index) {
                    if($(this).prop('checked')==true){
                        id +=$(this).attr('gid')+',';
                    }
                })
                goods_id=id.substr(0,id.length-1);
                if(goods_id==''){
                    layer.msg('至少选择一件商品结算',{icon:5});
                    return false;
                }
                location.href="/zhubao/pay/"+goods_id;
            })
        })
    })
</script>