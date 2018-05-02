@extends('admin.admin_index')
@section('title')
回复查看
@endsection
	
@section('content')
	<style type="text/css">
		.content{
			border:1px solid #e6e6e6;
			border-radius: 2px;
			padding: 10px 25px;
		}
		.label{
			width:135px!important ;
		}
		.input{
			margin-left: 135px !important;
		}
	</style>

	<div class="layui-container" id="view" >
		<form class="layui-form layui-form-pane">
			<div class="layui-container">
				<div class="layui-row">
					<div class="layui-col-md4">
						<div class="layui-form-item">
							<label class="layui-form-label label">所回复帖子标题:</label>
							<div class="layui-input-block input">
								<input type="text" name="sPostTitle" id="sPostTitle" disabled class="layui-input" value="{{$reply->sPostTitle}}">
							</div>
						</div>
					</div>

					<div class="layui-col-md4 layui-col-md-offset1">
						<div class="layui-form-item">
							<label class="layui-form-label label">所回复帖子作者:</label>

							<div class="layui-input-block input">
								<input type="text" name="sUserName" id="sUserName" disabled class="layui-input" value="{{$reply->sUserName}}">
							</div>
						</div>
					</div>
				</div>

				<div class="layui-row">
					<div class="layui-col-md4">
						<div class="layui-form-item">
							<label class="layui-form-label label">回复者:</label>

							<div class="layui-input-block input">
								
									<input type="text" name="sAuthor" id="sAuthor" disabled class="layui-input" value="{{$reply->sAuthor}}">
							</div>
						</div>
					</div>

					<div class="layui-col-md4 layui-col-md-offset1">
						<div class="layui-form-item">
							<label class="layui-form-label label">回复时间:</label>

							<div class="layui-input-block input">
								<input type="text" name="iPraise" id="iPraise" disabled class="layui-input" value="{{$reply->dCreateTime}}">
							</div>
						</div>
					</div>
				</div>


				<div class="layui-row">
					<div class="layui-col-md9">
						<div class="layui-form-item layui-form-text">
							<label class="layui-form-label">内容:</label>

							<div class="layui-input-block content" >
								{!!html_entity_decode($reply->sContent)!!}
							</div>
						</div>
					</div>
				</div>

				<button class="layui-btn" type="button" id="back">
				  	<i class="layui-icon">&#xe65c;</i> 返回
				</button>
			</div>
		</form>
		
	</div>

<script type="text/javascript">
	//主动加载jquery模块
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){
	  	$("#content").addClass("layui-nav-itemed");
	  	$("#content dl dd").eq(1).addClass("layui-this");
	  }); 

	  $("#back").on('click',function(){
	  	history.back(-1);
	  });
	});

	// 加载依赖form模块
	layui.use('form', function(){
		var form = layui.form;
	  //监听提交依赖模块table
	  form.on('submit(search)', function(data){
	  	// 取值
	  	// var title = data.field.title;
	  	// var author = data.field.author;
	  	// var type = data.field.type;

	  	// $.ajax({
	  	// 	ype: 'POST',
	  	// 	url: '/ajax/search',
	  	// 	data: '{"title":"'+title+'","author":"'+author+'","type":"'+type+'"}',
	  	// 	contentType: "application/json",
	  	// 	headers: {
	  	// 		'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
	  	// 	},
	  	// 	success: function(data){

	  	// 		if(data == 1){
	  	// 			layer.msg("添加成功", { icon: 6, time: 2000 });
	  	// 		}
	  	// 	},
	  	// 	error: function(xhr, type){
	  	// 		layer.msg("添加失败", { icon: 2, time: 2000 });
	  	// 	}
	  	// });


	  	return false;
	  });
	});

</script>
@endsection
