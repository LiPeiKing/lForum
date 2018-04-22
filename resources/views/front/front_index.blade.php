<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>论坛</title>
</head>
<link rel="stylesheet" href="{{asset('./front/css/bootstrap.min.css')}}">

<link rel="stylesheet" href="{{asset('./front/css/bootstrapValidator.min.css')}}">
<link rel="stylesheet" href="{{asset('./front/css/main.css')}}">

<script src="{{asset('./front/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrap.min.js')}}"></script>
<script src="{{asset('./front/js/bootstrapValidator.min.js')}}"></script>
<body>
	<!-- 导航栏 -->
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- logo -->
			<a class="navbar-brand" href="javascript:;"><img src="{{asset('./front/images/logo.jpg')}}" class="logo" class="img-rounded"></a>

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
					<li class="text-center"><a href="#">首页</a></li>
					<li class="text-center"><a href="/front/login">登录</a></li>
					<li class="text-center"><a href="/front/register">注册</a> </li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<!-- 导航栏登录模态框 -->
	<!-- <div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title" id="myModalLabel">请登录</h5>
				</div>
				<div class="modal-body ">
					<div class="row">
						<form>
							<div class="col-md-10 col-md-offset-1 form-group has-feedback">

								<span class="glyphicon glyphicon-user form-control-feedback"></span>
								<input type="text" class="form-control" id="loginName" name="loginName" placeholder="用户名">
							</div>
							<div class="col-md-10 col-md-offset-1 form-group has-feedback">
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								<input type="password" class="form-control" id="password" name="password" placeholder="密码">
							</div>
							
							<div class="col-md-5 center-block">
								<a href="#">还没有账号？点我注册</a>
							</div>
							<div class="col-md-6 text-right">
								<input type="submit" class="btn btn-primary" value="登录">
								<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
 -->

	<!-- 主体显示 -->
	<div class="container main-container ">
		@section('content')

		@show
		
	</div>

	
	
	
</body>

@section('script')

@show
</html>