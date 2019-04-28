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
<table border="1">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>图片</td>
        <td>数量</td>
        <td>描述</td>
    </tr>
    <tr>
        <td>{{$data->goods_id}}</td>
        <td>{{$data->goods_name}}</td>
        <td><img src="http://uploads.com/{{$data->goods_img}}" alt="" width="50px" height="50px"></td>
        <td>{{$data->goods_num}}</td>
        <td>{{$data->goods_desc}}</td>
    </tr>
</table>
</body>
</html>