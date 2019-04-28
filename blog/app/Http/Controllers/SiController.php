<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   //DB类
use App\Http\Requests\StoreBlogPost; //验证器验证
use Validator; //验证
use App\Blog; //model
class SiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 列表展示
     */
    public function index()
    {
        //搜索
        $query=request()->all();
        $where=[];
        $name=$query['name'] ?? '';
        if($name){
           $where[]=['name','like',"%$name%"];
        }
        $age=$query['age'] ?? '';
        if($age){
            $where['age']=$age;
        }
//        dd($where);
        //原生查询
//        $data = DB::select('select * from sihao');
        //构造器查询 +分页
        $data = DB::table('sihao')->where($where)->paginate(3);
        //ORM model
//        $Blog = new Blog;
//        $data=$Blog->where($where)->paginate(3);
//        dd($data);
        return view('si/lists',compact('data','name','age','query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 添加页面
     */
    public function create()
    {
        return view('si.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 添加执行
     */
//    public function store(Request $request)
    public function store(StoreBlogPost $request)//表单验证 第二种方法
    {
//表单验证 第一种方法
//        $request->validate([
//            'name'=>'required|unique:sihao|max:20|min:3',
//            'age'=>'required|integer'
//        ],[
//            'name.required'=>'姓名必填',
//            'name.unique'=>'该名称已存在',
//            'name.max'=>'姓名最大为20个字符',
//            'name.min'=>'姓名最小为3个字符',
//            'age.required'=>'年龄必填',
//            'age.integer'=>'年龄必须为数字',
//        ]);

//        第三种验证
//        $validator = Validator::make($request->all(),[
//                'name'=>'required|unique:sihao|max:20|min:3',
//                'age'=>'required|integer'
//            ],[
//                'name.required'=>'姓名必填',
//                'name.unique'=>'该名称已存在',
//                'name.max'=>'姓名最大为20个字符',
//                'name.min'=>'姓名最小为3个字符',
//                'age.required'=>'年龄必填',
//                'age.integer'=>'年龄必须为数字',
//            ]);
//        if ($validator->fails()) {
//            return redirect('/si/add')
//                ->withErrors($validator)
//                ->withInput();
//}
        $data = $request->only(['name','age','sex']);
//        dd($data);
        $data['img'] = $this->upload($request,'img');
//        dd($data);
        //原生sql添加
        //$res = DB::insert('insert into sihao (name,age,sex) values(?,?,?)',[$data['name'],$data['age'],$data['sex']]);
        //查询构造器添加
        //$res = DB::table('sihao')->insert($data);
        //ORM添加
        $Blog=new Blog;
        $Blog->name=$data['name'];
        $Blog->age=$data['age'];
        $Blog->sex=$data['sex'];
        $Blog->img=$data['img'];
        $res = $Blog->save($data);
//        dd($res);
        if($res){
            echo "<script>alert('添加成功');location.href='/si/index'</script>";
        }
//        dd($data);
    }
    //文件上传
    public function upload(Request $request,$name){
        if ($request->hasFile($name) && $request->file($name)->isValid()) {
            $photo = $request->file($name);
            $extension = $photo->extension();
            //$store_result = $photo->store('photo');
            $store_result = $photo->storeAs(date("Ymd"),date("YmdHis").rand(100,999).'.'.$extension);
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 修改
     */
    public function edit($id)
    {
        //原生查询
        $data = DB::select("select * from sihao where id=$id");
        //构造器查询
//        $data = DB::table('sihao')->where('id',$id)->first();
        //ORM model
//        $Blog = new Blog;
//        $data=$Blog->find($id);
//dd($data);
        return view('si.upd',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 执行修改
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');
        $id=$data['id'];
        //根据id查找要修改的原来的图片路径
        $date = DB::table('sihao')->where('id',$id)->first();
        $img = $date->img;
        $path = storage_path('app/uploads/'.$img);
        //判断是否有文件上传  有
        if($request->hasFile('img')){
            $data['img'] = $this->upload($request,'img');
            $res = DB::update("update sihao set  name=?,sex=?,age=?,img=? where id=$id",[$data['name'],$data['sex'],$data['age'],$data['img']]);
            @unlink($path);
        }else{ // 无
            $res = DB::update("update sihao set  name=?,sex=?,age=? where id=$id",[$data['name'],$data['sex'],$data['age']]);
        }
        if($res){
            echo "<script>alert('修改成功');location.href='/si/index'</script>";
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 删除
     */
    public function destroy($id)
    {
        $data = DB::table('sihao')->where('id',$id)->first();
        //根据id查找要删除的图片路径
        $img = $data->img;
        $path = storage_path('app/uploads/'.$img);
        $a = @unlink($path);
        //删除数据库的数据
        $res = DB::delete("delete from sihao where id=$id ");
        if($res){
           echo "<script>alert('删除成功');location.href='/si/index'</script>";
//            return redirect('/si/list');
        }
    }
    //添加的ajax唯一性验证
    public function checkName()
    {
        $name = request()->name;
        if($name==''){
            return ['msg'=>'名称不能为空','code'=>3];
        }
        $count = DB::table('sihao')->where('name',$name)->count();
       if($count){
           return ['msg'=>'该名称已存在','code'=>2];
       }else{
           return ['msg'=>'该名称可用','code'=>1];
       }
    }

    public function text(){
//        request()->session()->put('name','zhangsan'); //调用请求实例的put方法设置session值 1
//        session(['ss'=>'lisi']);//通过全局辅助函数session设置session值 2
//        request()->session()->pull('ss');//删除session单条数据
//        request()->session()->forget('ss');//删除session单条数据
//        request()->session()->flush('ss');//删除session全部数据
//        echo request()->session()->get('ss','wangwu');//获取session值  第二个参数为接不到第一个参数时的默认值

        return response('hello world')->cookie('cookie','hahaha',1);//设置cookie值
        echo \request()->cookie('cookie');//获取cookie值
    }
    //注册
    public function register(){
        if(\request()->Post()) {
            $data = \request()->all();
            //表单验证
            \request()->validate([
                'username'=>'required|unique:user|max:20|min:3',
                'userpwd'=>'required',
                'userrepwd'=>'required',
            ],[
                'username.required'=>'用户名必填',
                'username.unique'=>'用户名已存在',
                'username.max'=>'用户名最大为20位字符',
                'username.min'=>'用户名最少为3位字符',
                'userpwd.required'=>'密码必填',
                'userpwd.required'=>'确认密码必填',
            ]);
            //进行密码encrypt加密
            $data['userpwd']=encrypt($data['userpwd']);
            unset($data['userrepwd']);
            //执行添加
            $res = DB::table('user')->insert($data);
            if($res){
                echo "<script>alert('注册成功');location='/login'</script>";
            }
        }else{
            return view('login.register');
        }
    }
    //登录
    public function login(){
        //判断是否是POST请求
        if(\request()->Post()){//是
            // 接收表单值
            $data = \request()->all();
            dd(encrypt($data['userpwd']));
            //根据表单值查找
            $res = DB::table('user')->where(['username'=>$data['username'],'userpwd'=>$data['userpwd']])->first();
            dd($res);
            //进行密码encrypt加密
            //执行添加
            //设置session值
            \request()->session()->put('user',$data['username']);
            if($res){
                echo "<script>alert('登陆成功');location='/si/index'</script>";
            }
        }else{//否 显示表单
            return view('login.login');
        }

    }

}
