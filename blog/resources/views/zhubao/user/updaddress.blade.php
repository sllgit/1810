<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝修改收货地址</title>
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
    <form action="javascript:;" method="post" class="reg-login">
        <div class="lrBox">
            <input type="hidden" name="address_id" value="{{$data->address_id}}" id="id">
            <div class="lrList"><input type="text" id="address_name" value="{{$data->address_name}}" /></div>
            <div class="lrList"><input type="text" id="address_detail" value="{{$data->address_detail}}" /></div>
            <div class="lrList">
                <select class="city" id="province">
                    <option value="0" selected>请选择</option>
                    @foreach($province as $k=>$v)
                        @if($data->province == $v->id )
                            <option value="{{$v->id}}" selected>{{$v->name}}</option>
                        @else
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="lrList">
                <select class="city" id="city">
                    <option value="0" selected>请选择</option>
                    @foreach($city as $k=>$v)
                        @if($data->city == $v->id )
                            <option value="{{$v->id}}" selected>{{$v->name}}</option>
                        @else
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="lrList">
                <select class="city" id="area">
                    <option value="0" selected>请选择</option>
                    @foreach($area as $k=>$v)
                        @if($data->area == $v->id )
                            <option value="{{$v->id}}" selected>{{$v->name}}</option>
                        @else
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="lrList"><input type="text" value="{{$data->address_mail}}" id="address_mail" /></div>
            <div class="lrList"><input type="text" value="{{$data->address_tel}}" id="address_tel" /></div>
            <div>
            是否设为默认
            <input type="radio" name="is_result" class="is_result" value="1" @if($data->is_result == 1)checked @endif/>是
            <input type="radio" name="is_result" class="is_result"  value="2" @if($data->is_result == 2)checked @endif/>否
            </div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" value="修改" id="submit"/>
        </div>
    </form><!--reg-login/-->

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
<script>
    $(function () {
        layui.use('layer',function () {
            var layer=layui.layer;
            //点击市获取区县信息
            $(document).on('change','.city',function () {
                var _this=$(this);
                var id=_this.val();
                var _option="<option selected>请选择</option>";
                _this.parent('div').nextAll('div').children("select[class='city']").html(_option);
                // console.log(id);
                $.post(
                    "/zhubao/address",
                    {id:id},
                    function(res){
                        // console.log(res);
                        for(var i in res){
                            _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
                            _this.parent('div').nextAll('div').children("select[class='city']").html(_option);
                        }
                        // console.log(_option);
                        _this.parent('div').next('div').children("select[class='city']").html(_option);
                    }
                    ,'json'
                )
                // console.log(id);
            })

            //收货人信息修改
            $('#submit').click(function(){
                var obj={};
                obj.address_id=$('#id').val();
                obj.province=$('#province').val();
                obj.city=$('#city').val();
                obj.area=$('#area').val();
                obj.address_name=$('#address_name').val();
                obj.address_tel=$('#address_tel').val();
                obj.address_detail=$('#address_detail').val();
                obj.address_mail=$('#address_mail').val();
                    is_result=$('.is_result').prop('checked');
                if(is_result==true){
                    obj.is_result=1;
                }else{
                    obj.is_result=2;
                }
                if(obj.province==0){
                    layer.msg('请选择完整收货地址',{icon:2});
                    return false;
                }
                $.post(
                    "/zhubao/upddoaddress",
                    obj,
                    function(res){
                        // console.log(res);
                        if(res.code==6){
                            layer.msg(res.msg,{icon:res.code},function () {
                                location.href="/zhubao/addresslist";
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code});
                        }
                    }
                );
            });
        })
    })
</script>