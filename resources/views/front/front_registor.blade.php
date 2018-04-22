@extends('front.front_index')

@section('content')

<style type="text/css">
	.text-center{
		background: #fff;
	}
	#loginDiv{
		/*padding-top: 20px;*/
		margin-top: 20px;

	}
</style>

<div id="loginDiv" class="col-md-4  col-md-offset-4">
	<div class="alert alert-success hidden" role="alert" id="success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		注册成功了哟！
	  	<a href="" class="alert-link">点击去登录！</a>
	</div>
	<div class="panel panel-success" id="panel">
		<div class="panel-heading"><h2 class="panel-title">欢迎注册</h2></div>
		<div class="panel-body">
			<form id="loginForm" method="post" action="/registor">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="form-group">
					<label for="loginName">用户名</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						<input type="text" class="form-control" id="sLoginName" name="sLoginName" placeholder="请输入用户名">
					</div>
				</div>
				<div class="form-group">
					<label for="sPassword">密码</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<input type="password" class="form-control" id="sPassword" name="sPassword" placeholder="请输入密码">
					</div>
				</div>
				<div class="form-group">
					<label for="confirmsPassword">确认密码</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<input type="password" class="form-control" id="confirmsPassword" name="confirmsPassword" placeholder="请输入密码">
					</div>
				</div>
				<div class="form-group">
					<label for="email">邮箱</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						<input type="text" class="form-control" id="email" name="email" placeholder="请输入邮箱">
					</div>
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-success" style="width: 318px;" value="登录"><i class="glyphicon glyphicon-log-in"></i> 登录</button>
				</div>
			</form>
			<input type="hidden" id="msg" value="{{$msg or ''}}">
		</div>
	</div>
</div>
@endsection

@section('script')

<script type="text/javascript">
	$(function(){
		$("#loginForm").bootstrapValidator({
			message: 'This value is not valid',
	        feedbackIcons: {
	            // valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields:{
	        	sLoginName:{
	        		validators: {
	                    notEmpty: {
	                        message: '用户名不能为空!'
	                    },
	                    stringLength: {
	                        min: 6,
	                        max: 20,
	                        message: '用户名必须在6-20位之间！'
	                    },
	                    regexp: {
	                        regexp: /^[a-zA-Z0-9\.]+$/,
	                        message: '用户名必须由数字或字母组成！'
	                    }
	                }
	        	},
	        	sPassword:{
	        		validators: {
	                    notEmpty: {
	                        message: '密码不能为空！'
	                    },
	                    stringLength: {
	                        min: 6,
	                        max: 20,
	                        message: '密码必须在6-20位之间！'
	                    }
	                }
	        	},
	        	confirmsPassword:{
	        		validators: {
	        			notEmpty: {
	                        message: '密码不能为空！'
	                    },
	                    identical: {
	                        field: 'sPassword',
	                        message: '两次输入密码不一致！'
	                    }
	                }
	        	},
	        	email: {
	                validators: {
	                    notEmpty: {
	                        message: '邮箱地址不能为空！'
	                    },
	                    emailAddress: {
	                        message: '输入不是有效的电子邮件地址！'
	                    }
	                }
	            }

	        }
		});

		// 提示框显示
		var msg = $("#msg").val();
		// alert(msg);
		if(msg == "1"){
			$("#success").attr("class","alert alert-success");
			$("#panel").attr("class","hidden");
		}
	});

</script>
@endsection