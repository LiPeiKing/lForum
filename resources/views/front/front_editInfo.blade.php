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
				<a href="/edit/info" class="list-group-item active">
					<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
					&nbsp;个人信息
				</a>
				<a href="/edit/password" class="list-group-item ">
					<i class="glyphicon glyphicon-lock" aria-hidden="true"></i>
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
			<h2><i class="glyphicon glyphicon-cog" aria-hidden="true"></i> 编辑个人资料</h2>
			<hr>
			<form class="form-horizontal" method="POST" role="form" id="loginForm" accept-charset="UTF-8">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">登录名</label>
					<div class="col-sm-6">
						<input class="form-control" name="sLoginName" id="sLoginName" disabled type="text" value="{{Session::get('sLoginName')}}">
					</div>
					<div class="col-sm-4 help-block">
						登录名不允许修改
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-6">
						<input class="form-control" name="sUserName" id="sUserName" type="text" value="{{$users->sUserName or ''}}">
					</div>
					<div class="col-sm-4 help-block" id="sUserNameTip">
						用户名只能修改一次，请谨慎操作
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">性别</label>
					<div class="col-sm-6">
						<select class="form-control" name="gender">
							<option value="男">男</option>
							<option value="女">女</option>
						</select>
					</div>
					<div class="col-sm-4 help-block"></div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">GitHub Name</label>
					<div class="col-sm-6">
						<input class="form-control" name="sGitHub" id="sGitHub" type="text" value="{{$users->sGitHub or ''}}">
					</div>

					<div class="col-sm-4 help-block">
						请跟 GitHub 上保持一致
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">邮 箱</label>
					<div class="col-sm-6">
						<input class="form-control" name="sEmail" id="sEmail" type="text" value="{{$users->sEmail or ''}}">
					</div>
					<div class="col-sm-4 help-block">
						如：name@website.com
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">真实姓名</label>
					<div class="col-sm-6">
						<input class="form-control" name="sRealName" id="sRealName" type="text" value="{{$users->sRealName or ''}}">
					</div>
					<div class="col-sm-4 help-block">
						如：李小明
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">城市</label>
					<div class="col-sm-6">
						<input class="form-control" name="sCity" id="sCity" type="text" value="{{$users->sCity or ''}}">
					</div>
					<div class="col-sm-4 help-block">
						如：北京、广州
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">公司</label>
					<div class="col-sm-6">
						<input class="form-control" name="sCompany" id="sCompany" type="text" value="{{$users->sCompany or ''}}">
					</div>
					<div class="col-sm-4 help-block">
						如：阿里巴巴
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">个人网站</label>
					<div class="col-sm-6">
						<input class="form-control" name="sWebsite" id="sWebsite" type="text" value="{{$users->sWebsite}}">
					</div>
					<div class="col-sm-4 help-block">
						如：example.com，不需要加前缀 https://
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-2 control-label">个人简介</label>
					<div class="col-sm-6">
						<textarea class="form-control" rows="3" name="sIntroduction" id="sIntroduction" cols="50" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;" value="">{{$users->sIntroduction or ''}}</textarea>
					</div>
					<div class="col-sm-4 help-block">
						请一句话介绍你自己，大部分情况下会在你的头像和名字旁边显示
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6">
						<input class="btn btn-primary" type="button" id="userSubmit" value="应用修改">
					</div>
				</div>
			</form>
			<input type="hidden" id="changeNum" value="{{$users->sChangeName or ''}}">
			<input type="hidden" id="sex" value="{{$users->sSex or ''}}">

		</div>
	</div>
</div>

<!-- 提示模态框 -->

<div class="modal fade bs-example-modal-sm" id="success" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		<div class="modal-body text-center">
			<h5><i class="glyphicon glyphicon-ok" style="color: green;margin-right: 20px;"></i>修改成功！</h5>
		</div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-sm" id="error" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		<div class="modal-body text-center">
			<h5><i class="glyphicon glyphicon-remove" style="color: red;margin-right: 20px;"></i>修改失败！</h5>
		</div>
    </div>
  </div>
</div>


<!--  -->
<script type="text/javascript">
	$(function(){
		
		var changeNum = $("#changeNum").val();
		var sex = $("#sex").val();
		// alert(sex+changeNum);
		if(changeNum == '1'){
			$("#sUserName").attr("disabled","disabled");
			$("#sUserNameTip").text("已使用了一次修改用户名的机会");

		}
		$("select").find("option[value = '"+sex+"']").attr("selected","selected");

		// 进行表单规则验证
		var form = $("#loginForm");

	
		form.bootstrapValidator({
	            message: '输入值不合法',
	            feedbackIcons: {
	                // valid: 'glyphicon glyphicon-ok',
	                // invalid: 'glyphicon glyphicon-remove',
	                validating: 'glyphicon glyphicon-refresh'
	            },
	            fields: {
	                sEmail: {
	                    validators: {
	                        emailAddress: {
	                            message: '请输入正确的邮件地址如：123@qq.com'
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
        		var sLoginName = $("#sLoginName").val();
        		var sUserName = $("#sUserName").val();
				var sSex = $("select option:selected").val();
				var sGitHub = $("#sGitHub").val();
				var sEmail = $("#sEmail").val();
				var sRealName = $("#sRealName").val();
				var sCity = $("#sCity").val();
				var sCompany = $("#sCompany").val();
				var sWebsite = $("#sWebsite").val();
				var sIntroduction = $("#sIntroduction").val();

				console.log(sLoginName);
				console.log(sUserName);
				console.log(sSex);
				console.log(sGitHub);
				console.log(sEmail);
				console.log(sRealName);
				console.log(sCompany);
				// var token = $('meta[name="token"]').attr("content");
				$.ajax({
			    	type: 'POST',
			    	url: '/edit/edit',
			    	data: '{"sLoginName":"'+sLoginName+'","sUserName":"'+sUserName+'","sSex":"'+sSex+'","sGitHub":"'+sGitHub+'","sRealName":"'+sRealName+'","sEmail":"'+sEmail+'","sCity":"'+sCity+'","sCompany":"'+sCompany+'","sWebsite":"'+sWebsite+'","sIntroduction":"'+sIntroduction+'"}',

			    	contentType: "application/json",
			    	headers: {
			    		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
			    	},
			    	success: function(data){

						if(data == 1){
							

							$('#success').modal('toggle');
						}else{
							$('#error').modal('toggle');

						}
					},
					error: function(xhr, type){
						$('#error').modal('toggle');
					}
			    });
        	}
			
		});
		

	});
</script>

@endsection