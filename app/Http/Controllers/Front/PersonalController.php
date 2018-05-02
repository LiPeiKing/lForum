<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\UserInfo;
use App\Admin\Post;
use App\Admin\Reply;
use App\Admin\UserNum;
use App\Admin\Praise;
use Ramsey\Uuid\Uuid;

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
    
        if($dur < 0){
            $time = $users->dCreateTime;
        }elseif ($dur < 60) {
           $time = $dur.'秒前'; 
        }elseif($dur < 3600){
            $time = floor($dur/60).'分钟前'; 
        }elseif($dur < 86400){
            $time = floor($dur/3600) . '小时前';  
        }else{
            $time = floor($dur/(60*60*24)).'天前';  
        }

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
                        ->where('iDelete','=','0')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','2')
                        ->where('iDelete','=','0')
    					->count();
    	// 帖子
    	// $posts = Post::where('sUserID',$sUserID)
    	// 			 ->where('iType','=','1')
    	// 			 ->get();
    	// 链接
    	$links = Post::where('sUserID',$sUserID)
                     ->where('iDelete','=','0')
                     ->orderby('dCreateTime','desc')
    				 ->where('iType','=','2')
    				 ->get();
    	

    	// 帖子进行连接查询
    	$posts = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
    				->where('sUserID',$sUserID)
    				->where('iType','=','1')
                    ->orderby('dCreateTime','desc')
                    ->where('iDelete','=','0')
    				->get();

        // 回复数量
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();
        // 回复
        $replys = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->get();



        // 传递是UserID用于比较是否显示编辑

    	return view('front.front_personal',['sUserID'=>$sUserID,'users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts,'links' => $links,'userNum' => $userNum,'replyNum' => $replyNum,'replys' => $replys]);
    }

    // 帖子列表
    public function postsList(Request $request,$sUserID){
    	$sLoginName = $request->session()->get('sLoginName');
    	// $sUserID = $request->session()->get('sUserID');
        if(empty($sLoginName)){
            return view('front.front_login');
        }
    	$users = UserInfo::find($sUserID);
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

         // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
    					->where('iType','=','1')
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
    					->where('iType','=','2')
    					->count();
        // 回复数量
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();
    	
		// 帖子进行连接查询
    	$posts = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
                    ->where('iDelete','=','0')
    				->where('sUserID',$sUserID)
    				->where('iType','=','1')
                    ->orderby('dCreateTime','desc')
    				->get();

    	return view('front.front_postList',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'replyNum' => $replyNum,'posts' => $posts,'userNum' => $userNum]);
    }

    // 链接列表
    public function linksList(Request $request,$sUserID){
    	$sLoginName = $request->session()->get('sLoginName');
    	// $sUserID = $request->session()->get('sUserID');

        if(empty($sLoginName)){
            return view('front.front_login');
        }

    	$users = UserInfo::find($sUserID);
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

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

	    // 讨论数量
    	$postNum = Post::where('sUserID',$sUserID)
    					->where('iType','=','1')
                        ->where('iDelete','=','0')
                        
    					->count();
    	// 链接数
    	$linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
    					->where('iType','=','2')
    					->count();
        // 回复数量
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();
    	
		// 帖子进行连接查询
    	$links = DB::table('post')
    				->leftjoin('posttype','post.sPostTypeID','=','posttype.id')
    				->select('post.*','posttype.sName')
                    ->where('iDelete','=','0')
                    ->orderby('dCreateTime','desc')
    				->where('sUserID',$sUserID)
    				->where('iType','=','2')
    				->get();

    	return view('front.front_linkList',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'replyNum' => $replyNum,'links' => $links,'userNum' => $userNum]);

    }

    // 回复列表
    public function replysList(Request $request,$sUserID){
        $sLoginName = $request->session()->get('sLoginName');
        // $sUserID = $request->session()->get('sUserID');

        if(empty($sLoginName)){
            return view('front.front_login');
        }

        $users = UserInfo::find($sUserID);
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

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

        // 讨论数量
        $postNum = Post::where('sUserID',$sUserID)
                        ->where('iType','=','1')
                        ->where('iDelete','=','0')
                        
                        ->count();
        // 链接数
        $linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','2')
                        ->count();
        
        // 回复数量
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();
        // 回复
        $replys = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->get();


        return view('front.front_replyList',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'userNum' => $userNum,'replyNum' => $replyNum,'replys' => $replys]);


    }


    // 帖子查看
    public function postView(Request $request,$sPostID){
        $posts = Post::find($sPostID);
        $sUserID = $posts->sUserID;
        $users = UserInfo::find($sUserID);

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

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

        // 讨论数量
        $postNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','1')
                        ->count();
        // 链接数
        $linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','2')
                        ->count();
        // 点赞情况
        $sLoginID = $request->session()->get('sUserID');
        $isPraise = Praise::where('sPostID',$sPostID)
                          ->where('sUserID',$sLoginID)
                          ->first();
        $praise = '';
        if(empty($isPraise)){
            $praise = '0';
        }else{
            $praise = '1';
        }

        // 回复
        $replys = Reply::where('sPostID',$sPostID)
                       ->where('iDelete','=','0')
                        ->orderby('dCreateTime','desc')
                        ->get();
        // 该条链接的回复数
        $replyCount = Reply::where('sPostID',$sPostID)
                       ->where('iDelete','=','0')
                       ->count();

        // 用户的回复数
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();


        return view('front.front_personalPost',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts,'userNum' => $userNum,'praise' => $praise,'replys' => $replys,'replyNum' => $replyNum,'replyCount' => $replyCount]);
    }

    // 查看链接
    public function linkView(Request $request,$sPostID){
        $posts = Post::find($sPostID);
        $sUserID = $posts->sUserID;
        $users = UserInfo::find($sUserID);

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

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

        // 讨论数量
        $postNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','1')
                        ->count();
        // 链接数
        $linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','2')
                        ->count();

         // 点赞情况
        $sLoginID = $request->session()->get('sUserID');
        $isPraise = Praise::where('sPostID',$sPostID)
                          ->where('sUserID',$sLoginID)
                          ->first();
        $praise = '';
        if(empty($isPraise)){
            $praise = '0';
        }else{
            $praise = '1';
        }

        // 回复
        $replys = Reply::where('sPostID',$sPostID)
                       ->where('iDelete','=','0')
                        ->orderby('dCreateTime','desc')
                        ->get();
        // 该条链接的回复数
        $replyCount = Reply::where('sPostID',$sPostID)
                       ->where('iDelete','=','0')
                       ->count();

        // 用户的回复数
        $replyNum = Reply::where('sUserID',$sUserID)
                       ->where('iDelete','=','0')
                       ->count();


        

        return view('front.front_personalPost',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'posts' => $posts,'userNum' => $userNum,'praise' => $praise,'replys' => $replys,'replyNum' => $replyNum,'replyCount' => $replyCount]);
    }

    // 查看回复
    public function replyView(Request $request,$sReplyID){
        $replys = Reply::find($sReplyID);
        $sUserID = $replys->sUserID;
        $users = UserInfo::find($sUserID);

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

        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

        // 讨论数量
        $postNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','1')
                        ->count();
        // 链接数
        $linkNum = Post::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->where('iType','=','2')
                        ->count();

         // 点赞情况
        $sLoginID = $request->session()->get('sUserID');


        // 回复
        $reply = Reply::where('sReplyID',$sReplyID)
                       ->where('iDelete','=','0')
                       ->orderby('dCreateTime','desc')
                       ->get();
        // 回复数
        $replyNum = Reply::where('sUserID',$sUserID)
                        ->where('iDelete','=','0')
                        ->count();
        

        return view('front.front_personalReply',['users' => $users,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'replys' => $replys,'userNum' => $userNum,'replys' => $replys,'replyNum' => $replyNum]);


    }
   

    // 删除帖子
    public function postDelete(Request $request){
        $sPostID = $request->sPostID;
        $posts = Post::find($sPostID);
        if(!empty($posts)){
            if($posts->delete()){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 0;
        }
        
    }

    // 点赞帖子
    public function praise(Request $request){

        $sLoginName = $request->session()->get('sLoginName');

        $sPostID = $request->sPostID;
        $sUserID = $request->sUserID;

        $praise = Praise::where('sPostID',$sPostID)
                        ->where('sUserID',$sUserID)
                        ->first();

        $post = Post::find($sPostID);
        if(!empty($praise)){
            if($praise->delete()){
                $post->iPraise = $post->iPraise-1;
                if($post->save()){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }

        }else{
            $praises = new Praise;
            $praises->sPraiseID = Uuid::uuid1();
            $praises->sPostID = $sPostID;
            $praises->sUserID = $sUserID;
            $praises->dCreateTime = date("Y-m-d H:i:s",time());

            $post = Post::find($sPostID);
            if($praises->save()){
                $post->iPraise = $post->iPraise+1;
                    if($post->save()){
                        return 1;
                    }else{
                        return 0;
                    }
            }else{
                return 0;
            }

        }
 
    }

    // 回复帖子
    public function replay(Request $request){

        $sReplyID = $request->sReplyID;

        if(!empty($sReplyID)){
            $sContent = $request->sContent;
            $sContent = htmlspecialchars($sContent);

            $reply = Reply::find($sReplyID);
            $reply->sContent = $sContent;
            if($reply->save()){
                return 1;
            }else{
                return 0;
            }
        }else{
            // 所回复的帖子ID
            $sPostID = $request->sPostID;
            // 此条回复的用户ID
            $sLoginID = $request->sLoginID;
            // 所回复的帖子作者ID
            $sPostAuthorID = $request->sPostAuthorID;
            // 所回复的内容
            $sContent = $request->sContent;
            $sContent = htmlspecialchars($sContent);

            $loginUser = UserInfo::find($sLoginID);
            $postUser = UserInfo::find($sPostAuthorID);
            $post = Post::find($sPostID);

            $reply = new Reply;
            $reply->sReplyID = Uuid::uuid1();
            $reply->sPostID = $sPostID;
            $reply->sPostTitle = $post->sTitle;
            $reply->sUserName = $postUser->sUserName;
            $reply->sContent = $sContent;
            $reply->sAuthor = $loginUser->sUserName;
            $reply->sUserID = $loginUser->sUserID;
            $reply->iDelete = 0;
            $reply->dCreateTime = date('Y-m-d H:i:s',time());
            if($reply->save()){
                if(empty($post->iReplys)){
                    $post->iReplys = 1;
                    $post->save();
                    return 1;
                }else{
                    $post->iReplys =  $post->iReplys+1;
                    $post->save();

                    return 1;
                }
            }else{
                return 0;
            }
        }


        

    }

    // 删除回复
    public function replyDelete(Request $request){

        $sReplyID = $request->sReplyID;
        $reply = Reply::find($sReplyID);
        $sPostID = $reply->sPostID;
        if(!empty($reply)){
            if($reply->delete()){
                $post = Post::find($sPostID);
                $post->iReplys = $post->iReplys -1;
                $post->save();
                return 1;
            }else{
                return 2;
            }
        }else{
            return 0;
        }

    }

    
}
