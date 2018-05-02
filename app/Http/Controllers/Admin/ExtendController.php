<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Admin\Link;
use App\Admin\UserInfo;
use Ramsey\Uuid\Uuid;

use DB;
class ExtendController extends Controller
{
    //友情链接页面初始化
    public function linkStore(){

    	return view('Admin.admin_frindLinks');
    }

    // table 表格数据填充
    public function linkTable(Request $request){

    	$page=$request->page?$request->page:1;
		$limit=$request->limit?$request->limit:10;

    	$data = DB::table('link')
    			   ->leftjoin('userinfo','link.sCreateAdmin','=','userinfo.sUserID')
    			   ->select('link.*','userinfo.sLoginName','userinfo.sUserName')
    			   ->where('iType','=',1)
    			   ->skip($limit*($page-1))
				   ->take($limit)
    			   ->get();
    	$count = DB::table('link')
    			   ->leftjoin('userinfo','link.sCreateAdmin','=','userinfo.sUserID')
    			   ->select('link.*','userinfo.sLoginName','userinfo.sUserName')
    			   ->count();

    	return [
			'code'  =>  0,
			'msg'   => '',
			'count' => $count,
			'data'  => $data,
		];

    }

    // 保存数据
    public function linkSave(Request $request){
    	$sLinkAddress = $request->sLinkAddress;
    	$sLinkImg = $request->sLinkImg;
    	$sLinkName = $request->sLinkName;
    	$link = new Link;
    	$link->sLinkID = Uuid::uuid1();
    	$link->sLinkName = $sLinkName;
    	$link->sLinkAddress = $sLinkAddress;
    	$link->sLinkImg = $sLinkImg;
    	$link->sCreateAdmin = $request->session()->get('sUserID');
    	$link->iType = 1;
    	$link->dCreateTime = date('Y-m-d H-i-s',time());
    	if($link->save()){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    // 链接修改
    public function linkEdit(Request $request){
    	$sLinkID = $request->sLinkID;
    	$sLinkName = $request->sLinkName;
    	$sLinkAddress = $request->sLinkAddress;
    	$sLinkImg = $request->sLinkImg;

    	$link = Link::find($sLinkID);
    	$link->sLinkName = $sLinkName;
  
    	$link->sCreateAdmin = $request->session()->get('sUserID');
    	
    	$link->sLinkAddress = $sLinkAddress;
    	$link->sLinkImg = $sLinkImg;
    	$link->dModifyTime = date('Y-m-d H-i-s',time());
    	if($link->save()){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    // 链接删除
    public function linkDel(Request $request){
    	$sLinkID = $request->sLinkID;
    	$link = Link::find($sLinkID);
    	if($link->delete()){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    // 推荐资源页面初始化
    public function resourceStore(Request $request){

    	return view('admin.admin_recomResource');
    }

    // 推荐资源填充
    public function resourceTable(Request $request){
    	$page=$request->page?$request->page:1;
		$limit=$request->limit?$request->limit:10;

    	$data = DB::table('link')
    			   ->leftjoin('userinfo','link.sCreateAdmin','=','userinfo.sUserID')
    			   ->select('link.*','userinfo.sLoginName','userinfo.sUserName')
    			   ->where('iType','=',2)
    			   ->skip($limit*($page-1))
				   ->take($limit)
    			   ->get();
    	$count = DB::table('link')
    			   ->leftjoin('userinfo','link.sCreateAdmin','=','userinfo.sUserID')
    			   ->select('link.*','userinfo.sLoginName','userinfo.sUserName')
    			   ->count();

    	return [
			'code'  =>  0,
			'msg'   => '',
			'count' => $count,
			'data'  => $data,
		];

    }

    // 推荐资源添加
    public function resourceSave(Request $request){
    	$sLinkAddress = $request->sLinkAddress;
    	$sLinkImg = $request->sLinkImg;
    	$sLinkName = $request->sLinkName;
    	$link = new Link;
    	$link->sLinkID = Uuid::uuid1();
    	$link->sLinkName = $sLinkName;
    	$link->sLinkAddress = $sLinkAddress;
    	$link->sLinkImg = $sLinkImg;
    	$link->sCreateAdmin = $request->session()->get('sUserID');
    	$link->iType = 2;
    	$link->dCreateTime = date('Y-m-d H-i-s',time());
    	if($link->save()){
    		return 1;
    	}else{
    		return 0;
    	}
    }
}
