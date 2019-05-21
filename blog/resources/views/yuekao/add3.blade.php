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
<form action="add3" method="post">
    <input type="hidden" name="name" value="{{$name}}">
    <input type="hidden" name="artisan" value="{{$artisan}}">
    <table>
        <tr>
            <td><input type="radio" name="kuangjia" value="laravel">A</td>
            <td><input type="text" value="laravel"></td>
        </tr>
        <tr>
            <td><input type="radio" name="kuangjia" value="Yll2.0">B</td>
            <td><input type="text" value="Yll2.0"></td>
        </tr>
        <tr>
            <td><input type="radio" name="kuangjia" value="ThinkPhP">C</td>
            <td><input type="text" value="ThinkPhP"></td>
        </tr>
        <tr>
            <td><input type="radio" name="kuangjia" value="CL">D</td>
            <td><input type="text" value="CL"></td>
        </tr>
        <tr>
            <td><input type="submit" value="提交"></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>