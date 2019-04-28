<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>测试修改</title>
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
<form action="/ceshi/update" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$data->id}}">
    <table border="1">
        <tr>
            <td>网站名称</td>
            <td>
                <input type="text" name="name" value="{{$data->name}}">
            </td>
        </tr>
        <tr>
            <td>网站网址</td>
            <td>
                <input type="text" name="url" value="{{$data->url}}">
            </td>
        </tr>
        <tr>
            <td>链接类型</td>
            <td>
                <input type="radio" name="type" value="1" @if($data->type==1)checked @endif>LOGO链接
                <input type="radio" name="type" value="2"@if($data->type==2)checked @endif>文字链接
            </td>
        </tr>
        <tr>
            <td>图片LOGO</td>
            <td>
                <img src="http://uploads.com/{{$data->logo}}" alt="" width="50" height="40">
                <input type="file" name="logo">
            </td>
        </tr>
        <tr>
            <td>网站联系人</td>
            <td><input type="text" name="people" value="{{$data->people}}"></td>
        </tr>
        <tr>
            <td>网站介绍</td>
            <td>
                <textarea name="content">{{$data->content}}</textarea>
            </td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                <input type="radio" name="isshow" value="1" @if($data->type==1)checked @endif>是
                <input type="radio" name="isshow" value="2"@if($data->type==2)checked @endif>否
            </td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" value="修改"></td>
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
    blag1=true;
    $('input[name=name]').blur(function () {
        // alert(1);
        var name=$(this).val();
        var id=$('input[name=id]').val();
        $(this).next().remove();
        $.post(
            '/ceshi/checkName',
            {name:name,id:id},
            function (res) {
                // alert(res);
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
    // 网站网址验证
    blag2=true;
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
    //
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