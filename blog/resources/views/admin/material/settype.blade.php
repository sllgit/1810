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
<form action="">
    <tr>
        <td>类型</td>
        <td>
            <input type="radio" name="type" value="text" @if($type == 'text')checked @endif>text
            <input type="radio" name="type" value="image" @if($type == 'image')checked @endif>image
            <input type="radio" name="type" value="voice" @if($type == 'voice')checked @endif>voice
            <input type="radio" name="type" value="redio" @if($type == 'redio')checked @endif>redio
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit"></td>
    </tr>
</form>
</body>
</html>