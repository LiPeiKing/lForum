<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;

class CommonController extends Controller
{
    //初始化
    public function store(){
    	return view('admin.admin_common');
    }
    // 数据填充
    public function table(Request $request){
    	$model = new UserInfo;

    	$sLoginName = $request->sLoginName;
		$sUserName = $request->sUserName;

    	$page=$request->page?:1;
		$limit=$request->limit?:10;

		$count = "0";

		if(empty($sLoginName)){
			if(empty($sUserName)){
				$data=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->take($limit)
							->count();


			}else{
				$data=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sUserName','like','%'.$sUserName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
						 	->where('sUserName','like','%'.$sUserName.'%')
						 	->take($limit)
						 	->count();
			}
			
		}else{
			if(empty($sUserName)){
				$data=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
						 	->where('sLoginName','like','%'.$sLoginName.'%')
						 	->skip($limit*($page-1))
						 	->take($limit)
						 	->get();
				$count=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
						 	->where('sLoginName','like','%'.$sLoginName.'%')
						 	->take($limit)
						 	->count();
			}else{
				$data=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sUserName','like','%'.$sUserName.'%')
							->where('sLoginName','like','%'.$sLoginName.'%')
							->skip($limit*($page-1))
							->take($limit)
							->get();
				$count=$model::where('iState','!=','1')
							->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
							->where('sUserName','like','%'.$sUserName.'%')
							->where('sLoginName','like','%'.$sLoginName.'%')
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

    // 数据删除
    public function del(Request $request){
    	$sUserID = $request->sUserID;

    	$users = UserInfo::find($sUserID);
    	$users->iState = "1";

    	if($users->save()){
    		return 1;
    	}else{
    		return 0;
    	}
    }

}
