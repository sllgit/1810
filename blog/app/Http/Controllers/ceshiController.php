<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   //DB类
use App\Http\Requests\StoreCeShiPost; //验证器验证

class ceshiController extends Controller
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
        //构造器查询 +分页
        $data = DB::table('ceshi')->where($where)->paginate(3);
        return view('ceshi/lists',compact('data','name','query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 添加页面
     */
    public function create()
    {
        return view('ceshi.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 添加执行
     */
//    public function store(Request $request)
    public function store(StoreCeShiPost $request)//表单验证 第二种方法
    {
        $data = $request->only(['name','url','type','people','content','isshow']);
        $data['logo'] = $this->upload($request,'logo');
        //查询构造器添加
        $res = DB::table('ceshi')->insert($data);
        if($res){
            echo "<script>alert('添加成功');location.href='/ceshi/index'</script>";
        }
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
        //构造器查询
        $data = DB::table('ceshi')->where('id',$id)->first();
        return view('ceshi.upd',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 执行修改
     */
    public function update(StoreCeShiPost $request)
    {
        $data = $request->except('_token');
        $id=$data['id'];
        if($request->hasFile('logo')) {
            $data['logo'] = $this->upload($request, 'logo');
        }
        $res = DB::table('ceshi')->where('id',$id)->update($data);
//        dd($res);
        if($res!==false){
            echo "<script>alert('修改成功');location.href='/ceshi/index'</script>";
        }else{
            echo "<script>alert('修改失败');location.href='/ceshi/index'</script>";
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
        $data = DB::table('ceshi')->where('id',$id)->first();
//        //根据id查找要删除的图片路径
//        $logo = $data->logo;
//        $path = storage_path('app/uploads/'.$logo);
//        $a = @unlink($path);
        //删除数据库的数据
        $res = DB::delete("delete from ceshi where id=$id ");
//        dd($res);
        if($res){
           echo "<script>alert('删除成功');location.href='/ceshi/index'</script>";
//            return redirect('/si/list');
        }
    }
    //添加的ajax唯一性验证
    public function checkName()
    {
        $name = request()->name;
        $id = request()->id;
//        dd($name);
        if($name==''){
            return ['msg'=>'名称不能为空','code'=>3];
        }
        if($id==0){
            $where=[
                ['name','=',$name]
            ];
        }else{
            $where=[
                ['id','!=',$id],
                ['name','=',$name]
            ];
        }

        $count = DB::table('ceshi')->where($where)->count();
       if($count){
           return ['msg'=>'该名称已存在','code'=>2];
       }else{
           return ['msg'=>'该名称可用','code'=>1];
       }
    }


}
