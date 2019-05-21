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
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->name}}</td>
        <td><input type="button" class="button1" value="启用" id="{{$v->id}}"> <input type="button" class="button2" value="删除" id="{{$v->id}}"></td>
    </tr>
    @endforeach
</table>
{{$data->links()}}
</body>
</html>
<script>
    $(function () {
        $('.button1').click(function () {
            var id=$(this).attr('id');
            alert("调研链接：http://www.laravel.com/detail/"+id);
        })
        $('.button2').click(function () {
            var id=$(this).attr('id');
            location.href="del/"+id;
        })
    })
</script>