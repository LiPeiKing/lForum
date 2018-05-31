<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台</title>
	<meta name="token" content="{{ csrf_token() }}"/>
	<link rel="stylesheet" href="{{asset('/admin/layui/css/layui.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('./front/dist/summernote.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('./front/css/font-awesome.min.css')}}">

	
	<link rel="stylesheet" href="{{asset('/admin/css/main.css')}}">
	<script src="{{asset('./front/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('./front/dist/summernote.js')}}"></script>
	<script src="{{asset('./front/dist/lang/summernote-zh-CN.js')}}"></script>
	<script src="{{asset('/admin/layui/layui.js')}}"></script>

</head>
<body class="layui-layout-body">
	<div class="layui-layout layui-layout-admin layui-bg-molv">
	  	<div class="layui-header layui-bg-cyan">
	  		<div class="layui-logo">
	  			论坛后台管理系统
	  		</div>
		    <ul class="layui-nav layui-layout-right">
		      <li class="layui-nav-item">
		        <a href="javascript:;">
		          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
		          @if(!empty(Session::get('sUserName')))
					{{Session::get('sUserName')}}
		          @else 
					{{Session::get('sLoginName')}}
		          @endif
		        </a>
		        <dl class="layui-nav-child">
		          <dd><a href="/basicInfo"><i class="fa fa-user-o fa-fw"></i> 基本资料</a></dd>
		          <dd><a href="/setting"><i class="layui-icon" style="font-size: 17px;">&#xe620;</i> 安全设置</a></dd>
		          <dd><a href="/"><i class="fa fa-external-link fa-fw"></i> 前往前台</a></dd>
		          <dd><a href="javascript:;" id="logout"><i class="fa fa-sign-out fa-fw"></i> 退出登录</a></dd>
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
		        <li class="layui-nav-item" id="extend">
		        	<a href="javascript:;">扩展管理</a>
		        	<dl class="layui-nav-child">
		        		<dd><a href="/frind/links">友情链接</a></dd>
		        		<dd><a href="/recom/resource">推荐资源</a></dd>
		        		<!-- <dd><a href="javascript:;">论坛公告</a></dd>
		        		<dd><a href="javascript:;">论坛信息</a></dd> -->

		        	</dl>
		        </li>
		      </ul>
		    </div>
	  	</div>
	  
	  	<div class="layui-body" style="margin-bottom:-75px;padding-bottom: 0px;">
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
			  	<input type="hidden" id="sRoleRoot" value="{{Session::get('sRole')}}">
			</div>
	  		</div>
		</div>
	</div>
</body>
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
			  // alert(sRoleRoot);
			  if(sRoleRoot != "root"){
			  	$("#addManager").hide();
			  	// alert("www");
			  }

			});

			// 退出点击事件
			$("#logout").on('click',function(){
				layer.confirm('您确定要退出么',{ icon: 3}, function(index){
        			$.ajax({
        				type:'POST',
        				url:'/logout',
        				data:'{"id":"1"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					console.log(data);
        					if(data == 1){
        						location.href="/admin_login";
        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("因系统原因退出失败！", { icon: 5, time: 2000 });
        					}
        			});

        			layer.close(index);
        		});
			});
		});
	</script>
</html>