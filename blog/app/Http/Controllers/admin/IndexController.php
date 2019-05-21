<?php

namespace App\Http\Controllers\admin;

use App\Wxshop\wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Psy\Util\Json;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 返回添加的视图
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 登录 及 登录视图
     */
    public function login()
    {
        if(\request()->Post()){
            $tel = \request()->username;
            $password= \request()->password;
            $data = DB::table('user')->where('tel',$tel)->first();
            if($data){
                if($password != decrypt($data->password)){
                    echo "<script>alert('密码或用户名错误');location.href='/admin/login'</script>";
                }else{
                    \request()->session()->put('wechat',$tel);
                    echo "<script>alert('登录成功');location.href='/admin'</script>";
                }
            }else{
                echo "<script>alert('该用户不存在');location.href='/admin/login'</script>";
            }
        }else{
            return view('admin/login');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 添加关注回复信息到数据库
     */
    public function add()
    {
        if(\request()->Post()){
//            dd(\request()->all());
            $type = \request()->type;
            $mateial = self::addMeateial($type);
//            dd($type);
            $content = \request()->input('content',null);
            $title = \request()->input('title',null);
            $desc = \request()->input('desc',null);
            $returnurl = \request()->input('url',null);
            $create_time = time();
//dump(\request()->hasFile('material'));
            if(\request()->hasFile('material')){
                $data = $this->GetMediaId();
//                dd($data);
                $media_id = $data['media_id'];
                $url = $data['url'] ?? '';
//                dd($media_id);
                $all=['type'=>$type,'content'=>$content,'media_id'=>$media_id,'create_time'=>$create_time,'title'=>$title,'desc'=>$desc,'url'=>$url,'returnurl'=>$returnurl];
//                dd($all);
            }else{
                $all=['type'=>$type,'content'=>$content,'create_time'=>$create_time];
            }
            $data = DB::table('huifu')->insert($all);
            if($data){
                echo "<script>alert('添加成功');location.href='/admin/add'</script>";
            }else{
                echo "<script>alert('添加失败');location.href='/admin/add'</script>";
            }
        }else{
            return view('admin/material/add');
        }

    }

    /**
     * @return bool|mixed|string 返回 media_id
     */
    public function GetMediaId()
    {
        $file = \request()->material;
//dd($file);
        $data = wechat::UploadsFile($file);
        $ext = $data['ext'];
        $path = storage_path().$data['path'];
//                dd($path);
        //获取access_token  type
        $token = json_decode(wechat::GetAccessToken(),true)['access_token'];
        //获取类型
        $type = wechat::GetMaterialType($ext);
        //上传链接
//        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
        //  CURLFile 专门为文件提交封装的类
        $data =['media'=>new \CURLFile(realpath($path))];
//                dd($data);
        $re = wechat::HttpPost($url,$data); //"media_id"=>"w8Ao_cMidz6xrB0ERSHM3WfnHP5DwksErmespAeINR4G41AHo0W82lUnDkEobLGm"
        return $re;
    }

    /**
     * @param $type 素材的添加
     * @return bool 成功 true 失败 false
     */
    public function addMeateial($type)
    {
//        $type='image';
        $num = DB::table('material')->where('type',$type)->count();
        $token = json_decode(Wechat::GetAccessToken(),true)['access_token'];
        $url= "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token";
        $postdata = [
            'type'=>$type,
            'offest'=>$num,
            'count'=>20
        ];
//        dd($postdata);
        $json =json_encode($postdata,JSON_UNESCAPED_UNICODE);
//        dd($json);
        $info = Wechat::HttpPost($url,$json);
        $count = $info['item_count'];
       for ($i=0;$i<=$count-1;$i++){
          $info['item'][$i]['type']=$type;
       }
//       dd($info);
        $res = DB::table('material')->insert($info['item']);
       if($res){
           return true;
       }else{
          return false;
       }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 首次关注回复类型
     */
    public function settype()
    {
        if(\request()->Post()){
            $type = \request()->type;
            $array = [
                'responsetype'=>$type
            ];
            $arr = '<?php return '.var_export($array,true).'?>';
//        dd($arr);
            $path =config_path()."/wechat.php";
//        dd($path);
            $settype = file_put_contents($path,$arr);
            if($settype == 52 || $settype == 53){
                echo "<script>alert('设置成功');location.href='/admin/settype'</script>";
            }else{
                echo "<script>alert('设置失败');location.href='/admin/settype'</script>";
            }
        }else{
            $type = config('wechat.responsetype');
            return view('admin/material/settype',compact('type'));
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 首次关注回复素材列表
     */
    public function medialist()
    {
        $request = $_GET;
        $type = \request()->type ?? '';
        $where = [];
        if($type){
            $where[] =['type','=',$type];
        }
        $data = DB::table('material')->where($where)->paginate(3);
       return view('admin/material/medialist',['data'=>$data,'type'=>$type,'request'=>$request]);
    }

    /**
     * @content 首次回复的修改
     * @param $id 要修改的id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View 修改的页面
     */
    public function mediaupd($id)
    {
        $data = DB::table('huifu')->where('id',$id)->first();
//        dd($data);
        return view('admin/material/mediaupd',['data'=>$data]);
    }

    /**
     * @content 素材列表删除
     * @param $id 要删除的id
     */
    public function mediadel($id)
    {
        $data = DB::table('material')->where('id',$id)->delete();
        if($data){
            echo "<script>alert('删除成功');location.href='/admin/medialist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/admin/medialist'</script>";
        }

    }

}
