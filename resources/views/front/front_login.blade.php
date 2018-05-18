@extends('front.front_index')

@section('cantainer')

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
	<div class="alert alert-warning alert-dismissible hidden" role="alert" id="warn">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  
	</div>
	<div class="panel panel-success" id="panel">
		<div class="panel-heading"><h2 class="panel-title">欢迎登录</h2></div>
		<div class="panel-body">
			<form id="loginForm" method="post" action="/front/check">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="form-group">
					<label for="loginName">用户名</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						<input type="text" class="form-control" id="sLoginName" name="sLoginName" placeholder="请输入用户名" value="{{$sLoginName or ''}}">
					</div>
				</div>
				<div class="form-group">
					<label for="password">密码</label>
					<div class="has-feedback">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<input type="password" class="form-control" id="sPassword" name="sPassword" placeholder="请输入密码">
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
		// 表单验证
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
	                    }
	                }
	        	},
	        	sPassword:{
	        		validators: {
	                    notEmpty: {
	                        message: '密码不能为空！'
	                    }
	                }
	        	}
	        }
		});


		// 提示框显示
		var msg = $("#msg").val();
		// alert(msg);
		if(msg != ""){
			if(msg == "1"){
				$("#warn").attr("class","alert alert-warning alert-dismissible");
				$("#warn").text("登录成功");
				$("#panel").attr("class","hidden");
			}else if(msg == "2"){
				$("#warn").attr("class","alert alert-warning alert-dismissible");
				$("#warn").text("密码错误！");
			}else if(msg == "3"){
				$("#warn").attr("class","alert alert-warning alert-dismissible");
				$("#warn").text("您已违反论坛公约！请联系管理员微信my1640013955");
			}else {
				$("#warn").attr("class","alert alert-warning alert-dismissible");
				$("#warn").text("用户名不存在！");
			}
		}
		

	});

</script>
@endsection