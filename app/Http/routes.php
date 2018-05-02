<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('front.front_index');
// });

// 初始页面第一个路由
Route::get('/','Front\IndexController@store');

// 分页
Route::get('/page/{page}','Front\IndexController@page');

// 我的动态
Route::get('/myAbout','Front\IndexController@myAboutStore');
// 查询
Route::post('search','Front\IndexController@search');

// 查看用户的个人中心
Route::get('/view/personal/{sUserID}','Front\IndexController@personal');


// 前台页面路由
Route::get('/front/login',function(){
	return view('front.front_login');
});
// 前台首页
// Route::get('/index','Front\CheckController@check');
// 用户名密码登录
Route::post('/front/check','Front\CheckController@check');
// 注册
Route::get('/front/register',function(){
	return view('front.front_registor');
});
// 注册保存
Route::post('/registor','Front\CheckController@edit');

// 登陆后操作路由

// 个人中心
Route::get('/personal/center','Front\PersonalController@store');
// 帖子列表
Route::get('/personal/postsList/{sUserID}','Front\PersonalController@postsList');
// 链接列表
Route::get('/personal/linksList/{sUserID}','Front\PersonalController@linksList');
// 回复列表
Route::get('/personal/replysList/{sUserID}','Front\PersonalController@replysList');
// 查看个人post
Route::get('/personal/post/{sPostID}','Front\PersonalController@postView');
// 删除帖子
Route::post('/topics/delete','Front\PersonalController@postDelete');
// 编辑帖子
Route::get('/topics/edit','Front\PersonalController@postsEdit');

// 查看链接
Route::get('/personal/link/{sPostID}','Front\PersonalController@linkView');

// 查看回复
Route::get('/personal/reply/{sReplyID}','Front\PersonalController@replyView');
// 删除回复
Route::post('/reply/delete','Front\PersonalController@replyDelete');

// 点赞
Route::post('/topics/praise','Front\PersonalController@praise');

// 回复
Route::post('/topics/replay','Front\PersonalController@replay');




// -------------------------------------
// 编辑个人资料
Route::get('/edit/info','Front\UserInfoController@store');

// 个人信息提交
Route::post('/edit/edit','Front\UserInfoController@edit');

// --------------------------------------	
// Route::get('/edit/edit','Front\UserInfoController@edit');
// 修改密码
Route::get('/edit/password','Front\UserInfoController@storePassword');
// 保存密码
Route::post('/save/password','Front\UserInfoController@savePassword');

// --------------------------------------
// 退出登录
Route::get('/front/logout','Front\UserInfoController@logout');


// -----------------------------------------------------------------------------
// 发帖
Route::get('/topics/create/{sPostID?}','Front\PostController@store');
// 保存
Route::post('/topics/save/','Front\PostController@save');
// 分相链接
Route::get('/links/share/{sPostID?}','Front\PostController@linksStore');
// 保存链接
Route::post('/links/save','Front\PostController@linksSave');

// 编辑回复
Route::get('/reply/edit/{sReplyID?}','Front\PostController@replyStore');




// -----------------------------------------------------------------------------


// 后台页面路由
Route::get('admin_login',function(){
	return view('admin.admin_login');
});
// 验证用户名密码
Route::post('/admin/login','Admin\LoginController@check');
Route::get('/admin/login','Admin\LoginController@check');

// 管理员基本信息填写
Route::get('/basicInfo','Admin\UserInfoController@bind');

// 安全设置
Route::get('/setting','Admin\UserInfoController@setting');
// 修改密码
Route::post('/password/edit','Admin\UserInfoController@passwordEdit');

// 退出登录
Route::post('/logout','Admin\UserInfoController@logout');

// 管理员信息保存
Route::group(['prefix' => 'ajax'], function(){
	Route::post('edit', 'Admin\UserInfoController@edit');
});


// Route::get('/ajax/del','Admin\PostController@del');


// 功能模块路由

// 内容管理

//帖子管理
Route::get('/postList','Admin\PostController@store'); 
// 查询路由
// Route::post('/posts/search','Admin\PostController@search');

// table数据填充
// Route::post('/table/post','Admin\PostController@table');
Route::get('/table/post','Admin\PostController@table');


// table删除
Route::post('/post/del','Admin\PostController@del');
// table 帖子查看
Route::get('/post/view/{sPostID}','Admin\PostController@view');

// table 回复查看
Route::get('/reply/view/{sReplyID}','Admin\PostController@replyView');

// 回复管理
Route::get('/reply','Admin\ReplyController@store');
// 填充表格数据
Route::get('/reply/table','Admin\ReplyController@table');
// 删除信息
Route::post('/reply/del','Admin\ReplyController@del');


// 帖子回收站
Route::get('/postRecycle','Admin\PostController@recycleStore');
// 数据填充
Route::get('/recycle/table','Admin\PostController@recycleTable');
// 恢复数据
Route::post('/recycle/restore','Admin\PostController@recycleRestore');


// 用户管理

// 普通用户管理
Route::get('/common','Admin\CommonController@store');
// 数据填充
Route::get('/common/table','Admin\CommonController@table');
// 删除数据
Route::post('/common/del','Admin\CommonController@del');

// 黑名单管理
// 初始化
Route::get('/blackList','Admin\BlackListController@store');
// 填充数据
Route::get('/blackList/table','Admin\BlackListController@table');
// 删除数据
Route::post('/blackList/restore','Admin\BlackListController@restore');

// 管理员用户管理
// 初始化
Route::get('/manager','Admin\ManagerController@store');
// 数据填充
Route::get('/manager/table','Admin\ManagerController@table');
// 管理员添加
Route::post('/manager/edit','Admin\ManagerController@edit');

// 扩展管理
// 友情链接初始化
Route::get('/frind/links','Admin\ExtendController@linkStore');
// 友情链接填充表格
Route::get('/link/table','Admin\ExtendController@linkTable');
// 添加链接
Route::post('/link/save','Admin\ExtendController@linkSave');
// 修改链接
Route::post('/link/edit','Admin\ExtendController@linkEdit');
// 删除链接
Route::post('/link/del','Admin\ExtendController@linkDel');

// 推荐资源
Route::get('/recom/resource','Admin\ExtendController@resourceStore');
// 推荐资源填充
Route::get('/resource/table','Admin\ExtendController@resourceTable');
// 推荐资源保存
Route::post('/resource/save','Admin\ExtendController@resourceSave');
