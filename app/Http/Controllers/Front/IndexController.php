<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Post;
use App\Admin\UserInfo;
use DB;


class IndexController extends Controller
{
    //页面初始化
    public function store(Request $request){
    	// $posts = Post::all();
    	$postall = DB::table('post')
    				->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
    				->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
    				->get();

    	return view('front.front_index',['postall' => $postall]);
    }

    //我的动态页面初始化
    public function myAboutStore(Request $request){
        $sUserID = $request->session()->get('sUserID');

        $personalPosts = DB::table('post')
                    ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                    ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
                    ->where('userinfo.sUserID',$sUserID)
                    ->get();
        return view('front.front_index',['personalPosts' => $personalPosts]);


    } 
}
