<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/page.css')}}">
    <title>列表展示</title>
</head>
<body>
<form action="">
    <input type="text" name="name" value="" placeholder="请输入名称">
    <input type="submit" value="搜索">
</form>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>网站名称</td>
            <td>网站网址</td>
            <td>链接类型</td>
            <td>图片LOGO</td>
            <td>网址联系人</td>
            <td>网址介绍</td>
            <td>是否显示</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->url}}</td>
                <td>@if($v->type==1)LOGO链接@else文字链接@endif</td>
                <td><img src="http://uploads.com/{{$v->logo}}" alt="" width="50" height="40"></td>
                <td>{{$v->people}}</td>
                <td>{{$v->content}}</td>
                <td>@if($v->isshow==1)是@else否@endif</td>
                <td><a href="/ceshi/del/{{$v->id}}">删除</a>||<a href="/ceshi/edit/{{$v->id}}">修改</a></td>
            </tr>
        @endforeach
    </table>
    {{$data->appends($query)->links()}}
</body>
</html>