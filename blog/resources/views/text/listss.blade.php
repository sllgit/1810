<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ceshi</title>
    <link rel="stylesheet" href="{{asset('css/page.css')}}">
</head>
<body>
<form action="">
    <input type="text" name="goods_name" value="{{$goods_name}}">
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>数量</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td><a href="detail/{{$v->goods_id}}">{{$v->goods_name}}</a></td>
        <td>{{$v->goods_num}}</td>
        <td>{{$v->goods_desc}}</td>
        <td><a href="upd/{{$v->goods_id}}">修改</a>|<a href="del/{{$v->goods_id}}">删除</a></td>
    </tr>
    @endforeach
</table>
{{$data->appends($request)->links()}}
</body>
</html>