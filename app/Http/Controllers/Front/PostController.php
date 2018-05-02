<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use App\Admin\UserInfo;
use App\Admin\PostType;
use App\Admin\Post;
use App\Admin\Reply;

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
                $posts->iPraise = 0;
                $posts->iReplys = 0;
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
                $posts = Post::find($sPostID);
                $posts->sPostTypeID = $sPostTypeID;
                $posts->sTitle = $sTitle;
                $posts->sAuthor = $request->session()->get('sUserName');
                
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
        $sPostID = $request->route('sPostID');
        if(!empty($sPostID)){
            $links = Post::find($sPostID);
            return view('front.front_editLinks',['links' => $links]);
        }else{
            return view('front.front_editLinks');

        }
    }
    // 分享链接保存
    public function linksSave(Request $request){
    	$sTitle = $request->sTitle;
    	$sLinks = $request->sLinks;
    	$sContent = $request->sContent;
        $sContent = htmlspecialchars($sContent);
        $sPostID = $request->sPostID;

        if(!empty($sPostID)){

            if(!empty($sTitle)){
                $posts = Post::find($sPostID);
                $posts->sTitle = $sTitle;
                $posts->sAuthor = $request->session()->get('sUserName');

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


        }else{
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
                $posts->iReplys = 0;
                $posts->iPraise = 0;
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

    // 回复初始化
    public function replyStore(Request $request){
        $sReplyID = $request->route('sReplyID');
        if(!empty($sReplyID)){
            $reply = Reply::find($sReplyID);
            return view('front.front_editReply',['reply' => $reply]);
        }else{
            return view('front.front_editReply');

        }
    }
}
