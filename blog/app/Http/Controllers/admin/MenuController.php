<?php

namespace App\Http\Controllers\admin;

use App\Model\Menu;
use App\Wxshop\wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * @content 创建菜单
     * */

    public function cteatemenu()
    {
        if(\request()->Post()){//检测是否是POST方式提交
            $data = \request()->all();
            if($data['type'] == '0'){//判断是否选择菜单类型
                echo "<script>alert('请选择添加菜单的类型');location.href='/admin/cteatemenu'</script>";die;
            }
            if($data['pid'] == 0){//判断添加的是否是一级菜单
                $reg = '/^[(\x{4e00}-\x{9fa5})]{1,4}$/u';
                if(preg_match($reg,$data['name'])){//正则验证名称是否为汉字
                    $res = DB::table('menu')->insert($data);
                }else{//不是汉字
                    echo "<script>alert('一级菜单名称为汉字且最多四个汉字');location.href='/admin/cteatemenu'</script>";die;
                }
            }else{//不是一级菜单
                $count = DB::table('menu')->where(['pid'=>$data['pid']])->count();
                if($count >= 5){//判断次一级菜单下是否已满 是
                    echo "<script>alert('此一级菜单已满，换个菜单试试吧');location.href='/admin/cteatemenu'</script>";
                }else{ //不满
                    $reg = '/^[(\x{4e00}-\x{9fa5})]{1,}$/u';
                    if(preg_match($reg,$data['name'])){//正则验证名称是否为汉字
                        $res = Menu::insert($data);
                        //$res = DB::table('menu')->insert($data);
                    }else{//不是汉字
                        echo "<script>alert('二级菜单名称为汉字');location.href='/admin/cteatemenu'</script>";die;
                    }
                }
            }
            if($res){
                echo "<script>alert('添加成功');location.href='/admin/cteatemenu'</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/admin/cteatemenu'</script>";
            }
        }else{
            //查询pid=0的以及菜单
            $data = DB::table('menu')->where(['pid'=>0,'status'=>1])->get()->toArray();
            return view('admin/menu/cteatemenu',['data'=>$data,'count'=>count($data)]);
        }

    }

    /**
     * @content 菜单列表
     * */
    public function menulist()
    {
        $data = DB::table('menu')->where(['pid'=>0,'status'=>1])->get()->toArray();
        return view('admin/menu/menulist',['data'=>$data]);
    }
    /*
     * @content 获取二级菜单
     * */
    public function twomenu($id)
    {
        $data = DB::table('menu')->where(['pid'=>$id,'status'=>1])->get();
        return $data;
    }

    /**
     * @content 菜单删除
     * */
    public function delmenu($id)
    {
        //判断该菜单下是否有子菜单
        $data = DB::table('menu')->where('pid',$id)->first();
        if(empty($data)){
            $res = DB::table('menu')->where('id',$id)->update(['status'=>2]);
            if($res){
                echo "<script>alert('删除成功');location.href='/admin/menulist'</script>";
            }else{
                echo "<script>alert('删除失败');location.href='/admin/menulist'</script>";
            }
        }else{
            echo "<script>alert('此菜单下还有子菜单，不能删除');location.href='/admin/menulist'</script>";
        }
    }

    /**
     * @content 菜单修改
     * */
    public function updmenu($id)
    {
        //父类菜单下拉框的值
        $date = DB::table('menu')->where(['pid'=>0,'status'=>1])->get()->toArray();
        //要修改的id内容
        $data = DB::table('menu')->where('id',$id)->first();
        return view('admin/menu/updmenu',['data'=>$data,'date'=>$date,'count'=>count($date)]);
    }

    /**
     * @content 菜单执行修改
     * */
    public function upddomenu()
    {
        $data = \request()->all();
        if (count($data) == 2) {//判断修改的是否是一级菜单 是
            $reg = '/^[(\x{4e00}-\x{9fa5})]{1,4}$/u';
            if(preg_match($reg,$data['name'])){//正则验证名称是否为汉字
                $res = DB::table('menu')->where('id', $data['id'])->update(['name' => $data['name']]);
            }else{//不是汉字
                echo "<script>alert('一级菜单名称为汉字且最多四个汉字');location.href='/admin/cteatemenu'</script>";die;
            }
        } else { // 不是一级菜单
            if ($data['pid'] == 0) {//判断是否修改为一级菜单 是
                $res = DB::table('menu')->where('id', $data['id'])->update($data);
            } else {//不是
                $count = DB::table('menu')->where(['pid' => $data['pid']])->count();
                if ($count >= 5) {//判断该一级菜单下是否已满 是
                    echo "<script>alert('此一级菜单已满，换个菜单试试吧');location.href='/admin/updmenu'</script>";
                } else { //不是 修改
                    $reg = '/^[(\x{4e00}-\x{9fa5})]{1,}$/u';
                    if(preg_match($reg,$data['name'])){//正则验证名称是否为汉字
                        $res = DB::table('menu')->where('id', $data['id'])->update($data);
                    }else{//不是汉字
                        echo "<script>alert('二级菜单名称为汉字');location.href='/admin/cteatemenu'</script>";die;
                    }
                }
            }
        }

        if ($res !== false) {
            echo "<script>alert('修改成功');location.href='/admin/menulist'</script>";
        } else {
            echo "<script>alert('修改失败');location.href='/admin/menulist'</script>";
        }
    }

    /**
     * @content 创建菜单接口
     * */
    public function cteatemenujog()
    {
        //一级菜单
        $data = Menu::where('status',1)->get()->toArray();
        $menuinfo = [];
        foreach ($data as $k=>$v){//查询全部菜单
            if($v['pid'] == 0){//判断是否是一级菜单
                $res = Menu::where(['pid'=>$v['id'],'status'=>1])->get()->toArray();//查询一级菜单下是否有二级菜单
                if(empty($res)){//空
                    if($v['type'] == 'click'){
                        $menuinfo[] =[
                            'type'=>'click',
                            'name'=>$v['name'],
                            'key'=>$v['key']
                        ];
                    }else if ($v['type'] == 'view'){
                        $menuinfo[] =[
                            'type'=>'view',
                            'name'=>$v['name'],
                            'url'=>'http://'.$v['url']
                        ];
                    }
                }else{//有
                    $menuarr = [];
                    foreach ($res as $key => $val){//循环二级菜单存入数组中
                        if($val['type'] == 'click'){
                            $menuarr[] =[
                                'type'=>'click',
                                'name'=>$val['name'],
                                'key'=>$val['key']
                            ];
                        }else if ($val['type'] == 'view'){
                            $menuarr[] =[
                                'type'=>'view',
                                'name'=>$val['name'],
                                'url'=>'http://'.$val['url']
                            ];
                        }
                    }
                    //把一级和二级菜单拼接起来
                    $menuinfo[] = [
                        'name'=>$v['name'],
                        'sub_button'=>$menuarr
                    ];
                }

            }
        }
        //拼接成完整数组
        $postjson = [
            'button'=>$menuinfo
        ];
      $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
      $postjson = json_encode($postjson,JSON_UNESCAPED_UNICODE);
      $res = wechat::HttpPost($url,$postjson);
      if($res['errcode'] == 0){
          echo "<script>alert('启用成功');location.href='/admin/menulist'</script>";
      }else{
          echo "<script>alert('启用失败');location.href='/admin/menulist'</script>";
      }
    }
    
    /**
     * @content 删除菜单接口
     * */
    public function delmenujog()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $res = file_get_contents($url);
        $res = json_decode($res,true);
        if($res['errcode'] == 0){
            echo "<script>alert('删除成功');location.href='/admin/menulist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/admin/menulist'</script>";
        }
    }
    /**
     * @content 查询菜单接口
     * */
    public function selectmenujog()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $res = file_get_contents($url);
        dd($res);
    }

    /**
     * @content 创建个性化菜单
     */
    public function createpersonmenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $datajson = [
            'button'=>[
                [
                    'type'=>'view',
                    'name'=>'体育新闻',
                    'url'=>'http://sports.qq.com'
                ],
                [
                    'name'=>'视频推荐',
                    'sub_button'=>[
                        [
                            'type'=>'view',
                            'name'=>'斗罗大陆',
                            'url'=>'http://v.baidu.com/comic/20714.htm?&q=斗罗大陆'
                        ],
                        [
                            'type'=>'view',
                            'name'=>'自杀小队(严厉惩罚) ',
                            'url'=>'http://v.baidu.com/movie/135386.htm?&q=自杀小队'
                        ]
                    ]
                ]
            ],
            'matchrule'=>[
                'sex'=>1
            ]
        ];
        $postjson = json_encode($datajson,JSON_UNESCAPED_UNICODE);
        $re = wechat::HttpPost($url,$postjson);
        dd($re);
    }
}

