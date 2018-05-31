<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>论坛</title>
	<link rel="shortcut icon" href="{{asset('./front/images/logohead.ico')}}" />
</head>
<meta name="token" content="{{ csrf_token() }}"/>
<link rel="stylesheet" href="{{asset('./front/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('./front/css/jquery-confirm.css')}}">
<link rel="stylesheet" href="{{asset('./front/css/bootstrapValidator.min.css')}}">
<link rel="stylesheet" href="{{asset('./front/css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('./front/dist/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('./front/css/font-awesome.min.css')}}">

<script src="{{asset('./front/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrap.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('./front/js/jquery-confirm.js')}}"></script>
<script src="{{asset('./front/dist/summernote.js')}}"></script>
<script src="{{asset('./front/dist/lang/summernote-zh-CN.js')}}"></script>
<script src="{{asset('./front/js/jqPaginator.js')}}"></script>


<style type="text/css">
	.media-object{
	    width: 20px !important;
	    border-radius: 2px;
	    margin-right: 4px;
	    margin-top: 0px !important;
	    display: inline-block;
	}
	a{
		color:#555;
		
	}
	#sidebar-resources{
    	margin-bottom: -10px;
		
	}

	#sidebar-resources li{
		margin-bottom: 4px;
	    line-height: 18px;
	    display: inline-block;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	    width: 100%;
	    font-size: 13px;
	    padding: 5px;
    	margin-top: -4px;
    	margin-bottom: 2px;
        border: none;
        border-bottom: 1px solid #f2f2f2;
	}
	.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover{
		background-color:#ffffff;
	}
	#head{
		width: 20px;
		margin-top: 1px;
	}
	.topic-list {
	    margin-bottom: 0px;
        color: #8b8a8a;
        margin-left: -15px;
    	margin-right: -15px;
    	margin-top: 0;
	}
	.topic-list .list-group-item{
	    padding: 5px 28px;
	    border: none;
	    margin-bottom: 0px;
	    border-bottom: 1px dashed #eae7e7;
	    margin-top: 10px;
	}
	.empty-block {
		text-align: center;
		line-height: 60px;
		margin: 10px;
		color: #ccc;
	}

</style>
<body  style=" overflow:scroll">
	<!-- 导航栏 -->
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- logo -->
			<a class="navbar-brand" href="/"><img src="{{asset('./front/images/logo.jpg')}}" class="logo" class="img-rounded"></a>

			<!-- 导航栏的响应式按钮 -->
			<div class="navbar-header navbar-right">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
					<span class="sr-only">Toggle navigation</span>  
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<form class="navbar-form navbar-left" action="/search" method="post">
					<div class="form-group">
						<div class="input-group">
							<input type="hidden" name="_token" value="{{csrf_token()}}"/>
							<input type="text" class="form-control" name="search" id="search" placeholder="搜索">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
							</span>
						</div>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class="text-center"><a href="/">首页</a></li>

					@if(Session::get('sLoginName') == null)
						<li class="text-center"><a href="/front/login">登录</a></li>
						<li class="text-center"><a href="/front/register">注册</a> </li>
					@else 
						<li class="text-center">
							<a href="#" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dLabel">
								<img class="img-rounded" id="head" alt="liking" src="{{asset('./front/images/caomei.jpg')}}">
								@if(Session::get('sUserName') != null)
									{{Session::get('sUserName')}}
								@else
									{{Session::get('sLoginName')}}
								@endif
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dLabel">
								<li class="text-center">
									<a class="button" href="/personal/center">
										<i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;个人中心
									</a>
								</li>
								<li class="text-center">
									<a class="button" href="/edit/info">
										<i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;&nbsp;&nbsp;编辑资料
									</a>
								</li>
								@if(Session::get('sRole') != "普通用户")
									<li class="text-center">
										<a class="button" href="/postList">
											<i class="fa fa-external-link-square"></i> &nbsp;&nbsp;&nbsp;前往后台
										</a>
									</li>
								@endif
								<li class="text-center">
									<a id="logout" class="button" href="javascript:;">
										<i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;&nbsp;&nbsp;退出登陆
									</a>
								</li>
							</ul>
						</li>
					@endif
					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	<!-- 主体显示 -->
	<div class="container main-container ">
		<div class="cantainer">
			@section('cantainer')
				@section('content')
				<div class="col-md-9 main-col">
					<div class="panel panel-default">
						<div class="panel-heading" style="background-color: #ffffff !important;border:none;margin-bottom: -18px">
							<ul class="nav nav-tabs" id="dongtai">
								@if(!empty($personal))

									<li role="presentation" class=""><a href="/"><i class="glyphicon glyphicon-cloud" aria-hidden="true"></i> 所有动态</a></li>
										<li role="presentation" class="active" id="myAbout"><a href="/myAbout"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 我的动态</a></li>
								@else 
									<li role="presentation" class="active"><a href="/"><i class="glyphicon glyphicon-cloud" aria-hidden="true"></i> 所有动态</a></li>
									@if(Session::get('sUserID') != null)
										<li role="presentation" class="" id="myAbout"><a href="/myAbout"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 我的动态</a></li>
									@endif
									
								@endif
								
								<li class="pull-right" id="postType">
									<select class="form-control">
										<option value="0">请选择分类</option>
										@if(!empty($postTypes))
											@foreach($postTypes as $postType)
												@if(!empty($type))
													@if($postType->id == $type)
														<option value="{{$postType->id}}" selected="selected">{{$postType->sName}}</option>
													@else 
														<option value="{{$postType->id}}">{{$postType->sName}}</option>
													@endif
												@else
													<option value="{{$postType->id}}">{{$postType->sName}}</option>
												@endif
											@endforeach
										@endif
										@if(!empty($type))
											@if($type == "link")
												<option value="link" selected="selected">链接</option>
											@else 
												<option value="link">链接</option>
											@endif
										
										@endif
									</select>
								</li>
								
							</ul>
						</div>

						<div class="panel-body">
							<ul class="list-group row topic-list" id="main">
								<!-- 此处为了在后面的继承模板中不出错 -->
								@if(!empty($postall))
									@foreach($postall as $postalleach)
										<li class="list-group-item media">
										    <div class="avatar pull-left">
										      
										    </div>
										    <div class="infos">
										        <div class="media-heading">
													@if($postalleach->iType == '1')
														<i class="glyphicon glyphicon-list-alt" style="padding-right: 3px;" title="发表新帖"></i>
														<a href="/view/personal/{{$postalleach->sUserID}}">
											                {{$postalleach->sAuthor or $postalleach->sLoginName }}	&nbsp;
											            </a>

											                发布了&nbsp;
										                <a href="/personal/post/{{$postalleach->sPostID}}" title="{{$postalleach->sTitle}}">
										                    {{$postalleach->sTitle}}
										                </a>
													@else
														<i class="glyphicon glyphicon-link" style="padding-right: 3px;" title="分享链接"></i>
														<a href="/view/personal/{{$postalleach->sUserID}}">
											                {{$postalleach->sAuthor or $postalleach->sLoginName }}	&nbsp;
											            </a>

											                分享了&nbsp;
										                <a href="/personal/post/{{$postalleach->sPostID}}" title="{{$postalleach->sTitle}}">
										                    {{$postalleach->sTitle}}
										                </a>
													@endif
												
										            
										            <span class="meta pull-right">
										                 <span class="glyphicon glyphicon-calendar" style="padding-right: 5px;padding-top: 0px;" title="发布时间"></span><span>{{$postalleach->dCreateTime}}</span>

										            </span>
										        </div>
										    </div>
										</li>
									@endforeach
								@elseif(!empty($personalPosts))
									@foreach($personalPosts as $personalPost)
										<li class="list-group-item media">
										    <div class="avatar pull-left">
										      
										    </div>
										    <div class="infos">
										        <div class="media-heading">
													@if($personalPost->iType == '1')
														<i class="glyphicon glyphicon-list-alt" style="padding-right: 3px;" title="发表新帖"></i>
														<a href="/view/personal/{{$personalPost->sUserID}}">
											                {{$personalPost->sAuthor or $personalPost->sLoginName }}	&nbsp;
											            </a>

											                发布了&nbsp;
										                <a href="/personal/post/{{$personalPost->sPostID}}" title="{{$personalPost->sTitle}}">
										                    {{$personalPost->sTitle}}
										                </a>
													@else
														<i class="glyphicon glyphicon-link" style="padding-right: 3px;" title="分享链接"></i>
														<a href="/view/personal/{{$personalPost->sUserID}}">
											                {{$personalPost->sAuthor or $personalPost->sLoginName }}&nbsp;
											            </a>

											                分享了&nbsp;
										                <a href="/personal/post/{{$personalPost->sPostID}}" title="{{$personalPost->sTitle}}">
										                    {{$personalPost->sTitle}}
										                </a>
													@endif
												
										            
										            <span class="meta pull-right">
										                 <span class="glyphicon glyphicon-calendar" style="padding-right: 5px;padding-top: 0px;" title="发布时间"></span><span>{{$personalPost->dCreateTime}}</span>

										            </span>
										        </div>
										    </div>
										</li>
									@endforeach
								@else 
									<div class="empty-block">没有任何数据~~</div>
								@endif
								
							</ul>

							<ul class="pagination pull-right" id="pag">
								
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				@show

				<!-- 登录前隐藏登陆后显示 操作按钮 -->
				<div class="col-md-3">
					@if(Session::get('sLoginName') != null)
						<div class="panel panel-default">
							<div class="panel-body text-center">
								<a style="margin: 4px;" class="btn btn-default" href="/topics/create">
						            <i class="glyphicon glyphicon-pencil"></i> 发起讨论
						        </a>
						        <a style="margin: 4px;" class="btn btn-default" href="/links/share">
						            <i class="glyphicon glyphicon-share"></i> 分享链接
						        </a>
						        
							</div>
						</div>
					@endif

					<!-- 推荐资源 -->
					<div class="panel panel-default">
						<div class="panel-heading text-center" style="background-color: #ffffff !important;">
							<h3 class="panel-title">推荐资源</h3>
						</div>
						<div class="panel-body">
							<ul class="list list-group" id="sidebar-resources">
								@if(!empty($resources))
									@foreach($resources as $resource)
										<li class="list-group-item ">
											<a href="{{$resource->sLinkAddress}}" class="no-pjax" target="&quot;_blank&quot;" title="{{$resource->sLinkName}}">
												<img class="media-object inline-block " src="{{$resource->sLinkImg}}">
												{{$resource->sLinkName}}
											</a>
										</li>
									@endforeach
								@endif
								
							</ul>
						</div>
					</div>
					<!-- 友情链接 -->
					<div class="panel panel-default">
						<div class="panel-heading text-center" style="background-color: #ffffff !important;">
							<h3 class="panel-title">友情链接</h3>
						</div>
						<div class="panel-body text-center">
							@if(!empty($firendLinks))
								@foreach($firendLinks as $link)
									<a href="{{$link->sLinkAddress}}" target="_blank" rel="nofollow" title="{{$link->sLinkName}}" style="padding: 3px;line-height: 40px;">
										<img src="{{$link->sLinkImg}}" style="width:110px; margin: 3px 0;">
									</a>
								@endforeach
							@endif
						</div>
					</div>
					

					<div class="panel panel-default">
						<div class="panel-heading text-center" style="background-color: #ffffff !important;">
							<h3 class="panel-title">论坛源码</h3>
						</div>
						<div class="panel-body text-center">
							<ul class="list list-group" id="sidebar-resources">
								<a href="https://github.com/LiPeiKing/lForum" target="_blank" rel="nofollow" title="GitHub地址" style="padding: 3px;line-height: 40px;">
										<img src="{{asset('./front/images/logo.jpg')}}" style="width:110px; margin: 3px 0;">
									</a>
							</ul>
						</div>
					</div>


				</div>
			@show
		</div>
	</div>

	<input type="hidden" id="hidsLoginID" value="{{Session::get('sUserID')}}">
	@if (!empty($personal))
		<input type="hidden" id="hidDongtai" value="{{'geren'}}">
	@else 
		<input type="hidden" id="hidDongtai" value="{{'all'}}">
	@endif

</body>
<script>
	$(function(){

		// 分类查询
		$("#postType select").change(function(){
			if($("#hidDongtai").val() == "geren"){
				var tmpValue = $(this).val();
				if(tmpValue == '0'){
					location.href = "/myAbout";
				}else{
					location.href = "/typeViewPersonal/"+tmpValue;
				}
			}else{
				var tmpValue = $(this).val();
				if(tmpValue == '0'){
					location.href = "/";
				}else{
					location.href = "/typeView/"+tmpValue;
				}
			}
			
		});

		// 分页插件
		$("#pag").jqPaginator({
	      	// totalCounts:{{$count or '9'}},
	      	totalCounts: {{$count or 9}},
	      	pageSize:9,
		    // disableClass:'disabled',
		    currentPage: {{$page or 1}},
	      	first: '<li class="first"><a href="javascript:void(0);">首页</a></li>',
	      	last: '<li class="last"><a href="javascript:void(0);">尾页</a></li>',
	      	page: '<li class="page"><a href="javascript:void(0);">\{\{page\}\}</a></li>',
	      	onPageChange: function (num, type) {
	      		// console.log(num);
	      		// console.log(type);
	      		if(type != "init"){
	      			var tmpValue = $("#hidDongtai").val();
	      			var tmpType = $("#postType select option:selected").val();
	      			location.href = "/page/"+num+'/'+tmpValue+'/'+tmpType;

	      		}

	   //    		$.ajax({
				// 	type: 'POST',
				// 	url: '/page',
				// 	data: '{"num":"'+num+'"}',
				// 	contentType: "application/json",
				// 	headers: {
				// 		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
				// 	},
				// 	success: function(data){
						
				// 	},
				// 	error: function(xhr, type){
						

				// 	}

				// });

	      	}
		});
	});


	$("#logout").on('click',function(){
			$.confirm({
			    title: '提示：',
			    content:'<div style="text-align:center;">您确定退出登录么？</div>',
			    // offsetBottom:'10px',
			    buttons: {
			        确定: {
			        	 btnClass: 'btn-blue',
			        	 action:function(){
			            	location.href = "/front/logout";
			        	 }
			        },
			        取消: function () {
			        }
			    }
			});
		})
</script>
@section('script')

@show
</html>