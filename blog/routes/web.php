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

//Route::get('/', function () {
////    Schema::table('sihao', function ($table) {
////        $table->softDeletes();
////    });
//    return view('welcome');
//});
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
//微店
route::get('/','ZhuBaoController@index');
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
    //微信授权登录
    route::any('wxlogin','ZhuBaoController@wxlogin');
    route::any('getcode','ZhuBaoController@getcode');
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

route::any('wxshop','WxController@wxshop');
    //X-Admin后台 微信首次关注回复设置
route::prefix('/admin')->group(function(){
    route::any('/','admin\IndexController@index');//后台主页
    route::any('/add','admin\IndexController@add');//首次关注内容添加
    route::any('/settype','admin\IndexController@settype');//设置首次关注回复类型
    route::any('/medialist','admin\IndexController@medialist');//首次关注回复素材列表
    route::any('/mediaupd/{id}','admin\IndexController@mediaupd');//素材列表修改
    route::any('/mediadel/{id}','admin\IndexController@mediadel');//素材列表删除
    route::any('/index','admin\GroupController@index');//群发列表
    route::any('/groupsend/{openid}','admin\GroupController@groupsend');//根据openid群发发送
    route::any('/taggroupsend','admin\GroupController@taggroupsend');//根据标签群发发送

    route::any('/cteatetag','admin\GroupController@cteatetag');//创建标签
    route::any('/taglist','admin\GroupController@taglist');//标签列表
    route::any('/alltaglist','admin\GroupController@alltaglist');//所有标签以及粉丝列表
    route::any('/tagdel/{tagid}','admin\GroupController@tagdel');//标签删除
    route::any('/settagforuser','admin\GroupController@settagforuser');//批量为用户添加标签

    route::any('/cteatemenu','admin\MenuController@cteatemenu');//创建菜单
    route::any('/menulist','admin\MenuController@menulist');//菜单列表
    route::any('/twomenu/{id}','admin\MenuController@twomenu');//菜单列表
    route::any('/delmenu/{id}','admin\MenuController@delmenu');//菜单删除
    route::any('/updmenu/{id}','admin\MenuController@updmenu');//菜单修改
    route::any('/upddomenu','admin\MenuController@upddomenu');//菜单执行修改

    route::any('/cteatemenujog','admin\MenuController@cteatemenujog');//创建菜单接口
    route::any('/delmenujog','admin\MenuController@delmenujog');//删除菜单接口
    route::any('/selectmenujog','admin\MenuController@selectmenujog');//查询菜单接口

    route::any('/createpersonmenu','admin\MenuController@createpersonmenu');//创建个性化菜单

    route::any('/bindingdo','ZhuBaoController@bindingdo');//授权用户绑定
});
route::any('/admin/login','admin\IndexController@login');
route::any('text','admin\IndexController@text');
route::any('retype','admin\IndexController@setResponseType');
route::any('addMeateial/{type}','admin\IndexController@addMeateial');
