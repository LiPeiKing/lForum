<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Reply;

class ReplyController extends Controller
{
    //初始化
    public function store(){
    	return view('admin.admin_reply');
    }

    // 填充数据
    public function table(Request $request){
    	$model = new Reply;

    	$sPostTitle = $request->sPostTitle;
		$sAuthor = $request->sAuthor;

    	$page=$request->page?$request->page:1;
		$limit=$request->limit?$request->limit:10;

		$count = "0";
		if(empty($sAuthor)){
			if(empty($sPostTitle)){
				$data=$model::where('iDelete','!=','1')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','!=','1')
							->count();
			}else{
				$data=$model::where('iDelete','!=','1')
							->where('sPostTitle','like','%'.$sPostTitle.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','!=','1')
							->where('sPostTitle','like','%'.$sPostTitle.'%')
							->count();
			}	
		}else{
			if(empty($sPostTitle)){
				$data=$model::where('iDelete','!=','1')
							->where('sAuthor','like','%'.$sAuthor.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','!=','1')
							->where('sAuthor','like','%'.$sAuthor.'%')
							->count();
			}else{
				$data=$model::where('iDelete','!=','1')
							->where('sAuthor','like','%'.$sAuthor.'%')
							->where('sPostTitle','like','%'.$sPostTitle.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iDelete','!=','1')
							->where('sAuthor','like','%'.$sAuthor.'%')
							->where('sPostTitle','like','%'.$sPostTitle.'%')
							->count();
			}
		}
    	

		return [
			'code'  =>  0,
			'msg'   => '信息',
			'count' => $count,
			'data'  => $data,
		];
    }

    // 数据删除
    public function del(Request $request){
    	$sReplyID = $request->sReplyID;

    	$replys = Reply::find($sReplyID);
    	$replys->iDelete = "1";
    	if($replys->save()){
			return 1;
		}else{
			return 0;
		}
    }
}
