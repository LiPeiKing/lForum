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
	/*.text-center .row{
		padding-top: 20px;
	}*/
	form{
		/*padding: 10px;*/
	}
</style>
<div id="loginDiv" class="col-md-4  col-md-offset-4">
	<div class="panel panel-success">
		<div class="panel-heading"><h2 class="panel-title">请登录</h2></div>
		<div class="panel-body">
			<form id="loginForm" method="post" action="/front/check">
				<div class="form-group">
					<label for="loginName">用户名</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						<input type="text" class="form-control" id="loginName" name="loginName" placeholder="请输入用户名">
					</div>
				</div>
				<div class="form-group">
					<label for="password">密码</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<input type="password" class="form-control" id="password" name="password" placeholder="请输入密码">
					</div>
				</div>
				
				<div class="form-group">
					<input type="submit" class="btn btn-success" style="width: 318px;" value="登录">
				</div>
			</form>

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
	        	loginName:{
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
	        	password:{
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
	        	}

	        }
		});

	});

</script>
@endsection