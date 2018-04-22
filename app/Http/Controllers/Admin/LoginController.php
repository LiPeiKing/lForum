<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;
use App\Admin\Log;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class LoginController extends Controller
{
    //
    public function check(Request $request){
    	// $userinfo = UserInfo::where('sLoginName',$request->input('logname'));
    	// $name = $request->input('logname');

    	$count = UserInfo::where('sLoginName',$request->input('logname'))->count();
    	if($count !=0){
    		$user = UserInfo::where('sLoginName',$request->input('logname'))
                            ->where('sRoleID','=','3b6f5f5a-42a7-11e8-a584-fb0833e9f81e')
                            ->first();
    		if(!empty($user)){
    			if($user->sPassword == $request->input('logpassword')){
    				$request->session()->put('sLoginName',$request->input('logname'));
                    $request->session()->put('sUserID',$user->sUserID);

                    // $logs = new Log;
                    // //获取上次登录日志
                    // $logs = Log::where('sUserID','=',$user->sUserID)->first(); 
                    // if(empty()){
                    //     $logs->sLogID = 
                    // }else{
                    //     $logs->sServerIp = $_SERVER['SERVER_ADDR'];
                    //     $logs->sUserIp = $_SERVER['REMOTE_ADDR'];
                    //     $logs->dLogin = date('Y-m-d H:i:s',time());
                    //     $log->save();
                    // }

    				return view('admin.admin_index');
    			}else{
    				return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    			}
    		}else{
                $user = UserInfo::where('sLoginName',$request->input('logname'))
                            ->where('sRoleID','=','036a3231-4449-11e8-bf5b-6031d59b89dd')
                            ->first();
                if(!empty($user)){
                    if($user->sPassword == $request->input('logpassword')){
                        $request->session()->put('sLoginName',$request->input('logname'));
                        $request->session()->put('sUserID',$user->sUserID);
                        $request->session()->put('sRole','root');
                        return view('admin.admin_index');
                    }
                }else{
                    $user = UserInfo::where('sLoginName',$request->input('logname'))
                            ->where('sRoleID','=','6473d619-4441-11e8-bf5b-6031d59b89dd')
                            ->first();
                    if(!empty($user)){
                        return view('admin.admin_login',['msg' => '对不起您没有权限登录！请联系超级管理员！','logname'=>$request->input('logname')]);
                    }
                }
    			return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    		}
    		// echo $sLoginName;
    		
    	}else{
    		return view('admin.admin_login',['msg' => '用户名或密码错误！','logname'=>$request->input('logname')]);
    	}

    	
    }
}
