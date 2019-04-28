<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    Schema::table('sihao', function ($table) {
//        $table->softDeletes();
//    });
    return view('welcome');
});
//闭包传参
//Route::get('/index',function (){
//    return 123;
//});
//路由传参
//Route::get('/index','IndexController@index');
//post 419
//Route::get('/post',function(){
//    return '<form action="/do" method="post"><input type="text" name="name"><button>提交</button></form>';
//});
//Route::post('/do','IndexController@dos');

//可选参数
//Route::get('/text/{id}','IndexController@text')->where('id','\d+');

////auth验证
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('/si')->middleware('islogin')->group(function(){
    route::get('add','SiController@create');//添加
    route::any('list','SiController@store');//添加执行
    route::get('index','SiController@index');//列表展示
    route::get('del/{id}','SiController@destroy');//删除
    route::get('edit/{id}','SiController@edit');//修改
    route::post('update','SiController@update');//修改执行
    route::post('checkName','SiController@checkName');//唯一性验证
    route::get('text','SiController@text');//session测试
});
////登录
//Route::any('/login','SiController@login');
////注册
//Route::any('/register','SiController@register');
//


//测试添加页面
Route::prefix('/ceshi')->middleware('islogin')->group(function(){
    Route::any('add','ceshiController@create');
    route::post('checkName','ceshiController@checkName');//唯一性验证
    route::any('list','ceshiController@store');//添加执行
    route::get('index','ceshiController@index');//列表展示
    route::get('del/{id}','ceshiController@destroy');//删除
    route::get('edit/{id}','ceshiController@edit');//修改
    route::post('update','ceshiController@update');//修改执行
});
//session
Route::get('/text',function (){
    request()->session()->put('user',123);
//    return 123;
});

//珠宝商城 主页
Route::prefix('/zhubao')->group(function(){
    //微店 注册
    route::any('register','ZhuBaoController@register');
    //手机号获取验证码
    route::post('getcode','ZhuBaoController@telgetcode');
    //邮箱获取验证码
    route::post('emailgetcode','ZhuBaoController@emailgetcode');
    //微店 登录
    route::any('login','ZhuBaoController@login');
    //微店
    route::get('/','ZhuBaoController@index');
        //商品详情
        route::get('detail/{id}','ZhuBaoController@detail');

        //获取总价格
        route::any('getallprice','ZhuBaoController@getallprice');

      //所有商品
    route::any('allshop/{id?}','ZhuBaoController@allshop');
    //所有商品+条件
    route::any('allshops','ZhuBaoController@allshops');

    //购物车
    route::get('car','ZhuBaoController@car');
        //加入购物车
        route::any('addcar/{id}','ZhuBaoController@addcar');
        //删除购物车
        route::any('delcart','ZhuBaoController@delcart');
        //结算
        route::any('pay/{id}','ZhuBaoController@pay');
        //提交订单
        route::any('paydo','ZhuBaoController@paydo');
        //去支付
        route::any('gopay/{id}','ZhuBaoController@gopay');
        //同步跳转
        route::any('returnpay','ZhuBaoController@treturn');
        //异步跳转
        route::any('notify','ZhuBaoController@notify');
            //新增收货地址
            route::any('address/{id?}','ZhuBaoController@address');
            //地址新增执行
            route::any('addaddress','ZhuBaoController@addaddress');
            //修改地址
            route::any('updaddress/{id}','ZhuBaoController@updaddress');
            //执行修改地址
            route::any('upddoaddress','ZhuBaoController@upddoaddress');
            //删除地址
            route::any('deladdress/{id}','ZhuBaoController@deladdress');
            //收货地址列表
            route::any('addresslist','ZhuBaoController@addresslist');
        //提交订单
        route::get('success','ZhuBaoController@success');
    //我的
    route::get('user','ZhuBaoController@user');
        //我的订单
        route::get('order','ZhuBaoController@order');
        //取消订单
        route::post('delorder/{id}','ZhuBaoController@delorder');
        //我的收藏
        route::get('shoucang','ZhuBaoController@shoucang');
        //我的优惠券
        route::get('quan','ZhuBaoController@quan');
        //余额提现
        route::get('tixian','ZhuBaoController@tixian');
        //退出登陆
        route::get('editlogin','ZhuBaoController@editlogin');
});
//短信发送
//route::get('sendses','ZhuBaoController@sendSes');
//route::get('text','ZhuBaoController@text');


route::any('list','ZhuBaoController@lists');//测试列表
route::any('detail/{id}','ZhuBaoController@details');//详情
route::any('del/{id}','ZhuBaoController@del');//删除
route::any('upd/{id}','ZhuBaoController@upd');//修改
route::any('upddo','ZhuBaoController@upddo');//修改执行