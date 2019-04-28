<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>添加</title>
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
<form action="/si/list" method="post" enctype="multipart/form-data">
    @csrf
    <table border="1">
        <tr>
            <td>姓名</td>
            <td>
                <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <td>年龄</td>
            <td><input type="text" name="age"></td>
        </tr>
        <tr>
            <td>性别</td>
            <td>
                <input type="radio" name="sex" value="1" checked>男
                <input type="radio" name="sex" value="2">女
            </td>
        </tr>
        <tr>
            <td>头像</td>
            <td>
                <input type="file" name="img">
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
    //姓名验证
    blag1=false;
    $('input[name=name]').blur(function () {
        var name=$(this).val();
        $(this).next().remove();
        $.post(
            '/si/checkName',
            {name:name},
            function (res) {
                if(res.code==2){
                    blag1=false;
                }else if(res.code==1){
                    blag1=true;
                }else{
                    blag1=false;
                }
                $('input[name=name]').after("<span style='color:red'>"+res.msg+"</span>");
            }
        );
    })
    //年龄验证
    blag2=false;
    $('input[name=age]').blur(function () {
        var age=$(this).val();
        $(this).next().remove();
        if(age==''){
            $(this).after("<span style='color:red'>年龄必填</span>");
            return false;
            blag2=false;
        }
        var reg=/^\d{1,3}$/;
        if(!reg.test(age)){
            $('input[name=age]').after("<span style='color:red'>年龄必须为数字</span>");
            blag2=false;
        }else{
            blag2=true;
        }
    })
    //提交
    $('input[type=submit]').click(function () {
        // console.log(blag1);
        // console.log(blag2);
        if(blag1==true&&blag2==true){
            return true;
        }else{
            alert('姓名或年龄错误');
            return false;
        }
    })
</script>