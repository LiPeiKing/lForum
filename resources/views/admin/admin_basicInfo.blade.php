@extends('admin.admin_index')
@section('title')
	基本资料
@endsection
@section('content')
<div class="layui-container">  
	<div class="layui-row">
		<div class="layui-col-md5">
			<form class="layui-form" action="/basicInfo">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="layui-form-item">
					<label class="layui-form-label">登录名</label>
					<div class="layui-input-block">
						<input type="text" name="sLoginName" required  lay-verify="required" autocomplete="off" class="layui-input" disabled value="{{Session::get('sLoginName')}}">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">
						<input type="text" name="username" id="username" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input" value="{{$user->sUserName or ''}}">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">性别</label>
					<div class="layui-input-block">
						<select name="sex" id="select" lay-verify="required">
							<option value="男">男</option>
							<option value="女">女</option>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">手机号码</label>
					<div class="layui-input-block">
						<input type="text" name="tel" id="tel" required  lay-verify="phone" placeholder="请输入手机号码" autocomplete="off" class="layui-input" value="{{$user->iPhoneNumber or ''}}">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">邮箱</label>
					<div class="layui-input-block">
						<input type="text" name="email" id="email" lay-verify="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input" value="{{$user->sEmail or ''}}">
					</div>
	
				</div>
				<input type="hidden" name="id" id="id" value="{{$user->sUserID}}">
				<input type="hidden" name="sex" id="sex" value="{{$user->sSex}}">
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
	    </div>
	</div>
</div>



<script>
// 处理绑定下拉列表

//主动加载jquery模块
// layui.use(['jquery', 'layer'], function(){ 
//   var $ = layui.$ //重点处
//   ,layer = layui.layer;
  
//   //后面就跟你平时使用jQuery一样
  
//   	var sex = $("input[name='sex']").val();
//   	console.log(sex);

// 	if(sex=="男"){
// 		$("select").find("option:contains('男')").attr("selected",true);
// 	}else{
// 		$("select").find("option:contains('女')").attr("selected",true);
// 	}


// });

//Demo
layui.use('form', function(){
  var form = layui.form;
  $ = layui.jquery;

  var sex = $("input[name='sex']").val();
  console.log(sex);
  $("#select").val(sex);
  form.render('select');


  //监听提交
  form.on('submit(formDemo)', function(data){
  	var username = data.field.username;
  	var sex = $(".layui-anim .layui-this").text();
  	var tel = data.field.tel;
  	var email = data.field.email;
  	var id = $("#id").val();
  	
  	// alert(sex);
  	// console.log(sex);

   $.ajax({
    	type: 'POST',
    	url: '/ajax/edit',
    	data: '{"id":"'+id+'","username":"'+username+'","sex":"'+sex+'","tel":"'+tel+'","email":"'+email+'"}',
    	contentType: "application/json",
    	headers: {
    		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
    	},
    	success: function(data){

			if(data == 1){
				layer.msg("添加成功", { icon: 6, time: 2000 });
			}
		},
		error: function(xhr, type){
			layer.msg("添加失败", { icon: 2, time: 2000 });
		}
    });
  return false;
  });
});
</script>




@endsection