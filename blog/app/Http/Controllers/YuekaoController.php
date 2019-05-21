<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class YuekaoController extends Controller
{
    public function login(){
        return view('yuekao.login');
    }
    public function logindo(){
        $all = \request()->all();
        $data = DB::table('user')->where(['tel'=>$all['name']])->first();
        //dump(encrypt($all['password']));
//        dd(decrypt($data->password));
        if($all['password'] != decrypt($data->password)){
            echo "<script>alert('登录失败');location.href='login'</script>";
        }else{
            session(['user'=>$data]);
            echo "<script>alert('登录成功');location.href='add1'</script>";
        }
    }

    public function add(){
        return view('yuekao.add');
    }
    public function adddo(){
        $name = \request()->name;
        return view('yuekao.add2',['name'=>$name]);
    }
    public function add2(){
        $xuanxiang = \request()->xuanxiang;
        $name = \request()->name;
        $artisan = \request()->artisan;
        if($xuanxiang == 1){
            return view('yuekao.add3',compact('name','artisan'));
        }else{
            return view('yuekao.add4',compact('name','artisan'));
        }

    }
    public function add3(){
        $all = \request()->all();
        $data = DB::table('kaoshi')->insert($all);
        if($data){
                echo "<script>alert('提交成功');location.href='list'</script>";
        }else{
                echo "<script>alert('提交失败');location.href='add3'</script>";
            }
    }
    public function add4(){
        $all = \request()->all();
        $data = DB::table('kaoshi')->insert($all);
        if($data){
            return 1;
        }else{
            return 2;
        }
    }
    public function lists(){
        $data = DB::table('kaoshi')->where('detail',1)->paginate(5);
       return view('yuekao.lists',compact('data'));
    }

    public function detail($id){
        $data = DB::table('kaoshi')->where(['id'=>$id])->first();
        return view('yuekao.detail',compact('data'));
    }
    public function del($id){
        $data = DB::table('kaoshi')->where(['id'=>$id])->update(['detail'=>2]);
        if($data){
            echo "<script>alert('删除成功');location.href='/list'</script>";
        }else{
            echo "<script>alert('删除失败');location.href='/list'</script>";
        }
    }
}
