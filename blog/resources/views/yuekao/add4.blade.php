<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('js/jquery.js')}}"></script>
    <title>Document</title>
</head>
<body>
    <input type="hidden" name="name" value="{{$name}}">
    <input type="hidden" name="artisan" value="{{$artisan}}">
    <table>
        <tr>
            <td><input type="checkbox" name="jishu" value="直播技术">A</td>
            <td><input type="text" value="直播技术"></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="jishu" value="框架">B</td>
            <td><input type="text" value="框架"></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="jishu" value="API">C</td>
            <td><input type="text" value="API"></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="jishu" value="架构">D</td>
            <td><input type="text" value="架构"></td>
        </tr>
        <tr>
            <td><input type="button" value="提交"></td>
            <td></td>
        </tr>
    </table>
</body>
</html>
<script>
    $(function () {
        $('input[type=button]').click(function () {
            var _input =$('input[name=jishu]');
            var jishu = '';
            _input.each(function (index){
                if($(this).prop('checked')==true) {
                    jishu+=$(this).val()+',';
                }
            })
            jishu = jishu.substr(0,jishu.length-1);
            console.log(jishu);
            var name=$('input[name=name]').val();
            var artisan=$('input[name=artisan]').val();
            $.post(
                "add4",
                {name:name,artisan:artisan,jishu:jishu},
                function (res) {
                    if(res==1){
                        alert('提交成功');
                        location.href="list";
                    }else{
                        alert('提交失败');
                    }
                }
            )
        })

    })
</script>