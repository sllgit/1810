<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>测试添加</title>
</head>
<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="/ceshi/list" method="post" enctype="multipart/form-data">
    @csrf
    <table border="1">
        <tr>
            <td>网站名称</td>
            <td>
                <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <td>网站网址</td>
            <td>
                <input type="text" name="url">
            </td>
        </tr>
        <tr>
            <td>链接类型</td>
            <td>
                <input type="radio" name="type" value="1" checked>LOGO链接
                <input type="radio" name="type" value="2">文字链接
            </td>
        </tr>
        <tr>
            <td>图片LOGO</td>
            <td>
                <input type="file" name="logo">
            </td>
        </tr>
        <tr>
            <td>网站联系人</td>
            <td><input type="text" name="people"></td>
        </tr>
        <tr>
            <td>网站介绍</td>
            <td>
                <textarea name="content"></textarea>
            </td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                <input type="radio" name="isshow" value="1" checked>是
                <input type="radio" name="isshow" value="2">否
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="添加"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //名称验证
    blag1=false;
    $('input[name=name]').blur(function () {
        // alert(1);
        var name=$(this).val();
        $(this).next().remove();
        if(name==''){
        }else{
            var reg = /^[a-zA-Z0-9_(\u4e00-\u9fa5)]{1,}$/;
            if (!reg.test(name)) {
                $('input[name=name]').next().remove();
                $('input[name=name]').after("<span style='color:red'>名称为中文数字字母下划线组成</span>");
                blag1 = false;
                return false;
            }
        }

        $.post(
            '/ceshi/checkName',
            {name:name,id:0},
            function (res) {
                // alert(res);
                if(res.code==1){
                    $('input[name=name]').after("<span style='color:red'>"+res.msg+"</span>");
                    blag1=true;
                }else{
                    $('input[name=name]').after("<span style='color:red'>"+res.msg+"</span>");
                    return false;
                    blag1=false;
                }

            }
        );

    })
    // 网站网址验证
    blag2=false;
    $('input[name=url]').blur(function () {
        var url=$(this).val();
        $(this).next().remove();
        if(url==''){
            $(this).after("<span style='color:red'>网站网址必填</span>");
            blag2=false;
        }
        var reg=/^http(\:)(\/)(\/)(w){3}(\.)[a-zA-Z]{1,}(\.)(com)$/;
        if(!reg.test(url)){
            $('input[name=url]').after("<span style='color:red'>网站网址必须以http开头</span>");
            blag2=false;
        }else{
            blag2=true;
        }
    })
    // //
    //提交
    $('input[type=submit]').click(function () {
        if(blag1==true&&blag2==true){
            return true;
        }else{
            alert('请检查填写是否正确');
            return false;
        }
    })
</script>