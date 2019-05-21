<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{'css/page.css'}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <td>调研项目</td>
        <td>调研问题</td>
        @if($data->jishu == null)
        <td>使用框架</td>
        @else
            <td>需学习技术</td>
        @endif
    </tr>
        <tr>
            <td>{{$data->name}}</td>
            <td>{{$data->artisan}}</td>
            @if($data->jishu == null)
                <td>{{$data->kuangjia}}</td>
            @else
                <td>{{$data->jishu}}</td>
            @endif
        </tr>
</table>
</body>
</html>
<script>
    $(function () {
        $('.button1').click(function () {
            var id=$(this).attr('id');
            alert("调研链接：http://www.laravel.com/detail/"+id);
        })
    })
</script>