<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Post;
use App\Admin\PostType;
use App\Admin\Reply;
use DB;


class PostController extends Controller
{
    //初始化
	public function store(){
		return view ('admin.admin_post');
	}

    // json数据返回
	public function table(Request $request){

		// $data=getRoleOrPermissionApi($response,$posts);
		$model = new Post;
		// $data = getRoleOrPermissionApi($request,$model);
		// 获取前台查询数据
		// $sTitle = $_GET["sTitle"];

		$sTitle = $request->sTitle;
		$sAuthor = $request->sAuthor;

		$page=$request->page?$request->page:1;
		$limit=$request->limit?$request->limit:10;

		$count = "0";
		if(empty($sTitle)){
			if(empty($sAuthor)){
				$data=$model::where('iDelete','!=','1')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','!=','1')
							->count();
			}else{
				$data=$model::where('iDelete','!=','1')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','!=','1')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->count();
			}
			
		}else{
			if(empty($sAuthor)){
				$data=$model::where('iDelete','!=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','!=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->count();
			}else{
				$data=$model::where('iDelete','!=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','!=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->count();
			}
			
		}

		return [
			'code'  =>  0,
			'msg'   => '',
			'count' => $count,
			'data'  => $data,
		];
	}

	// table 帖子信息查看
	public function view(Request $request,$sPostID){
		$npost = Post::find($sPostID);
		if(!empty($npost->sPostTypeID)){
			//链接查询
			$posts = DB::table('post')
				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
				->select('post.*','posttype.sName')
				->where('sPostID',$sPostID)
				->where('iType','=','1')
                ->where('iDelete','=','0')
				->first();
			return view('admin.admin_postView',['posts' =>$posts]);

		}else{
			return view('admin.admin_postView',['posts' =>$npost]);
		}
	}

	// table 回复查看
	public function replyView(Request $request,$sReplyID){
		$reply = Reply::find($sReplyID);

		return view('admin.admin_replyView',['reply' => $reply]);
	}

	// public function getRoleOrPermissionApi($request,$model)
	// {
	// 	$page=$request->page?:1;
	// 	$limit=10;
	// 	$data=$model->skip($limit*($page-1))->take($limit)->get();
	// 	return $data;
	// }


	// table信息删除
	public function del(Request $request){
		$id = $request->id;
		$posts = Post::find($id);

		$posts->iDelete = "1";
		if($posts->save()){
			return 1;
		}else{
			return 0;
		}

		// return $id;
	}

	// 帖子回收站初始化
	public function recycleStore(Request $request){
		return view("admin.admin_recycle");
	}
	// 帖子回收站填充数据
	public function recycleTable(Request $request){
		$model = new Post;
		$sTitle = $request->sTitle;
		$sAuthor = $request->sAuthor;
		$page=$request->page?:1;
		$limit=$request->limit?:10;
		$count = "0";
		if(empty($sTitle)){
			if(empty($sAuthor)){
				$data=$model::where('iDelete','=','1')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','=','1')
							->skip($limit*($page-1))
							->take($limit)
							->count();
			}else{
				$data=$model::where('iDelete','=','1')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','=','1')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->count();
			}
			
		}else{
			if(empty($sAuthor)){
				$data=$model::where('iDelete','=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->count();
			}else{
				$data=$model::where('iDelete','=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->get();
				$count=$model::where('iDelete','=','1')
						 ->where('sTitle','like','%'.$sTitle.'%')
						 ->where('sAuthor','like','%'.$sAuthor.'%')
						 ->skip($limit*($page-1))
						 ->take($limit)
						 ->count();
			}
			
		}

		return [
			'code'  =>  0,
			'msg'   => '',
			'count' => $count,
			'data'  => $data,
		];
	}

	// 恢复已删除数据
	public function recycleRestore(Request $request){
		$sPostID = $request->sPostID;

		$posts = Post::find($sPostID);
		$posts->iDelete = "0";
		if($posts->save()){
			return 1;
		}else{
			return 0;
		}
	}
}
