@extends('admin.admin_index')
@section('title')
帖子管理
@endsection

@section('content')
<style type="text/css">
table th{
	text-align: center !important;
}
table td{
	text-align: center !important;
}
.layui-table-cell{
	height:36px;
	line-height: 36px;
}
#view input{
	border-width: 0;
}
textarea{
	border-width: 0 !important;
	resize:none !important;
}
</style>

<form class="layui-form" action="/post/search" method="post">
	<div class="layui-form-item">
		<label class="layui-form-label">帖子名</label>
		<div class="layui-input-inline">
			<input type="text" name="title" placeholder="请输入帖子名称" autocomplete="off" class="layui-input">
		</div>
		<label class="layui-form-label">作者</label>
		<div class="layui-input-inline">
			<input type="text" name="author" placeholder="请输入作者" autocomplete="off" class="layui-input">
		</div>
		<label class="layui-form-label">帖子类别</label>
		<div class="layui-input-inline">
			<select name="type">
				<option value=""></option>
				<option value="0">web前端</option>
				<option value="1">java</option>
				<option value="2">php</option>
				<option value="3">服务器运维</option>
				<option value="4">其他</option>
			</select>
		</div>
		<button class="layui-btn" lay-submit lay-filter="search">查找</button>
	</div>
	<!-- <table class="layui-table" lay-data="{height:315, url:'/table/post', page:true, id:'test'}" lay-filter="test">
		<script type="text/html" id="barDemo">
		    <a class="layui-btn layui-btn-primary layui-btn-mini" lay-event="detail">查看</a>
		    <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
		    <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
		</script>
	  <thead>
	    <tr>
	      <th  lay-data="{field:'id', width:300, sort: true}" align="center">ID</th>
	      <th lay-data="{field:'sTitlt', width:200}" align="center">帖子名</th>
	      <th lay-data="{field:'iType', width:180, sort: true}" align="center">类别</th>
	      <th lay-data="{field:'sAuthor',width:160}">作者</th>
	      <th lay-data="{field:'dCreateTime'}" >添加时间</th>
	      <th lay-data="{field:'barDemo'}" >操作</th>
	    </tr>
	  </thead>
	</table> -->


	<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" lay-event="view">查看</a>
		<a class="layui-btn layui-btn-sm layui-btn-radius" lay-event="edit">编辑</a>
		<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" lay-event="del">删除</a>
	</script>
</form>
<div class="layui-container" id="view" style="width: 700px;height: 480px;margin-top: 20px">
   		<div class="layui-form-item">
		    <label class="layui-form-label">帖子标题:</label>
		    <div class="layui-input-inline">
		      <input type="text" name="sTitle" id="sTitle" disabled class="layui-input">
		    </div>
		    <label class="layui-form-label">作者:</label>
		    <div class="layui-input-inline">
		      <input type="text" name="sAuthor" id="sAuthor" disabled class="layui-input">
		    </div>
	  	</div>
	  	<div class="layui-form-item">
		    <label class="layui-form-label">内容:</label>
		    <div class="layui-col-md9">
		      <textarea name="desc" id="sContent" disabled class="layui-textarea"></textarea>
		    </div>
	  	</div>
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
	});

	// 加载依赖form模块
	layui.use('form', function(){
		var form = layui.form;
	  //监听提交依赖模块table
	  form.on('submit(search)', function(data){
	  	// 取值
	  	var title = data.field.title;
	  	var author = data.field.author;
	  	var type = data.field.type;

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

	// 加载table模块
	layui.use('table', function(){
		var table = layui.table;
		// 方法级渲染
		table.render({
			elem: '#table_post'
			,url: '/table/post'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'id', title: 'ID', width:290, sort: true, fixed: true}
			,{field:'sTitlt', title: '帖子标题', width:200, sort: true}
			,{field:'iType', title: '类别', width:150, sort: true,edit:true}
			,{field:'sAuthor', title: '作者', width:150}
			,{field:'dCreateTime', title: '创建时间', width:100}
			,{field:'right', title: '操作', width:177,toolbar:"#barDemo"}
			]]
			,id: 'testReload'
			,page: true
			,height: 600
		});
        // 监听表格复选框
        table.on('checkbox(useruv)', function(obj){
        	console.log(obj)
        });
        //监听工具条
        table.on('tool(useruv)', function(obj){
        	$ = layui.$;
        	var data = obj.data;
        	console.log(data);
        	$("#sTitle").val(data.sTitle);
        	$("#sAuthor").val(data.sAuthor);
        	$("#sContent").text(data.sContent);
        	if(obj.event === 'view'){
        		layer.open({
				  type: 1,
				  title: false,
				  closeBtn: 0,
				  area: ['700px', '500px'],
				  scrollbar: false,
				  shadeClose: true,
				  scrollbar: false,
				  content: $("#view"),
				  success:function(layero){  
					     var mask = $(".layui-layer-shade");  
					     mask.appendTo(layero.parent());  
					     //其中：layero是弹层的DOM对象  
					     // $(layero).addClass("scroll-wrapper");
					} 
				});
        	} else if(obj.event === 'del'){
        		layer.confirm('真的删除行么', function(index){

        			layer.close(index);
        		});
        	} else if(obj.event === 'edit'){
        		layer.alert('编辑行：<br>'+ JSON.stringify(data))
        	}
        });
    });
</script>
@endsection
