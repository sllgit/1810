<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('layui/layui.js')}}"></script>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/response.css')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js')}} for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js')}}/1.4.2/respond.min.js"></script>
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
    <div class="dingdanlist">
        <table>
            <tr onClick="window.location.href='/zhubao/address'">
                <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
                <td align="right"><img src="{{asset('images/jian-new.png')}}" /></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>

            <tr>
                <td class="dingimg">收货人信息</td>
                @foreach($address as $k=>$v)
                <td>{{$v->address_name}}  {{$v->address_tel}}  {{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}  {{$v->address_mail}}</td>
                @endforeach
            </tr>
            {{--<tr>--}}
                {{--<td class="dingimg" width="75%" colspan="2">选择收货时间</td>--}}
                {{--<td align="right"><img src="{{asset('images/jian-new.png')}}" /></td>--}}
            {{--</tr>--}}
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">支付方式</td>
                <td align="right"><span class="hui">支付宝</span></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">优惠券</td>
                <td align="right"><span class="hui">无</span></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">是否需要开发票</td>
                <td align="right"><a href="javascript:;" class="orange">是</a> &nbsp; <a href="javascript:;">否</a></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">发票抬头</td>
                <td align="right"><span class="hui">个人</span></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">发票内容</td>
                <td align="right"><a href="javascript:;" class="hui">请选择发票内容</a></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="3">商品清单</td>
            </tr>
            @foreach($data as $k =>$v)
                <input type="hidden" value="{{$v->goods_id}}" class="id">
            <tr>
                <td class="dingimg" width="15%"><img src="http://uploads.com/{{$v->goods_img}}" /></td>
                <td width="50%">
                    <h3>{{$v->goods_name}}</h3>
                    <time>下单时间：{{date("Y-m-d h:i:s",$v->create_time)}}</time>
                </td>
                <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">¥{{$v->goods_price}}</strong></th>
            </tr>
            @endforeach

            <tr>
                <td class="dingimg" width="75%" colspan="2">商品金额</td>
                <td align="right"><strong class="orange">¥{{$allprice}}</strong></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">折扣优惠</td>
                <td align="right"><strong class="green">¥0.00</strong></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">抵扣金额</td>
                <td align="right"><strong class="green">¥0.00</strong></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">运费</td>
                <td align="right"><strong class="orange">¥20.80</strong></td>
            </tr>
        </table>
    </div><!--dingdanlist/-->


</div><!--content/-->

<div class="height1"></div>
<div class="gwcpiao">
    <table>
        <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：¥<strong class="orange allprice">{{$allprice}}</strong></td>
            <td width="40%"><a href="javascript:;" class="jiesuan">提交订单</a></td>
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
            $('.jiesuan').click(function () {
                var _this=$('.id');
                var allprice=$('.allprice').text();
                var goods_id='';
                _this.each(function (index) {
                    goods_id+=$(this).val()+',';
                })
                goods_id=goods_id.substr(0,goods_id.length-1);
                $.post(
                    "/zhubao/paydo",
                    {goods_id:goods_id,allprice:allprice},
                    function (res) {
                       if(res.code==6){
                           layer.msg(res.msg,{icon:res.code},function () {
                               location.href="/zhubao/success";
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