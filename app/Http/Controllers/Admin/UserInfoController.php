<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;


class UserInfoController extends Controller
{
    //编辑信息
	public function edit(Request $request){
		// $user = new UserInfo;
		// $user->sUserName = Input::get('email');
		// $user->sUserName = "2121";

		// $user = Input::get('email');
		$id = Input::get("id");
		// return $id;
		$user = UserInfo::find($id);
		$user->sUserName = Input::get("username");
		$user->sSex = Input::get("sex");
		$user->iPhoneNumber = Input::get("tel");
		$user->sEmail = Input::get("email");
		if ($user->save()) {
			return 1;
		} else {
			return 2;
		}
	}

	//绑定数据
	public function bind(Request $request){
		$id = $request->session()->get("sUserID");
		$user = UserInfo::find($id);
		return view('admin.admin_basicInfo',['user' => $user]);
	} 
	// 安全设置
    public function setting(Request $request){

        return view('admin.admin_setting');

    }
    // 修改密码
    public function passwordEdit(Request $request){
    	$usedpassword = $request->usedpassword;
    	$password = $request->password;
    	$sUserID = $request->session()->get("sUserID");
    	$user = UserInfo::find($sUserID);

    	if($usedpassword != $user->sPassword){
    		return 2;
    	}else{
    		$user->sPassword = $password;
    		if($user->save()){
    			return 1;
    		}else{
    			return 0;
    		}

    	}
    }


	// 退出登录
	public function logout(Request $request){
		$request->session()->forget("sUserID");
		$request->session()->flush("sUserID");
		$request->session()->forget("sLoginName");
		$request->session()->flush("sLoginName");
		// return view('admin.admin_login');
		return 1;
	}
}












