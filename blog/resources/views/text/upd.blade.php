<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ceshi</title>
</head>
<body>
<form action="/upddo" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="goods_id" value="{{$data->goods_id}}">
    <table border="1">
        <tr>
            <td>名称</td>
            <td>
                <input type="text" name="goods_name" value="{{$data->goods_name}}">
            </td>
        </tr>
        <tr>
            <td>数量</td>
            <td>
                <input type="text" name="goods_num" value="{{$data->goods_num}}">
            </td>
        </tr>
        <tr>
            <td>图片</td>
            <td>
                <img src="http://uploads.com/{{$data->goods_img}}" alt="" width="50" height="40">
                <input type="file" name="goods_img">
                <input type="text" name="img" value="{{$data->goods_img}}">
            </td>
        </tr>
        <tr>
            <td>描述</td>
            <td>
                <textarea name="goods_desc">{{$data->goods_desc}}</textarea>
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
