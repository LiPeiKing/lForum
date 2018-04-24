<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;

class UserInfoController extends Controller
{
    //初始化
    public function store(Request $request){
    	$sLoginName = $request->session()->get('sLoginName');
    	$users = UserInfo::where('sLoginName',$sLoginName)->first();
    	if(!empty($users)){
    		return view('front.front_editInfo',['users' => $users]);
    	}else{
    		return view('front.front_login');
    	}
    }

    // 保存数据
    public function edit(Request $request){
    	$sLoginName = $request->sLoginName;
    	$sUserName = $request->sUserName;
    	$sSex = $request->sSex;
    	$sGitHub = $request->sGitHub;
    	$sEmail = $request->sEmail;
    	$sRealName = $request->sRealName;
    	$sCity = $request->sCity;
    	$sCompany = $request->sCompany;
    	$sWebsite = $request->sWebsite;
    	$sIntroduction = $request->sIntroduction;
   

    	$users = UserInfo::where('sLoginName',$sLoginName)->first();

    	if(!empty($users)){
    		// if($users->sUserName == $sUserName){
    		// 	if($users->sChangeName == '1'){
	    	// 		$users->sChangeName = '1';
    		// 	}
	    	// 	$users->sChangeName = '0';
	    	// }else{
	    	// 	$users->sChangeName = '1';
	    	// }

	    	if($users->sChangeName != '1'){
	    		if($users->sUserName != $sUserName){
	    			$users->sChangeName = '1';
	    		}
	    	}
    		$users->sUserName = $sUserName;
	    	$users->sSex = $sSex;
	    	$users->sGitHub = $sGitHub;
	    	$users->sEmail = $sEmail;
	    	$users->sRealName = $sRealName;
	    	$users->sCity = $sCity;
	    	$users->sCompany = $sCompany;
	    	$users->sWebsite = $sWebsite;
	    	$users->sIntroduction = $sIntroduction;


	    	if($users->save()){
	    		return 1;
	    	}else{
	    		return 0;
	    	}
    	}else{
	    		return 0;

    	}
    	
    }

    // 页面初始化
    public function storePassword(Request $request){
    	$sLoginName = $request->session()->get('sLoginName');
    	$users = UserInfo::where('sLoginName',$sLoginName)->first();
    	return view('front.front_editPassword',['users' => $users]);
    }

    // 保存密码
    public function savePassword(Request $request){
    	$sPassword = $request->sPassword;
    	$sLoginName = $request->session()->get('sLoginName');

    	$users = UserInfo::where('sLoginName',$sLoginName)->first();

    	if(!empty($users)){
    		$users->sPassword = $sPassword;
    		if($users->save()){
    			return 1;
    		}else{
    			return 2;
    		}
    	}else{
    			return 0;
    	}
    }

    // 退出登录

    public function logout(Request $request){
    	$request->session()->forget("sUserID");
		$request->session()->flush("sUserID");
		$request->session()->forget("sLoginName");
		$request->session()->flush("sLoginName");
		return view('front.front_login');
    }
}
