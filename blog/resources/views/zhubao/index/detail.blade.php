<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>商品详情</title>
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
            <h1>产品详情</h1>
        </div>
    </header>
    <div id="sliderA" class="slider">
        @foreach($goods_imgs as $k=>$v)
        <img src="http://uploads.com/{{$v}}" />
       @endforeach
    </div><!--sliderA/-->
    <table class="jia-len">
        <tr>
            <th><strong class="orange">{{$data->goods_price}}</strong></th>
            <td>
                共<span id="num">{{$data->goods_num}}</span>件
                <button id="jian">-</button>
                <input type="text" name="goods_number" value="1" id="number">
                <button id="jia">+</button>
            </td>
        </tr>
        <input type="hidden" id="id" value="{{$data->goods_id}}">
        <tr>
            <td>
                <strong>{{$data->goods_name}}</strong>
                <p class="hui">{{$data->goods_desc}}</p>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <h3 class="proTitle">商品规格</h3>
    <ul class="guige">
        <li class="guigeCur"><a href="javascript:;" class="guiges">50ML</a></li>
        <li><a href="javascript:;" class="guiges">100ML</a></li>
        <li><a href="javascript:;" class="guiges">150ML</a></li>
        <li><a href="javascript:;" class="guiges">200ML</a></li>
        <li><a href="javascript:;" class="guiges">300ML</a></li>
        <div class="clearfix"></div>
    </ul><!--guige/-->
    <div class="height2"></div>
    <div class="zhaieq">
        <a href="javascript:;" class="zhaiCur">商品简介</a>
        <a href="javascript:;">商品参数</a>
        <a href="javascript:;" style="background:none;">订购列表</a>
        <div class="clearfix"></div>
    </div><!--zhaieq/-->
    <div class="proinfoList">
        {{$data->goods_desc}}
        {{--<img src="{{asset('images/image4.jpg')}}" width="636" height="822" />--}}
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息....
    </div><!--proinfoList/-->
    <div class="proinfoList">
        暂无信息......
    </div><!--proinfoList/-->
    <table class="jrgwc" id="addcar">
        <tr>
            <th>
                <a href="javascript:;"><span class="glyphicon glyphicon-home"></span></a>
            </th>
            <td><a href="javascript:;">加入购物车</a></td>
        </tr>
    </table>
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
            //点击加号
            $('#jia').click(function () {
                var goods_number=$(this).prev('input').val();
                var goods_num=$('#num').text();
                console.log(goods_number);
                console.log(goods_num);
                if(goods_number >= parseInt(goods_num)){
                    $(this).prop('disabled',true);
                    $('#jian').prop('disabled',false);
                }else{
                    goods_number = parseInt(goods_number)+1;
                }
                 $(this).prev('input').val(goods_number);
                // alert(goods_number);
            })
            //改变文本框的值
            $('#number').blur(function () {
                var number = $(this).val();
                var reg=/^\d{1,}&/;
                var goods_num=$('#num').text();
                if(parseInt(number) > parseInt(goods_num)){
                    $(this).val(goods_num);
                }else if(!reg.test(number)){
                    $(this).val(1);
                }else if(parseInt(number)<=0){
                    $(this).val(1);
                }
            })
            //点击减号
            $('#jian').click(function () {
                var goods_number=$(this).next('input').val();
                if(goods_number <= 1){
                    $(this).prop('disabled',true);
                    $('#jia').prop('disabled',false);
                }else{
                    goods_number = parseInt(goods_number)-1;
                }

                $(this).next('input').val(goods_number);
                // alert(goods_number);
            })
            //加入购物车
            $('#addcar').click(function () {
                var goods_id = $('#id').val();
                var goods_number = $('#number').val();
                if(parseInt(goods_number)<=0){
                    layer.msg('请至少购买一件商品',{icon:5});
                    return false;
                }
                var goods_guige=$('.guiges').parent('li[class="guigeCur"]').find('a').text();
                $.post(
                    "/zhubao/addcar/"+goods_id,
                    {goods_guige:goods_guige,goods_id:goods_id,buy_number:goods_number},
                    function (res) {
                        if(res.code==6){
                            layer.msg(res.msg,{icon:res.code},function () {
                                location.href="/zhubao/car";
                            });
                        }else if(res.code==5){
                            layer.msg(res.msg,{icon:res.code});
                        }else{
                            layer.msg(res.msg,{icon:5},function () {
                                location.href="/zhubao/login";
                            });
                        }
                    }
                )
            })
        })
    })
</script>