<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台</title>
	<meta name="token" content="{{ csrf_token() }}"/>
	<link rel="stylesheet" href="{{asset('/admin/layui/css/layui.css')}}">
	
	<link rel="stylesheet" href="{{asset('/admin/css/main.css')}}">
	<script src="{{asset('/admin/layui/layui.js')}}"></script>

</head>
<body style="height:100%">
	<div class="layui-layout layui-layout-admin layui-bg-molv">
	  	<div class="layui-header layui-bg-cyan">
	  		<div class="layui-logo">
	  			论坛后台管理系统
	  		</div>
		    <ul class="layui-nav layui-layout-right">
		    	<li class="layui-nav-item">
		    		<a href="javascript:;">前台入口</a>
		    	</li>
		      <li class="layui-nav-item">
		        <a href="javascript:;">
		          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
		          {{Session::get('sLoginName')}}
		        </a>
		        <dl class="layui-nav-child">
		          <dd><a href="/basicInfo">基本资料</a></dd>
		          <dd><a href="/setting">安全设置</a></dd>
		          <dd><a href="/logout">退出登录</a></dd>

		        </dl>
		      </li>
		    </ul>
	  	</div>
	  
	  <div class="layui-side layui-bg-cyan">
	    <div class="layui-side-scroll ">
	      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
	      <ul class="layui-nav layui-bg-cyan layui-nav-tree"  lay-filter="test">
	        
	        <li class="layui-nav-item" id="content">
	          <a href="javascript:;">内容管理</a>
	          <dl class="layui-nav-child">
	            <dd><a href="/postList">帖子管理</a></dd>
	            <dd><a href="/reply">回复管理</a></dd>
	            <dd><a href="/postRecycle">帖子回收站</a></dd>
	          </dl>
	        </li>
	        <li class="layui-nav-item " id="user">
	          <a class="" href="javascript:;">用户管理</a>
	          <dl class="layui-nav-child">
	            <dd><a href="/common">普通用户管理</a></dd>
	            <dd id="addManager"><a href="/manager">管理员用户管理</a></dd>
	            <dd><a href="/blackList">黑名单管理</a></dd>
	          </dl>
	        </li>
	        <li class="layui-nav-item">
	        	<a href="javascript:;">扩展管理</a>
	        	<dl class="layui-nav-child">
	        		<dd><a href="javascript:;">友情链接</a></dd>
	        		<dd><a href="javascript:;">论坛公告</a></dd>
	        		<!-- <dd><a href="javascript:;">更新日志</a></dd> -->
	        		<!-- <dd><a href="javascript:;">给我留言</a></dd> -->
	        		<dd><a href="javascript:;">论坛信息</a></dd>

	        	</dl>
	        </li>
	      </ul>
	    </div>
	  </div>
	  
	  <div class="layui-body">
	    <!-- 内容主体区域 -->
	   
		<div class="layui-tab layui-tab-brief" lay-filter="tab" lay-allowClose="true">
			<ul id="tabTitle" class="layui-tab-title">
			   <li lay-id="0" class="layui-this">@section('title')首页@show</li>
			</ul>
			<div class="layui-tab-content">
				<div class="layui-tab-item layui-show">
					@section('content')
					<!-- <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
	                    上次登陆
	                    <span style="padding-left:1em;">IP：{{$logs->sIp or ''}}</span>
	                    <span style="padding-left:1em;">地点：{{$logs->sAddress or '未知'}}</span>
	                    <span style="padding-left:1em;">时间：{{$logs->dLogin or ''}}</span>
	                </p> -->
	                <!-- <h1>{{Session::get('sUserID')}}</h1> -->
                	@show
				</div>
			  	<input type="hidden" id="sRoleRoot" value="{{Session::get('sRole') or ''}}">
			</div>
	  </div>
	  
	  <div class="layui-footer">
	    <!-- 底部固定区域 -->
	    © layui.com - 底部固定区域
	  </div>
	</div>
	<!-- 引入自定义的js文件 -->
	<script src="{{asset('/admin/js/main.js')}}"></script>
	<script type="text/javascript">
		layui.use(['jquery'], function(){ 
			// 重点处 转让 $ 使用
			var $ = layui.$;
			  
			//后面就跟你平时使用jQuery一样
			  	var sRoleRoot = $("#sRoleRoot").val().trim();
			  	layui.use('layer', function(){
				  var layer = layui.layer;
				  var $ = layui.$;
				  // var msg = $("#msg").val();
				  if(sRoleRoot.length<1){
				  	$("#addManager").hide();
				  	// alert("www");
				  }

				});
		});
	</script>
	

</body>
</html>