<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Post;
use App\Admin\UserInfo;
use App\Admin\UserNum;
use App\Admin\Reply;
use App\Admin\Link;
use App\Admin\PostType;
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
                    ->take(9)
    				->get();
        $count = Post::where('iDelete','=','0')->count();

        $firendLinks = Link::where('iType','=','1')->get();

        $resources = Link::where('iType','=','2')->get();

        $postTypes = PostType::all();


    	return view('front.front_index',['postall' => $postall,'count' => $count,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'type'=>'s']);
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
                    ->take(9)
                    ->get();
        $firendLinks = Link::where('iType','=','1')->get();

        $count = Post::where('iDelete','=','0')->where('sUserID',$sUserID)->count();

        $postTypes = PostType::all();

        $resources = Link::where('iType','=','2')->get();
        return view('front.front_index',['personalPosts' => $personalPosts,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'personal'=>'personal','count' =>$count,'type' => 's']);
    } 

    // 搜索功能
    public function search(Request $request){
        $keyWords = $request->input("search");
        $keyWords = trim($keyWords);

        // 查询出用户
        $users = DB::table('userinfo')
                   ->leftjoin('usernum','userinfo.sUserID','=','usernum.sUserID')
                   ->where('sLoginName','like','%'.$keyWords.'%')
                   ->orWhere('sUsername','like','%'.$keyWords.'%')
                   ->get();
        $countUser = DB::table('userinfo')
                   ->leftjoin('usernum','userinfo.sUserID','=','usernum.sUserID')
                   ->where('sLoginName','like','%'.$keyWords.'%')
                   ->orWhere('sUsername','like','%'.$keyWords.'%')
                   ->count();

        // 查询出帖子
        $posts = DB::table('post')
                   ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                   ->where('sTitle','like','%'.$keyWords.'%')
                   ->orWhere('sContent','like','%'.$keyWords.'%')
                   ->get();
        $countPost = DB::table('post')
                   ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                   ->where('sTitle','like','%'.$keyWords.'%')
                   ->orWhere('sContent','like','%'.$keyWords.'%')
                   ->count();
        $counts = $countUser+ $countPost;


        return view("front.front_search",['keyWords' => $keyWords,'users' => $users,'counts' => $counts,'posts' => $posts]);
    }

    // 查看用户的个人中心
    public function personal(Request $request,$sUserID){
        $sLoginName = $request->session()->get('sLoginName');
        // $sUserID = $request->session()->get('sUserID');

        if(empty($sLoginName)){
            return view('front.front_login');
        }

        
        $users = UserInfo::find($sUserID);
        // 第几位用户
        $userNum = UserNum::where('sUserID',$sUserID)->first();

        // 时间
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

        return view('front.front_viewPersonal',['sUserID' => $sUserID,'users' => $users,'userNum' => $userNum,'time' => $time,'postNum' => $postNum,'linkNum' => $linkNum,'links' => $links,'posts' => $posts,'replyNum' => $replyNum,'replys' => $replys]);
    }

    // 分页
    public function page(Request $request,$page,$viewType,$type){
        $sUserID = $request->session()->get('sUserID');
        if($viewType =='all'){
            if($type=='0'){
                $page = $page-1;
                $postall = DB::table('post')
                        ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                        ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                        ->orderby('post.dCreateTime','desc')
                        ->where('iDelete','=','0')
                        ->skip(9*$page)
                        ->take(9)
                        ->get();
                $firendLinks = Link::where('iType','=','1')->get();

                $resources = Link::where('iType','=','2')->get();
                $count = Post::where('iDelete','=','0')
                             ->count();
                $page = $page+1;

                $postTypes = PostType::all();

                return view('front.front_index',['postall' => $postall,'count' => $count,'page' => $page,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes'=> $postTypes]);

            }else{
                $page = $page-1;
                $postall = DB::table('post')
                        ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                        ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                        ->orderby('post.dCreateTime','desc')
                        ->where('iDelete','=','0')
                        ->where('sPostTypeID',$type)
                        ->skip(9*$page)
                        ->take(9)
                        ->get();
                $firendLinks = Link::where('iType','=','1')->get();

                $resources = Link::where('iType','=','2')->get();
                $count = Post::where('iDelete','=','0')
                             ->where('sPostTypeID',$type)
                             ->count();
                // $count=0;
                $page = $page+1;

                $postTypes = PostType::all();

                return view('front.front_index',['postall' => $postall,'count' => $count,'page' => $page,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes'=> $postTypes]);
            }
            
        }else{
            if($type=='0'){
                $page = $page-1;
                $postall = DB::table('post')
                        ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                        ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                        ->orderby('post.dCreateTime','desc')
                        ->where('iDelete','=','0')
                        ->where('userinfo.sUserID',$sUserID)
                        ->skip(9*$page)
                        ->take(9)
                        ->get();
                $links = Link::where('iType','=','1')->get();

                $resources = Link::where('iType','=','2')->get();
                $count = Post::where('iDelete','=','0')
                             ->where('sUserID',$sUserID)
                             ->count();
                $page = $page+1;

                $postTypes = PostType::all();

                return view('front.front_index',['postall' => $postall,'count' => $count,'page' => $page,'links' => $links,'resources' => $resources,'postTypes'=> $postTypes]);
            }else{
                $page = $page-1;
                $postall = DB::table('post')
                        ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                        ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                        ->orderby('post.dCreateTime','desc')
                        ->where('iDelete','=','0')
                        ->where('sPostTypeID',$type)
                        ->where('userinfo.sUserID',$sUserID)
                        ->skip(9*$page)
                        ->take(9)
                        ->get();
                $links = Link::where('iType','=','1')->get();

                $resources = Link::where('iType','=','2')->get();
                $count = Post::where('iDelete','=','0')
                             ->where('sUserID',$sUserID)
                             ->where('sPostTypeID',$type)
                             ->count();
                // $count=0;
                $page = $page+1;

                $postTypes = PostType::all();

                return view('front.front_index',['postall' => $postall,'count' => $count,'page' => $page,'links' => $links,'resources' => $resources,'postTypes'=> $postTypes]);
            }
        }
        
    }

    // 分类查看全部
    public function typeView(Request $request,$type){
        if($type == "link"){
            $postall = DB::table('post')
                    ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                    ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
                    ->where('iType','=','2')
                    ->take(9)
                    ->get();
            $count = Post::where('iDelete','=','0')->where('iType','=','2')->count();

            $firendLinks = Link::where('iType','=','1')->get();

            $resources = Link::where('iType','=','2')->get();

            $postTypes = PostType::all();
            return view('front.front_index',['postall' => $postall,'count' => $count,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'type'=>$type]);
        }else{
            $postall = DB::table('post')
                    ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                    ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
                    ->where('iType','=','1')
                    ->where('sPostTypeID',$type)
                    ->take(9)
                    ->get();
            $count = Post::where('iDelete','=','0')->where('sPostTypeID',$type)->count();

            $firendLinks = Link::where('iType','=','1')->get();

            $resources = Link::where('iType','=','2')->get();

            $postTypes = PostType::all();
            return view('front.front_index',['postall' => $postall,'count' => $count,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'type'=>$type]);
        }
        
    }
    // 分类查看个人
    public function typeViewPersonal(Request $request,$type){
        $sUserID = $request->session()->get('sUserID');
        if($type == "link"){
            $personalPosts = DB::table('post')
                    ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                    ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
                    ->where('iType','=','2')
                    ->where('userinfo.sUserID',$sUserID)
                    ->take(9)
                    ->get();
            $count = Post::where('iDelete','=','0')->where('iType','=','2')->where('sUserID',$sUserID)->count();

            $firendLinks = Link::where('iType','=','1')->get();

            $resources = Link::where('iType','=','2')->get();

            $postTypes = PostType::all();
            return view('front.front_index',['personalPosts' => $personalPosts,'count' => $count,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'type'=>$type,'personal' => 'personal']);
        }else{
            $personalPosts = DB::table('post')
                    ->leftjoin('userinfo','post.sUserID','=','userinfo.sUserID')
                    ->select('post.sPostID','post.sPostTypeID','post.sUserID','post.sTitle','post.iType','post.sAuthor','post.dCreateTime','userinfo.sUserID','userinfo.sLoginName')
                    ->orderby('post.dCreateTime','desc')
                    ->where('iDelete','=','0')
                    ->where('iType','=','1')
                    ->where('sPostTypeID',$type)
                    ->where('userinfo.sUserID',$sUserID)
                    ->take(9)
                    ->get();
            $count = Post::where('iDelete','=','0')->where('sPostTypeID',$type)->where('sUserID',$sUserID)->count();

            $firendLinks = Link::where('iType','=','1')->get();

            $resources = Link::where('iType','=','2')->get();

            $postTypes = PostType::all();
            return view('front.front_index',['personalPosts' => $personalPosts,'count' => $count,'firendLinks' => $firendLinks,'resources' => $resources,'postTypes' => $postTypes,'type'=>$type,'personal' => 'personal']);
        }
        
    }
}
