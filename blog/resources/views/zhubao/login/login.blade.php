<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝登录</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}} "/>
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
     <form action="/zhubao/login" method="post" class="reg-login">
      <h3>还没有三级分销账号？点此<a class="orange" href="/zhubao/register">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="tel_email"  placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="text" name="password" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即登录" />
      </div>
     </form><!--reg-login/-->
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
    $(function () {
        // layui.use('layer',function () {
        //    var layer=layui.layer;
        //    $('input[type=submit]').click(function () {
        //         var tel_email=$('input[name=tel_email]').val();
        //         var password=$('input[name=password]').val();
        //        $.post(
        //            "/zhubao/login",
        //            {tel_email:tel_email,password:password},
        //            function (res) {
        //                layer.msg(res.msg,{icon:res.code});
        //            }
        //        )
        //    })
        // })
    })
</script>
