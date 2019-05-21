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
标签：
@foreach($tag as $k=>$v)
    <input type="button" openid="{{$v->id}}" value="{{$v->name}}" class="tag" style=""> &nbsp;&nbsp;
@endforeach
<br \>
{{--<input type="button" value="给标签群发" id="allsend" style="float: left">--}}
<select name="openid" class="openid">
    <option>请选择要添加的标签</option>
    @foreach($tag as $k=>$v)
        <option value="{{$v->id}}">{{$v->name}}</option>&nbsp;&nbsp;
    @endforeach
</select>
<br>
<textarea name="content" id="content" cols="30" rows="10" placeholder="非必填"></textarea>
<br>
<input type="button" value="确定群发" id="truesend">
</body>
</html>
<script>
    $(function () {
        //点击标签获取改标签下的用户
        $(document).on('click','.tag',function () {
            $(this).css('background','#606f7b');
            $(this).siblings('input').css('background','');
        });

      //   //点击群发 显示要群发的标签
      //   $("#allsend").click(function () {
      //       $('.openid').css('display','block');
      //       $(this).css('display','none');
      // });
        //点击标签 选择发送内容
        $(".openid").change(function () {
           openid =  $(this).val();
        });
          //点击确定群发
          $("#truesend").click(function () {
              var content = $('#content').val();
              $.post(
                  "/admin/taggroupsend",
                  {openid:openid,content:content},
                  function (res) {
                     if(res == 1){
                         alert('该标签下暂无用户');
                     }
                  }
              );
          });
    })
</script>