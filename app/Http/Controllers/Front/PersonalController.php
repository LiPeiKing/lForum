<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;
use App\Admin\Post;
use App\Admin\Reply;
use DB;

class PersonalController extends Controller
{
    //页面初始化
    public function store(Request $request){
    	$sLoginName = $request->session()->get('sLoginName');
    	$sUserID = $request->session()->get('sUserID');
    	$users = UserInfo::where('sLoginName',$sLoginName)
    					 ->first();
    	$now_time = date("Y-m-d H:i:s", time());
		$now_time = strtotime($now_time);  
		$show_time = strtotime($users->dCreateTime);  
		$dur = $now_time - $show_time;
		$time="";
		if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            $time = $dur . '秒前';  
	        } else {  
	            if ($dur < 3600) {  
	                $time = floor($dur / 60) . '分钟前';  
	            } else {  
	                if ($dur < 86400) {  
	                    $time = floor($dur / 3600) . '小时前';  
	                } else {  
	                        $time = floor($dur/(60*60*24)) . '天前';  
	                     
	                }  
	            }  
	        }  
	    }    
	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','2')
    					->count();
    	// 帖子
    	// $posts = Post::where('sUserID',$sUserID)
    	// 			 ->where('iType','=','1')
    	// 			 ->get();
    	// 链接
    	$links = Post::where('sUserID',$sUserID)
    				 ->where('iType','=','2')
    				 ->get();
    	

    	// 帖子进行连接查询
    	$posts = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
    				->where('sUserID',$sUserID)
    				->where('iType','=','1')
    				->get();

    	return view('front.front_personal',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts,'links' => $links]);
    }

    // 帖子列表
    public function postsList(Request $request){
    	$sLoginName = $request->session()->get('sLoginName');
    	$sUserID = $request->session()->get('sUserID');
    	$users = UserInfo::where('sLoginName',$sLoginName)
    					 ->first();
    	$now_time = date("Y-m-d H:i:s", time());
		$now_time = strtotime($now_time);  
		$show_time = strtotime($users->dCreateTime);  
		$dur = $now_time - $show_time;
		$time="";
		if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            $time = $dur . '秒前';  
	        } else {  
	            if ($dur < 3600) {  
	                $time = floor($dur / 60) . '分钟前';  
	            } else {  
	                if ($dur < 86400) {  
	                    $time = floor($dur / 3600) . '小时前';  
	                } else {  
	                        $time = floor($dur/(60*60*24)) . '天前';  
	                     
	                }  
	            }  
	        }  
	    }    
	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','2')
    					->count();
    	
		// 帖子进行连接查询
    	$posts = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
    				->where('sUserID',$sUserID)
    				->where('iType','=','1')
    				->get();

    	return view('front.front_postList',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts]);
    }

    // 链接列表
    public function linksList(Request $request){
    	$sLoginName = $request->session()->get('sLoginName');
    	$sUserID = $request->session()->get('sUserID');
    	$users = UserInfo::where('sLoginName',$sLoginName)
    					 ->first();
    	$now_time = date("Y-m-d H:i:s", time());
		$now_time = strtotime($now_time);  
		$show_time = strtotime($users->dCreateTime);  
		$dur = $now_time - $show_time;
		$time="";
		if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            $time = $dur . '秒前';  
	        } else {  
	            if ($dur < 3600) {  
	                $time = floor($dur / 60) . '分钟前';  
	            } else {  
	                if ($dur < 86400) {  
	                    $time = floor($dur / 3600) . '小时前';  
	                } else {  
	                        $time = floor($dur/(60*60*24)) . '天前';  
	                     
	                }  
	            }  
	        }  
	    }    
	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','2')
    					->count();
    	
		// 帖子进行连接查询
    	$links = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
    				->where('sUserID',$sUserID)
    				->where('iType','=','2')
    				->get();

    	return view('front.front_linkList',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'links' => $links]);

    }


    // 帖子查看
    public function postView(Request $request,$sPostID){
    	$sLoginName = $request->session()->get('sLoginName');
    	$sUserID = $request->session()->get('sUserID');
    	$users = UserInfo::where('sLoginName',$sLoginName)
    					 ->first();
    	$now_time = date("Y-m-d H:i:s", time());
		$now_time = strtotime($now_time);  
		$show_time = strtotime($users->dCreateTime);  
		$dur = $now_time - $show_time;
		$time="";
		if ($dur < 0) {  
	        return $the_time;  
	    } else {  
	        if ($dur < 60) {  
	            $time = $dur . '秒前';  
	        } else {  
	            if ($dur < 3600) {  
	                $time = floor($dur / 60) . '分钟前';  
	            } else {  
	                if ($dur < 86400) {  
	                    $time = floor($dur / 3600) . '小时前';  
	                } else {  
	                        $time = floor($dur/(60*60*24)) . '天前';  
	                     
	                }  
	            }  
	        }  
	    }    
	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','2')
    					->count();
    	// 帖子
		$posts = Post::find($sPostID);
    	

    	return view('front.front_personalPost',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts]);
    }
}