<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
// 请求时候带api前缀

/* newly add routes */
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('admin/login', 'UserController@login');//alias
Route::post('admin/register', 'UserController@register');//alias
Route::get('/goods/cats/get', 'Pdd\IndexController@goodsCatsGet');
Route::get('/user/white/list', 'UserController@whiteList');
// 允许外部直接调用without token
// Route::get('/pdd/order/list/range/get', 'Pdd\IndexController@orderListRangeGet');

// mix
Route::group(['middleware' => 'auth.jwt'], function () {
    //Route::post('logout', 'UserController@logout');
    //Route::post('admin/logout', 'UserController@logout');//alias

    Route::get('user', 'UserController@getAuthUser');
    Route::get('user/refresh', 'UserController@refresh');
    Route::get('admin/user/refresh', 'UserController@refresh');//alias
    Route::post('/user/submit/wx', 'UserController@submitWx');
    Route::post('/user/submit/mobile', 'UserController@submitMobile');
    Route::post('/user/withdraw', 'WithdrawController@postWithdraw');
    Route::get('/user/withdraw', 'WithdrawController@getWithdraw');
    Route::get('/user/get/parent', 'UserController@parentUser');
    Route::get('/get/user/by/id', 'UserController@getUserById');

    Route::get('/judge/newbie', 'UserController@isNewbie');

    Route::get('/material', 'MaterialController@index');
    Route::get('/material/goods', 'MaterialController@goods');
    Route::get('/material/goods/images', 'MaterialController@goodsImages');

    Route::get('faq/faqs', 'FaqController@faqs');

    Route::get('/position/home/top/swiper', 'PositionController@homeTopSwiper');
    Route::get('/position/messages', 'PositionController@messages');

    Route::post('/mp/update/user/info', 'MpController@updateUserInfo');
    Route::post('/mp/decode/share/info', 'MpController@decodeShareInfo');
    Route::get('/mp/get/user/by/mp/open/id', 'MpController@getUserByMpOpenId');
    Route::get('/mp/ensure/relationship', 'MpController@ensureRelationship');
    Route::post('/search/history/record', 'SearchHistoryController@record');
    Route::get('/search/hot/words', 'SearchHistoryController@hotWords');
    Route::get('/f/rate', 'UserController@fRate');
    Route::get('/f/level', 'UserController@fLevel');
    Route::get('/pdd/order/status', 'UserController@pddOrderStatus');
    Route::get('/user/wallet', 'WalletController@index');
    Route::get('/user/wallet/types', 'WalletController@types');
    Route::get('/user/wallet/details', 'WalletController@details');
    Route::post('/user/collect/goods', 'CollectGoodsController@postCollectGoods');
    Route::get('/user/collect/goods', 'CollectGoodsController@getCollectGoods');
    Route::post('/user/visit/history', 'VisitHistoryController@postVisitHistory');
    Route::get('/user/visit/history', 'VisitHistoryController@getVisitHistory');
});
// activity
Route::group(['middleware' => 'auth.jwt', 'prefix'=>'activity'], function () {
    Route::get('list', 'ActivityController@activityList');
    Route::get('activity', 'ActivityController@activity');
    Route::post('/create/tuan/order', 'ActivityController@createTuanOrder');
    Route::post('/vote/tuan/order', 'ActivityController@voteTuanOrder');
});
Route::group(['prefix'=>'activity'], function () {
    Route::get('/zero/benifits', 'ActivityController@zeroBenifits');
});
// pdd
// 'middleware' => 'auth.jwt',
Route::group(['prefix'=>'pdd', 'namespace'=>'Pdd'],function(){
    //多多进宝商品查询(关键字)
    Route::get('/goods/search', 'IndexController@goodsSearch');
    //获取推广位列表
    Route::get('/goods/pid/query', 'IndexController@goodsPidQuery');
    //获取拼多多系统时间
    Route::get('/time/get', 'IndexController@timeGet');
    //多多客获取爆款排行商品接口
    Route::get('/top/goods/list/query', 'IndexController@topGoodsListQuery');
    //查询多多进宝主题列表
    Route::get('/theme/list/get', 'IndexController@themeListGet');
    //多多进宝主题商品查询
    Route::get('/theme/goods/search/{theme_id}', 'IndexController@themeGoodsSearch');
    //查询订单详情
    Route::get('/order/detail/get/{order_sn}', 'IndexController@orderDetailGet');
    //多多客生成转盘抽免单
    Route::get('/lottery/url/gen', 'IndexController@lotteryUrlGen');
    //生成红包推广链接
    Route::get('/rp/prom/url/generate', 'IndexController@rpPromUrlGenerate');
    //商品标准类目接口
    Route::get('/goods/cats/get', 'IndexController@goodsCatsGet');
    //查询商品标签列表
    Route::get('/goods/opt/get', 'IndexController@goodsOptGet');
    //生成商城-频道推广链接 - 生成的是http的URL格式 目前不知道怎么在小程序里面用
    Route::get('/cms/prom/url/generate', 'IndexController@cmsPromUrlGenerate');

    Route::get('/order/list/range/get', 'IndexController@orderListRangeGet');

});
Route::group(['middleware' => 'auth.jwt', 'prefix'=>'pdd', 'namespace'=>'Pdd'],function(){
    //多多进宝推广链接生成
    Route::get('/goods/promotion/url/generate', 'IndexController@goodsPromotionUrlGenerate');
});
// admin
Route::group(['middleware' => 'auth.jwt', 'prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::get('/activity/list', 'ActivityController@activityList');
    Route::post('/activity/add', 'ActivityController@add');
    Route::post('/activity/save', 'ActivityController@save');
    Route::get('/activity/page', 'ActivityController@page');
    Route::get('/activity/activity', 'ActivityController@activity');
    Route::post('/activity/gallery/delete', 'ActivityController@galleryDelete');
    Route::get('/activity/types', 'ActivityController@types');
    Route::get('/activity/applicables', 'ActivityController@applicables');
    Route::get('/activity/status', 'ActivityController@status');
    Route::post('/activity/delete', 'ActivityController@delete');
    Route::post('/attach/goods', 'ActivityController@attachGoods');

    Route::get('/pdd/orders', 'ActivityController@types');


    Route::post('/file/upload', 'UploadController@index');

    Route::any('/privileges/roles', 'PrivilegesController@roles');
    Route::any('/privileges/save/role', 'PrivilegesController@saveRole');
    Route::any('/privileges/delete/role/{id}', 'PrivilegesController@deleteRole');
    Route::any('/privileges/role/users/{id}', 'PrivilegesController@roleUsers');
    Route::any('/privileges/permissions/tree', 'PrivilegesController@permissionsTree');
    Route::any('/privileges/role/permissions', 'PrivilegesController@rolePermissions');
    Route::post('/privileges/add/permission', 'PrivilegesController@addPermission');
    Route::post('/privileges/edit/permission', 'PrivilegesController@editPermission');
    Route::post('/privileges/delete/permission', 'PrivilegesController@deletePermission');
    Route::post('/privileges/remove/role/model', 'PrivilegesController@removeRoleModel');
    Route::post('/privileges/give/permissions/to', 'PrivilegesController@givePermissionsTo');
    Route::any('/privileges/user/permissions', 'PrivilegesController@userPermissions');

    Route::post('/user/create', 'UserController@create');
    Route::post('/user/create/role/user', 'UserController@createRoleUser');

    Route::group(['namespace'=>'Cms'], function(){
        Route::any('/cms/channel/tree', 'ChannelController@tree');
        Route::any('/cms/channel/add', 'ChannelController@add');
        Route::any('/cms/channel/update', 'ChannelController@update');
        Route::any('/cms/channel/children', 'ChannelController@children');
        Route::any('/cms/model/field/types', 'FieldTypeController@index');
        Route::any('/cms/model/field/type/add', 'FieldTypeController@add');

        Route::any('/cms/model', 'ModelController@index');
    });
});