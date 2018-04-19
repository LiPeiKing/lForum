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

Route::get('/', function () {
    return view('welcome');
});

// 后台路由
Route::get('admin_login',function(){
	return view('admin.admin_login');
});
// 验证用户名密码
Route::post('/admin/login','Admin\LoginController@check');

// 管理员基本信息填写
Route::get('/basicInfo','Admin\UserInfoController@bind');

// 退出登录
Route::get('/logout','Admin\UserInfoController@logout');

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

// table查看
// Route::post('/post/view','Admin\PostController@view');
// table删除
Route::post('/post/del','Admin\PostController@del');

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

