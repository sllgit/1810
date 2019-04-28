<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝注册</title>
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
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('images/head.jpg')}}" />
     </div><!--head-top/-->
     {{--<form action="" method="get" class="reg-login">--}}
      <h4>已经有账号了？点此<a class="orange" href="/zhubao/login">登陆</a></h4>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="tel" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="code" placeholder="输入6位验证码" /> <button id="code">获取验证码</button></div>
       <div class="lrList"><input type="text" name="password" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="text" name="repassword" placeholder="再次输入密码" /></div>
          <input type="hidden" name="type" id="type">
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     {{--</form><!--reg-login/-->--}}
     <div class="height1"></div>
        @include('zhubao.public.footer')
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
  </body>
</html>
<script>
    $(function(){
        layui.use('layer',function () {
            var layer = layui.layer;

            //获取验证码
            $('#code').click(function () {
                var tel = $('input[name=tel]').val();
                var tell = /^1[7,3,5,8,9]\d{9}$/;
                var email = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
                if(tell.test(tel)){
                    $.post(
                        "/zhubao/getcode",
                        {tel:tel},
                        function (res) {
                            layer.msg(res.msg,{icon:res.code});
                        }
                    );
                    $('#type').val('1');
                }else if(email.test(tel)){
                   $.post(
                       "/zhubao/emailgetcode",
                       {tel:tel},
                       function (res) {
                           layer.msg(res.msg,{icon:res.code});
                       }
                   )
                    $('#type').val('2');
                }else{
                    layer.msg('请填写正确手机号或邮箱',{icon:5});
                }
            })
            //注册
            $('input[type=submit]').click(function () {
                var tel = $('input[name=tel]').val();
                var code = $('input[name=code]').val();
                var password = $('input[name=password]').val();
                var repassword = $('input[name=repassword]').val();
                var type = $('input[name=type]').val();
                var tell = /^1[7|3|5|8|9]\d{9}$/;
                var email = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
                alert(tell.test(tel));
                if(!tell.test(tel)&&!email.test(tel)){
                    layer.msg('请填写正确手机号或邮箱',{icon:5});
                    return false;
                }
                if(tel==''){
                    layer.msg('手机号或邮箱必填',{icon:5});
                    return false;
                }
                if(code==''){
                    layer.msg('验证码必填',{icon:5});
                    return false;
                }
                if(password==''){
                    layer.msg('密码必填',{icon:5});
                    return false;
                }
                if(repassword==''){
                    layer.msg('确认密码必填',{icon:5});
                    return false;
                }
                if(password!=repassword){
                    layer.msg('确认密码必须与密码一致',{icon:5});
                    return false;
                }
                $.post(
                    "/zhubao/register",
                    {tel:tel,code:code,password:password,repassword:repassword,type:type},
                    function (res) {
                        if(res.code==6){
                            layer.msg(res.msg,{icon:res.code,},function () {
                                location.href="/zhubao/login";
                            });
                        }else{
                            layer.msg(res.msg,{icon:res.code,});
                        }
                    }
                )
            })
        })
    })
</script>
