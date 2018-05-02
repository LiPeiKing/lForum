@extends('admin.admin_index')
@section('title')
帖子查看
@endsection
	
@section('content')
	<style type="text/css">
		.content{
			border:1px solid #e6e6e6;
			border-radius: 2px;
			padding: 10px 25px;
		}
	</style>

	<div class="layui-container" id="view" >
		<form class="layui-form layui-form-pane">
			<div class="layui-container">
				<div class="layui-row">
					<div class="layui-col-md4">
						<div class="layui-form-item">
							<label class="layui-form-label">帖子标题:</label>
							<div class="layui-input-block">
								<input type="text" name="sTitle" id="sTitle" disabled class="layui-input" value="{{$posts->sTitle}}">
							</div>
						</div>
					</div>

					<div class="layui-col-md4 layui-col-md-offset1">
						<div class="layui-form-item">
							<label class="layui-form-label">作者:</label>

							<div class="layui-input-block">
								<input type="text" name="sAuthor" id="sAuthor" disabled class="layui-input" value="{{$posts->sAuthor}}">
							</div>
						</div>
					</div>
				</div>

				<div class="layui-row">
					<div class="layui-col-md4">
						<div class="layui-form-item">
							<label class="layui-form-label">帖子类别:</label>

							<div class="layui-input-block">
								@if(!empty($posts->sPostTypeID))
									<input type="text" name="sPostTypeID" id="sPostTypeID" disabled class="layui-input" value="{{$posts->sName}}">
								@else 
									<input type="text" name="sPostTypeID" id="sPostTypeID" disabled class="layui-input" value="链接">
								@endif
								
							</div>
						</div>
					</div>

					<div class="layui-col-md4 layui-col-md-offset1">
						<div class="layui-form-item">
							<label class="layui-form-label">点赞量:</label>

							<div class="layui-input-block">
								<input type="text" name="iPraise" id="iPraise" disabled class="layui-input" value="{{$posts->iPraise}}">
							</div>
						</div>
					</div>
				</div>
				<div class="layui-row">
					<div class="layui-col-md4">
						<div class="layui-form-item">
							<label class="layui-form-label">创建时间:</label>

							<div class="layui-input-block">
								<input type="text" name="dCreateTime" id="dCreateTime" disabled class="layui-input" value="{{$posts->dCreateTime}}">
							</div>
						</div>
					</div>
					<div class="layui-col-md4 layui-col-md-offset1">
						<div class="layui-form-item">
							<label class="layui-form-label">修改时间:</label>

							<div class="layui-input-block">
								<input type="text" name="dModifyTime" id="dModifyTime" disabled class="layui-input" value="{{$posts->dModifyTime}}">
							</div>
						</div>
					</div>
				</div>


				<div class="layui-row">
					<div class="layui-col-md9">
						<div class="layui-form-item layui-form-text">
							<label class="layui-form-label">内容:</label>

							<div class="layui-input-block content" >
								@if(empty($posts->sPostTypeID))
									<a href="{{$posts->sLinks}}" target="_blank"><i class="layui-icon">&#xe64c;</i>链接</a>
								@endif
								{!!html_entity_decode($posts->sContent)!!}
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
	  	$("#content dl dd").eq(0).addClass("layui-this");
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
