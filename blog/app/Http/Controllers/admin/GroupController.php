<?php

namespace App\Http\Controllers\admin;

use App\Wxshop\wechat;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GroupController extends Controller
{
    /*
     * @content 群发列表
     * */
    public function index()
    {
       $openid = wechat::GetOpenIDlist();
       for ($i=0;$i<count($openid);$i++){
           $data = DB::table('openid')->where(['openid'=>$openid[$i]])->first();
           if(!$data){
               DB::table('openid')->insert(['openid'=>$openid[$i]]);
           }
       }
        $users = DB::table('openid')->get();
       //所有标签
        $tag = DB::table('alltag')->get()->toArray();
       return view('admin/material/openlist',compact('openid','tag'));
    }

    /*
     * @content 根据openid群发发送
     * */
    public function groupsend($openid)
    {
        $openid = explode(',',$openid);
//        dump($openid);
        $content = '这是群发消息测试';
        $data = [
            'touser'=>$openid,
            'msgtype'=>'text',
            'text'=>[
                'content'=>$content
            ]
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
//        dd($data);
        $token = json_decode(wechat::GetAccessToken(),true)['access_token'];
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$token";
         dump(wechat::HttpPost($url,$data));
    }
    
    /*
     * @content 根据标签群发发送
     * */
    public function taggroupsend()
    {
        $all = \request()->all();
        $openid = $all['openid'];
        $res = DB::table('alltag')->where('id',$openid)->select('count')->first();
        if($res->count == 0){
            return 1;
        }else{
            $content = $all['content']?? "这是根据标签群发测试";
            $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
            $data =[
                "filter"=>[
                    "is_to_all"=>false,
                    'tag_id'=>$openid
                ],
                "text"=>[
                    "content"=>$content
                ],
                "msgtype"=>"text"
            ];
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
            $re = wechat::HttpPost($url,$data);
            dd($re);
        }

    }
    

    /*
     * @content 创建表签
     * */
    public function cteatetag()
    {
        if(\request()->Post()){
            $tagname = \request()->tagname;
            $token = json_decode(wechat::GetAccessToken(),true)['access_token'];
            $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".$token;
            $postdata = [
                "tag" =>[
                 "name" => $tagname
                 ],
             ];
            $postdata = json_encode($postdata,JSON_UNESCAPED_UNICODE);
            //$jsondata =  json_encode(wechat::HttpPost($url,$postdata),JSON_UNESCAPED_UNICODE);
            $jsondata = wechat::HttpPost($url,$postdata);
//            dump($jsondata);
            $tagid = $jsondata['tag']['id'];
            $path = public_path()."/taglist/".$tagid.".php";
            touch($path);//把标签id作为文件名创建文件
            self::taglist();//将标签添加到数据库
        }else{
            return view('admin/tag/createtag');
        }
    }

    /*
     * @content 获取标签列表 存入数据库
     * */

    public function taglist()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $info = file_get_contents($url);
        $data = json_decode($info,true)['tags'];
//        dump($data);
        foreach($data as $k =>$v){
            $res = DB::table('alltag')->where(['id'=>$v['id']])->first();
            if($res){
                DB::table('alltag')->where(['id'=>$v['id']])->update(['id'=>$v['id'],'name'=>$v['name'],'count'=>$v['count']]);
            }else{
                DB::table('alltag')->insert($v);
            }
        }

    }
    
    /*
     * @content 所有标签以及标签下的用户展示
     * */

    public function alltaglist()
    {
        //查询所有标签
        $tag = DB::table('alltag')->get()->toArray();

        //查询标签下的用户


        return view('admin/tag/alltaglist',compact('tag'));
    }

    /*
     * @content 批量为用户打标签
     * */
    public function settagforuser()
    {
        $date = \request()->all();
        $tagid = $date['tagid'];
        $openid = explode(',',$date['openid']);
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $data = [
            'openid_list'=>$openid,
            'tagid'=>$tagid
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $re = wechat::HttpPost($url,$data);
        if($re['errcode'] == 0){
            //把openid存入对应标签中
            $fileName = public_path()."/taglist/".$tagid.".php";
            file_put_contents($fileName,$date['openid']);
            //修改数据库中对应的标签的count值
            DB::table('alltag')->where(['id'=>$tagid])->update(['count'=>count($openid)]);
            return 1;
        }else{
            return 2;
    }
    }

    /*
     * @content 删除标签
     * */
    public function tagdel($tagid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".json_decode(wechat::GetAccessToken(),true)['access_token'];
        $data ='{"tag":{"id":'.$tagid.'  } }';
        $re = wechat::HttpPost($url,$data);
        //删除数据库中的数据
        $res = DB::table('alltag')->where(['id'=>$tagid])->delete();
        //删除标签对应下的文件
        $path = public_path()."/taglist/".$tagid.".php";
        $unlink = unlink($path);
        if($re['errcode']==0 && $res && $unlink){
            echo "<script>alert('删除成功');location.href='/admin/alltaglist'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/admin/alltaglist'</script>";
        }
    }













}
