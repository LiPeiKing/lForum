<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;
use Ramsey\Uuid\Uuid;

class ManagerController extends Controller
{
    //初始化
    public function store(){
    	return view('admin.admin_manager');
    }

    // 数据填充
    public function table(Request $request){
    	$model = new UserInfo;
    	$iState = $request->iState;
    	$sRoleID = $request->sRoleID;

    	$page=$request->page?:1;
		$limit=$request->limit?:10;

		$count = "0";
    	if(empty($iState)){
    		$data=$model::where('iState','!=','1')
						->where('sRoleID','=','3b6f5f5a-42a7-11e8-a584-fb0833e9f81e')
						->skip($limit*($page-1))
						->take($limit)
						->get();
			$count=$model::where('iState','!=','1')
						->where('sRoleID','=','3b6f5f5a-42a7-11e8-a584-fb0833e9f81e')
						->skip($limit*($page-1))
						->take($limit)
						->count();

    	}else{
    		$data=$model::where('iState','!=','1')
						->where('sRoleID','=','3b6f5f5a-42a7-11e8-a584-fb0833e9f81e')
						->skip($limit*($page-1))
						->take($limit)
						->get();
			$count=$model::where('iState','!=','1')
						->where('sRoleID','=','3b6f5f5a-42a7-11e8-a584-fb0833e9f81e')
						->skip($limit*($page-1))
						->take($limit)
						->count();
    	}
    	
		return [
			'code'  =>  0,
			'msg'   => '',
			'count' => $count,
			'data'  => $data,
		];	
    }

    // 添加
    public function edit(Request $request){
    	$sLoginName = $request->sLoginName;
		$sPassword = $request->sPassword;
    	if(!empty($sLoginName)){
			$users = new UserInfo;
			$users->sUserID = Uuid::uuid1();
			$users->sRoleID = '3b6f5f5a-42a7-11e8-a584-fb0833e9f81e';
			$users->sLoginName = $sLoginName;
			$users->sPassword = $sPassword;
			$users->dCreateTime = date('Y-m-d H:i:s',time());
			$users->iState = "0";
			if($users->save()){
    			return 1;
			}else{
				return 0;
			}

		}else{
			return 2;
		}
    }
}
