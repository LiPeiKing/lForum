<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;
use Ramsey\Uuid\Uuid;

class CheckController extends Controller
{
    // 初始化
    public function store(){

    }

    // 登录验证
    public function check(Request $request){
    	$sLoginName = $request->sLoginName;
    	$sPassword = $request->sPassword;
    	$msg = '456';
    	// if(!empty($sPassword)){
    	// 	$msg = $sPassword;
    	// 	return view('front.front_login',['msg' => $msg]);
    	// }else{
    	// 	$msg = "密码不为空！";
    	// 	return view('front.front_login',['msg' => $msg]);
    	// }
    	$users = UserInfo::where('sLoginName',$sLoginName)
    					 ->first();
    	if(!empty($users)){
    		if($users->sPassword == $sPassword){
    			// 登录成功
    			$msg = "1";
    			return view('front.front_login',['msg' => $msg]);
    		}else{
    			// 密码错误
    			$msg = "2";
    			return view('front.front_login',['msg' => $msg,'sLoginName' => $sLoginName]);
    		}
    	}else{
    		// 用户名不存在
    		$msg = "0";
    		return view('front.front_login',['msg' => $msg]);
    	}
    }

    // 注册验证
    public function edit(Request $request){
    	$users = new UserInfo;
    	$users->sUserID = Uuid::uuid1();
    	$users->sRoleID = '6473d619-4441-11e8-bf5b-6031d59b89dd';
    	$users->sLoginName = $request->sLoginName;
    	$users->sPassword = $request->sPassword;
    	$users->iState = "0";
    	$users->sEmail = $request->sEmail;
    	if($users->save()){
    		$msg = "1";
    		return view('front.front_registor',['msg' => $msg]); 
    	}else{
    		$msg = "0";
    		return view('front.front_registor',['msg' => $msg]); 
    	}
    }
}
