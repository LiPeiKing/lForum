@extends('admin.admin_index')
@section('title')
	安全设置
@endsection

@section('content')

	<div class="layui-container">  
		<div class="layui-row">
			<div class="layui-col-md5">
				<form class="layui-form" action="">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<div class="layui-form-item">
						<label class="layui-form-label">旧密码</label>
						<div class="layui-input-block">
							<input type="password" name="usedpassword" id="usedpassword" lay-verify="required" autocomplete="off" class="layui-input" value="" placeholder="请输入旧密码" />
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">新密码</label>
						<div class="layui-input-block">
							<input type="password" name="password" id="password" lay-verify="password" placeholder="请输入新密码" autocomplete="off" class="layui-input"> 
						</div>
					</div>

					<div class="layui-form-item">
						<label class="layui-form-label">确认密码</label>
						<div class="layui-input-block">
							<input type="password" name="confirmPassword" id="confirmPassword" lay-verify="confirmPassword" placeholder="确认密码" autocomplete="off" class="layui-input" value="">
						</div>
		
					</div>

					<div class="layui-form-item">
						<div class="layui-input-block">
							<button class="layui-btn" lay-submit lay-filter="formDemo"><i class="fa fa-pencil fa-fw"></i>修改</button>
							<button type="reset" class="layui-btn layui-btn-primary"><i class="fa fa-undo"></i> 重置</button>
						</div>
					</div>
				</form>
		    </div>
		</div>
	</div>
	<script>
		layui.use('form', function(){
		  	var form = layui.form;
		  	
		  	form.verify({
		  		password:[
				    /^[\S]{6,12}$/
				    ,'密码必须6到12位，且不能出现空格'
				  ],
				confirmPassword:function(value){
					var repassvalue = $('#password').val();
					if(value != repassvalue){
						return '两次输入的密码不一致!';
					}
				}
		  	});

		  	form.on('submit(formDemo)',function(data){
		  		
		  		var usedpassword = $("#usedpassword").val();
		  		var password = $("#password").val();
		  		var confirmPassword = $("#confirmPassword").val();
		  		// console.log(usedpassword);
		  		// console.log(password);
		  		// console.log(confirmPassword);
		  		$.ajax({
			    	type: 'POST',
			    	url: '/password/edit',
			    	data: '{"usedpassword":"'+usedpassword+'","password":"'+password+'","confirmPassword":"'+confirmPassword+'"}',
			    	contentType: "application/json",
			    	headers: {
			    		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
			    	},
			    	success: function(data){

						if(data == 1){
							layer.msg("密码修改成功!", { icon: 6, time: 1500 });
						}else if(data == 2){
							layer.msg("旧密码输入错误", { icon: 2, time: 1500 });
						}else{
							layer.msg("修改失败", { icon: 2, time: 1500 });

						}
					},
					error: function(xhr, type){
						layer.msg("添加失败", { icon: 2, time: 1500 });
					}
			    });


		  		return false;
		  	});
		  
		});
</script>

@endsection