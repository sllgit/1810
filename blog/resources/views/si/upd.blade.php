<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
<form action="/si/update" method="post"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$data[0]->id}}">
    <table border="1">
        <tr>
            <td>姓名</td>
            <td><input type="text" name="name" value="{{$data[0]->name}}"></td>
        </tr>
        <tr>
            <td>年龄</td>
            <td><input type="number" name="age" value="{{$data[0]->age}}"></td>
        </tr>
        <tr>
            <td>年龄</td>
            @if($data[0]->sex == 1)
            <td>
                <input type="radio" name="sex" value="1" checked>男
                <input type="radio" name="sex" value="2">女
            </td>
            @else
                <td>
                    <input type="radio" name="sex" value="1">男
                    <input type="radio" name="sex" value="2" checked>女
                </td>
            @endif
        </tr>
        <tr>
            <td>头像</td>
            <td>
                <img src="http://uploads.com/{{$data[0]->img}}" alt=""  width="50" height="40">
                <input type="file" name="img">
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