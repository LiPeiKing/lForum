<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;

class LoginController extends Controller
{
    //
    public function check(Request $request){
    	// $userinfo = UserInfo::where('sLoginName',$request->input('logname'));
    	// $name = $request->input('logname');

    	$count = UserInfo::where('sLoginName',$request->input('logname'))->count();
    	if($count !=0){
    		$user = UserInfo::where('sLoginName',$request->input('logname'))->first();
    		// $sPassword = UserInfo::where('sPassword',$request->input('logpassword'))->get();
    		if(!empty($user)){
    			if($user->sPassword == $request->input('logpassword')){
    				$request->session()->put('sLoginName',$request->input('logname'));
                    $request->session()->put('id',$user->id);

    				return view('admin.admin_index');
    			}else{
    				return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    			}
    		}else{
    			return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    		}
    		// echo $sLoginName;
    		
    	}else{
    		return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    	}

    	
    }
}
