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
    <input type="text" name="name" value="{{$name}}" placeholder="请输入姓名">
    <select name="age">
        <option value="">--请选择年龄--</option>
        <option value="18" @if($age==18) selected @endif>18</option>
        <option value="19" @if($age==19) selected @endif>19</option>
        <option value="20" @if($age==20) selected @endif>20</option>
        <option value="21" @if($age==21) selected @endif>21</option>
    </select>
    <input type="submit" value="搜索">
</form>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>姓名</td>
            <td>年龄</td>
            <td>性别</td>
            <td>头像</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k=>$v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->age}}</td>
                <td>@if($v->sex==1)男@else女@endif</td>
                <td><img src="http://uploads.com/{{$v->img}}" alt="" width="50" height="40"></td>
                <td><a href="/si/del/{{$v->id}}">删除</a>||<a href="/si/edit/{{$v->id}}">修改</a></td>
            </tr>
        @endforeach
    </table>
    {{$data->appends($query)->links()}}
</body>
</html>