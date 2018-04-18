<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Post;


class PostController extends Controller
{
    //初始化
	public function store(){
		return view ('admin.admin_post');
	}

    // 查询
	public function search(Request $request){

	}
    // json数据返回
	public function table(Request $request){

		// $data=getRoleOrPermissionApi($response,$posts);
		$model = new Post;
		// $data = getRoleOrPermissionApi($request,$model);
		$page=$request->page?:1;
		$limit=10;
		$data=$model->skip($limit*($page-1))->take($limit)->get();
		// echo $data;
		return [
			'code'  =>  0,
			'msg'   => '',
			'count' =>  4,
			'data'  =>$data,
		];
	}

	// table信息查看
	public function view(Request $request){
		// $posts = new Post;
		// $id = Input::get("id");
		// $posts = UserInfo::find($id);
		return 1;
	}

	// public function getRoleOrPermissionApi($request,$model)
	// {
	// 	$page=$request->page?:1;
	// 	$limit=10;
	// 	$data=$model->skip($limit*($page-1))->take($limit)->get();
	// 	return $data;
	// }
}
