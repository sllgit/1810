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
    <input type="button" value="全选" id="quan">
    &nbsp;&nbsp;
    <input type="button" value="全不选" id="quanbu">
    &nbsp;&nbsp;
    <input type="button" value="反选" id="fan">
    <table>
        <tr>
            <td colspan="2">请选择要发送的openid</td>
        </tr>
        @foreach($openid as $k=>$v)
        <tr>
            <td><input type="checkbox" class="openid"></td>
            <td>{{$v}}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td>
                <div id="send" style="float: left">
                    <input type="button" value="群发">
                </div>
                <div id="addtag">
                    <input type="button" value="打标签">
                </div>
                <div id="tagid" style="display: none">
                    <select name="tagid" class="tagid">
                        <option> 请选择要添加的标签</option>
                        @foreach($tag as $k=>$v)
                            <option value="{{$v->id}}" >{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>

            </td>
        </tr>
    </table>
</body>
</html>
<script>
    $(function () {
        //点击全选
        $('#quan').click(function () {
            $('.openid').prop('checked',true);

        });
        //点击全不选
        $('#quanbu').click(function () {
            $('.openid').prop('checked',false);
        });
        //点击反选
        $('#fan').click(function () {
            $('.openid').each(function (index) {
                if($(this).prop('checked') == true){
                    $(this).prop('checked',false);
                }else{
                    $(this).prop('checked',true);
                }
            })
        });
        //点击发送
        $('#send').click(function () {
            var checked = $('.openid');
            var openid = '';
            checked.each(function (index) {
                // console.log($(this).prop('checked'));
                if($(this).prop('checked') == true){
                    openid+=$(this).parents('td').next().text()+',';
                }
            })
            openid = openid.substr(0,openid.length-1);
            location.href="/admin/groupsend/"+openid;
        })
        //点击打标签
        $('#addtag').click(function () {
            $('#tagid').css('display','block');
            $(this).css('display','none');
        })
        //域的内容改变 打标签
        $('.tagid').change(function () {
            var tagid = $(this).val();
            var checked = $('.openid');
            var openid = '';
            checked.each(function (index) {
                // console.log($(this).prop('checked'));
                if($(this).prop('checked') == true){
                    openid+=$(this).parents('td').next().text()+',';
                }
            })
            openid = openid.substr(0,openid.length-1);
            $.post(
                "/admin/settagforuser",
                {tagid:tagid,openid:openid},
                function (res) {
                    if(res == 1){
                        alert('打标签成功');
                    }else{
                        alert('打标签失败');
                    }
                }
            )
        })
    })
</script>