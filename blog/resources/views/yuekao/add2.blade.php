<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="add2" method="post">
    <input type="hidden" name="name" value="{{$name}}">
    <table>
        <tr>
            <td>调研问题</td>
            <td><input type="text" name="artisan"></td>
        </tr>
        <tr>
            <td>问题选项</td>
            <td><input type="radio" name="xuanxiang" value="1">单选<input type="checkbox" name="xuanxiang" value="2">多选</td>
        </tr>
        <tr>
            <td><input type="submit" value="添加问题"></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>