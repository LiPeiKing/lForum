@extends('front.front_userInfo')

@section('cantainer')
<style type="text/css">
	.box{
		background-color: #fff;
		padding: 10px;
		margin: 0 0 20px 0;
		-webkit-box-shadow: 0 0.2em 0 0 #ddd, 0 0 0 1px #ddd;
		box-shadow: 0 0.2em 0 0 #ddd, 0 0 0 1px #ddd;
	}
	.padding-md{
		padding: 15px;
	}
	.list-group{
		margin-bottom: 0px;
		border: 0;
	}
	.list-group-item {
		border: none;
		margin-bottom: 0px;
		border-bottom: 1px solid #ddd;
	}
</style>

<!-- 左侧选项 -->
<div class="col-md-3 main-col">
	<div class="box">
		<div class="padding-md">
			<div class="list-group text-center">
				<a href="/edit/info" class="list-group-item">
					<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
					&nbsp;个人信息
				</a>
				<a href="/edit/password" class="list-group-item active" id="editPassword">
					<i class="glyphicon glyphicon-lock" aria-hidden="true" ></i>
					&nbsp;修改密码
				</a>
			</div>
		</div>
	</div>
</div>

<!-- 右侧主体内容 -->
<div class="col-md-9">
	<div class="panel panel-default padding-md">
		<div class="panel-body ">
			<h2><i class="glyphicon glyphicon-lock" aria-hidden="true"></i> 修改密码</h2>
			<hr>
			<form class="form-horizontal" method="POST" role="form" id="loginForm" accept-charset="UTF-8">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">登录名</label>
					<div class="col-sm-6">
						<input class="form-control" name="sLoginName" id="sLoginName" disabled type="text" value="{{Session::get('sLoginName')}}">
					</div>
					<div class="col-sm-4 help-block">
						设置密码后将可以使用此账号登录。
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">密码</label>
					<div class="col-sm-6">
						<input class="form-control" name="sPassword" id="sPassword" type="password" value="">
					</div>
					<div class="col-sm-4 help-block" id="sUserNameTip">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">确认密码</label>
					<div class="col-sm-6">
						<input class="form-control" name="confirmsPassword" id="confirmsPassword" type="password" value="">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6">
						<input class="btn btn-primary" type="button" id="userSubmit" value="应用修改">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!--  -->
<script type="text/javascript">
	$(function(){
		// 验证
		var form = $("#loginForm");
		form.bootstrapValidator({
	            message: '输入值不合法',
	            feedbackIcons: {
	                valid: 'glyphicon glyphicon-ok',
	                invalid: 'glyphicon glyphicon-remove',
	                validating: 'glyphicon glyphicon-refresh'
	            },
	            fields: {
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
		        	}
	            }
	    });

		// ajax 提交表单
		var btn = $("#userSubmit");
		
		// var 
		btn.on("click",function(){
			var bv = form.data('bootstrapValidator');
        	bv.validate();
        	if(bv.isValid()){
        		var sPassword = $("#sPassword").val();
 
				$.ajax({
			    	type: 'POST',
			    	url: '/save/password',
			    	data: '{"sPassword":"'+sPassword+'"}',

			    	contentType: "application/json",
			    	headers: {
			    		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
			    	},
			    	success: function(data){

						if(data == 1){
							$.dialog({
								title:'',
							    content: '<div style="text-align:center">修改成功！</div>',
							}); 
							location.reload();
						}else{
							$.dialog({
								title:'',
							    content: '<div style="text-align:center">修改失败！</div>',
							});
						}
					},
					error: function(xhr, type){
						$.dialog({
								title:'',
							    content: '<div style="text-align:center">修改失败！</div>',
							});
					}
			    });
        	}
			
		});
		

	});
</script>

@endsection