<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Admin\UserInfo;
use App\Admin\PostType;
use App\Admin\Post;

class PostController extends Controller
{
    //发帖页面初始化
    public function store(Request $request){
        $sPostID = $request->route('sPostID');
        if(!empty($sPostID)){
            $posts = Post::find($sPostID);
            $postTypes = PostType::all();
            $sPostType = PostType::find($posts->sPostTypeID);
            return view('front.front_editPost',['postTypes' => $postTypes,'sPostType' => $sPostType,'posts' => $posts]);
        }else{
            $postTypes = PostType::all();
            return view('front.front_editPost',['postTypes' => $postTypes]);
        }
    }

    // 保存\编辑帖子信息
    public function save(Request $request){
    	$sContent = $request->sContent;
        $sTitle = $request->sTitle;
    	$sPostTypeID = $request->sTypeID;
        $sContent = htmlspecialchars($sContent);
        $sPostID = $request->sPostID;

        if(empty($sPostID)){
            if(!empty($sTitle)){
                $posts = new Post;
                $posts->sPostID = Uuid::uuid1();
                $posts->sPostTypeID = $sPostTypeID;
                $posts->sUserID = $request->session()->get('sUserID');
                $posts->sTitle = $sTitle;
                $posts->sContent = $sContent;
                $posts->sAuthor = $request->session()->get('sUserName');
                $posts->iDelete = 0;
                $posts->iType = 1;
                $posts->dCreateTime = date('Y-m-d H:i:s',time());
                if($posts->save()){
                    return 1;
                }else{
                    return 2;
                }
            }else{
                return 0;
            }
        }else{
            
            if(!empty($sTitle)){
                // $posts = new Post;
                // $posts->sPostID = Uuid::uuid1();
                // $posts->sPostTypeID = $sPostTypeID;
                // $posts->sUserID = $request->session()->get('sUserID');
                // $posts->sTitle = $sTitle;
                // $posts->sContent = $sContent;
                // $posts->sAuthor = $request->session()->get('sUserName');
                // $posts->iDelete = 0;
                // $posts->iType = 1;
                // $posts->dCreateTime = date('Y-m-d H:i:s',time());


                $posts = Post::find($sPostID);
                $posts->sPostTypeID = $sPostTypeID;
                $posts->sTitle = $sTitle;
                $posts->sContent = $sContent;
                $posts->dModifyTime = date('Y-m-d H:i:s',time());

                if($posts->save()){
                    return 1;
                }else{
                    return 2;
                }
            }else{
                return 0;
            }


        }

    	
    }

    // 分享链接页面初始化
    public function linksStore(Request $request){
    	return view('front.front_editLinks');
    }
    // 分享链接保存
    public function linksSave(Request $request){
    	$sTitle = $request->sTitle;
    	$sLinks = $request->sLinks;
    	$sContent = $request->sContent;
        $sContent = htmlspecialchars($sContent);

    	if(!empty($sTitle)){
    		$posts = new Post;

    		$posts->sPostID = Uuid::uuid1();
    		// $posts->sPostTypeID = $sPostTypeID;
            $posts->sUserID = $request->session()->get('sUserID');
            
    		$posts->sTitle = $sTitle;
    		$posts->sContent = $sContent;
    		$posts->sAuthor = $request->session()->get('sUserName');
    		$posts->sLinks = $sLinks;
    		$posts->iDelete = 0;
    		$posts->iType = 2;
    		$posts->dCreateTime = date('Y-m-d H:i:s',time());
    		if($posts->save()){
    			return 1;
    		}else{
    			return 0;
    		}

    	}else{
    		return 0;
    	}
    }
}
