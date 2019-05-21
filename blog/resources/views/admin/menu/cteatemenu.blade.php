<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    <link rel="stylesheet" href="{{asset('css/xadmin.css')}}">
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <script type="text/javascript" src="{{asset('lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{asset('js/xadmin.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form class="layui-form" action="/admin/cteatemenu" method="post">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>菜单名称</label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="name" required="" autocomplete="off" class="layui-input"></div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>菜单类型</label>
                <div class="layui-input-inline layui-show-xs-block">
                    <select name="type"  lay-filter="type_mid" >
                        <option value="0">请选择菜单类型</option>
                        <option value="click">click</option>
                        <option value="view">view</option>
                       </select>
                </div>
            </div>
            <div class="layui-form-item" id="key" style="display: none">
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>菜单key值</label>
                <div class="layui-input-inline">
                    <input type="text" id="L_pass" name="key" autocomplete="off" class="layui-input"></div>
            </div>
                <div class="layui-form-item" id="url" style="display: none">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>菜单url</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_pass" name="url" autocomplete="off" class="layui-input"></div>
                </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>选择父类菜单</label>
                <div class="layui-input-inline">
                    <select name="pid">
                        @if($count >= 3)
                        @else
                            <option value="0">一级菜单</option>
                        @endif
                            @foreach($data as $k=>$v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label"></label>
                <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
            </div>
        </form>
    </div>
</div>
<script>layui.use(['form', 'layer','jquery'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
                layer = layui.layer;

            //点击click类型 显示添加key值
           form.on('select(type_mid)',function (data) {
               if(data.value == 'click'){
                   $('#key').css('display','block');
                   $('#url').css('display','none');
               }else{
                   $('#key').css('display','none');
                   $('#url').css('display','block');
               }
           })
        });</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>