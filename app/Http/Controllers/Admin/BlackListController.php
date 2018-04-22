<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;

class BlackListController extends Controller
{
    //初始化
    public function store(){
    	return view('admin.admin_blackList');
    }

    // 绑定数据
    public function table (Request $request){
    	$model = new UserInfo;

    	$sLoginName = $request->sLoginName;
		$sUserName = $request->sUserName;

    	$page=$request->page?:1;
		$limit=$request->limit?:10;
		$count = "0";

		if(empty($sLoginName)){
			if(empty($sUserName)){
				$data=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->skip($limit*($page-1))
							->take($limit)
							->count();
			}else{
				$data=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sUserName','like','%'.$sUserName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sUserName','like','%'.$sUserName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->count();
			}	
		}else{
			if(empty($sUserName)){
				$data=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sLoginName','like','%'.$sLoginName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sLoginName','like','%'.$sLoginName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->count();
			}else{
				$data=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sLoginName','like','%'.$sLoginName.'%')
							->where('sUserName','like','%'.$sUserName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sLoginName','like','%'.$sLoginName.'%')
							->where('sUserName','like','%'.$sUserName.'%')
							->skip($limit*($page-1))
							->take($limit)
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


    // 恢复数据
    public function restore(Request $request){
    	$sUserID = $request->sUserID;

    	$user = UserInfo::find($sUserID);

    	$user->iState = "0";
    	if($user->save()){
    		return 1;
    	}else{
    		return 0;
    	}
    }
}
