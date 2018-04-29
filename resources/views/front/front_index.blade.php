<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>论坛</title>
</head>
<meta name="token" content="{{ csrf_token() }}"/>
<link rel="stylesheet" href="{{asset('./front/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('./front/css/jquery-confirm.css')}}">
<link rel="stylesheet" href="{{asset('./front/css/bootstrapValidator.min.css')}}">
<link rel="stylesheet" href="{{asset('./front/css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('./front/dist/summernote.css')}}">

<script src="{{asset('./front/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrap.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrapValidator.min.js')}}"></script>
<script src="{{asset('./front/js/jquery-confirm.js')}}"></script>
<script src="{{asset('./front/dist/summernote.js')}}"></script>
<script src="{{asset('./front/dist/lang/summernote-zh-CN.js')}}"></script>


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
				<form class="navbar-form navbar-left">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="搜索">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
							<ul class="nav nav-tabs">
								@if(isset($personalPosts))

									<li role="presentation" class=""><a href="/"><i class="glyphicon glyphicon-cloud" aria-hidden="true"></i> 所有动态</a></li>
										<li role="presentation" class="active" id="myAbout"><a href="/myAbout"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 我的动态</a></li>
								@else 
									<li role="presentation" class="active"><a href="/"><i class="glyphicon glyphicon-cloud" aria-hidden="true"></i> 所有动态</a></li>
									@if(Session::get('sUserID') != null)
										<li role="presentation" class="" id="myAbout"><a href="/myAbout"><i class="glyphicon glyphicon-user" aria-hidden="true"></i> 我的动态</a></li>
									@endif
									
								@endif
								
								
							</ul>
						</div>

						<div class="panel-body">
							<ul class="list-group row topic-list">
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
														<a href="javascript:;">
											                {{$postalleach->sAuthor or $postalleach->sLoginName }}	&nbsp;
											            </a>

											                发布了&nbsp;
										                <a href="/personal/post/{{$postalleach->sPostID}}" title="{{$postalleach->sTitle}}">
										                    {{$postalleach->sTitle}}
										                </a>
													@else
														<i class="glyphicon glyphicon-link" style="padding-right: 3px;" title="分享链接"></i>
														<a href="javascript:;">
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
														<a href="javascript:;">
											                {{$personalPost->sAuthor or $personalPost->sLoginName }}	&nbsp;
											            </a>

											                发布了&nbsp;
										                <a href="/personal/post/{{$personalPost->sPostID}}" title="{{$personalPost->sTitle}}">
										                    {{$personalPost->sTitle}}
										                </a>
													@else
														<i class="glyphicon glyphicon-link" style="padding-right: 3px;" title="分享链接"></i>
														<a href="javascript:;">
											                {{$personalPost->sAuthor or $personalPost->sLoginName }}	&nbsp;
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


					<!-- 友情链接 -->
					<div class="panel panel-default">
						<div class="panel-heading text-center" style="background-color: #ffffff !important;">
							<h3 class="panel-title">友情链接</h3>
						</div>
						<div class="panel-body text-center">
							<a href="https://ruby-china.org" target="_blank" rel="nofollow" title="Ruby China" style="padding: 3px;line-height: 40px;">
								<img src="https://lccdn.phphub.org/assets/images/friends/ruby-china.png" style="width:150px; margin: 3px 0;">
							</a>
						</div>
					</div>
					<!-- 推荐资源 -->
					<div class="panel panel-default">
						<div class="panel-heading text-center" style="background-color: #ffffff !important;">
							<h3 class="panel-title">推荐资源</h3>
						</div>
						<div class="panel-body">
							<ul class="list list-group" id="sidebar-resources">
								<li class="list-group-item ">
									<a href="http://d.laravel-china.org/" class="no-pjax" target="&quot;_blank&quot;" title="Laravel 中文文档">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/ql9XtosRhTe4v8HVC3TV.jpg">
										Laravel 中文文档
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://cs.laravel-china.org/" class="no-pjax" target="&quot;_blank&quot;" title="Laravel 速查表">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/cV55gsrH70qz6VdKr502.jpg">
										Laravel 速查表
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.github.io/php-the-right-way/" class="no-pjax" target="&quot;_blank&quot;" title="《PHP 之道》">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/vA50AYuscu2RCMowq7ee.png">
										《PHP 之道》
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.org/composer" class="no-pjax" target="&quot;_blank&quot;" title="Composer 中文镜像">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/KltcLb6leMa12dvTAxD7.png">
										Composer 中文镜像
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.org/topics/2530/the-highest-amount-of-downloads-of-the-100-laravel-extensions-recommended" class="no-pjax" target="&quot;_blank&quot;" title="Laravel 扩展 Top100">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/i8eVQdOiRqfK5uOEjULq.png">
										Laravel 扩展 Top100
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.org/docs/laravel-specification" class="no-pjax" target="&quot;_blank&quot;" title="Laravel 开发规范">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/slO0QIXjwi1Qmz8PIrgc.png">
										Laravel 开发规范
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.org/topics/7227/laravel-introductory-guide" class="no-pjax" target="&quot;_blank&quot;" title="Laravel 新手入门指南">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/ranAAzKyvJdx1Cpj0LKH.png">
										Laravel 新手入门指南
									</a>
								</li>
								<li class="list-group-item ">
									<a href="https://laravel-china.org/categories/1" class="no-pjax" target="&quot;_blank&quot;" title="Laravel / PHP 工作">
										<img class="media-object inline-block " src="https://lccdn.phphub.org/uploads/banners/vCE4hPLqVg9bBYnPYkZJ.png">
										Laravel / PHP 工作
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			@show
		</div>
	</div>
	<input type="hidden" id="hidsLoginID" value="{{Session::get('sUserID')}}">


</body>
<script>
	$(function(){
	
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