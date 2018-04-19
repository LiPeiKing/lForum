@extends('admin.admin_index')
@section('title')
回复管理
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


<div class="demoTable">
	<div class="layui-form-item">
		<label class="layui-form-label">回帖者：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sAuthor" placeholder="请输入回帖者姓名" id="sAuthor" autocomplete="off">
		</div>
		<label class="layui-form-label">所回帖：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sPostTitle" placeholder="请输入所回帖标题" id="sPostTitle" autocomplete="off">
		</div>
		<button class="layui-btn" data-type="reload">搜索</button>
	</div>
</div>
<!-- 表格 -->
<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
<script type="text/html" id="barDemo">
	<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" lay-event="view">查看</a>
	<a class="layui-btn layui-btn-sm layui-btn-radius" lay-event="edit">编辑</a>
	<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" lay-event="del">删除</a>
</script>

<!-- 查看页面 -->
<div class="layui-container" id="view" style="width: 700px;height: 480px;margin-top: 20px;display: none;">
	<div class="layui-form-item">
		<label class="layui-form-label">帖子标题:</label>
		<div class="layui-input-inline">
			<input type="text" name="sPostTitle" id="sPostTitle" disabled class="layui-input">
		</div>
		<label class="layui-form-label">回复者:</label>
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



<script type="text/javascript">
	// 加载jQuery
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){
	  	$("#content").addClass("layui-nav-itemed");
	  	$("#content dl dd").eq(1).addClass("layui-this");
	  }); 
	});


	// 加载table模块
	layui.use('table', function(){
		var table = layui.table;
		// 方法级渲染
		var tableIns = table.render({
			elem: '#table_post'
			,url: '/reply/table'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'sReplyID', title: 'ID', width:300, sort: true, fixed: true}
			,{field:'sPostTitle', title: '帖子标题', width:280}
			,{field:'sAuthor', title: '回帖者姓名', width:180}
			,{field:'dCreateTime', title: '创建时间', width:130}
			,{field:'right', title: '操作', width:200,toolbar:"#barDemo"}
			]]
			,id: 'testReload'
			,page: true
			,height: 388
		});
        // 监听表格复选框
        table.on('checkbox(useruv)', function(obj){
        	console.log(obj)
        });
        //监听工具条
        table.on('tool(useruv)', function(obj){
        	$ = layui.$;
        	var data = obj.data;
        	// console.log(data);

        	// 绑定显示页面的数据
        	$("#view #sPostTitle").val(data.sPostTitle);
        	$("#view #sAuthor").val(data.sAuthor);
        	$("#view #sContent").text(data.sContent);
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
        			} 
        		});
        	} else if(obj.event === 'del'){
        		layer.confirm('确定删除这条数据么',{ icon: 3}, function(index){
        			// console.log(data);
        			var sReplyID = data.sReplyID;
        			console.log(sReplyID);
        			$.ajax({
        				type:'POST',
        				url:'/reply/del',
        				data:'{"sReplyID":"'+sReplyID+'"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					console.log(data);
        					if(data == 1){
        						obj.del();
                                tableIns.reload();
        						layer.msg("删除成功", { icon: 6, time: 2000 });
        					}else{
        						layer.msg("删除失败！", { icon: 3, time: 2000 });

        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("删除失败！", { icon: 5, time: 2000 });
        					}
        				});

        			layer.close(index);
        		});
        	} else if(obj.event === 'edit'){
        		// layer.alert('编辑行：<br>'+ JSON.stringify(data))
        		layer.alert("由于设计原因，编辑功能暂时为保留功能。",{icon: 4});
        	}
        });

        // 查询
        var $ = layui.$, active = {
        	reload: function(){
        		var sPostTitle = $('#sPostTitle').val();
        		var sAuthor = $('#sAuthor').val();

        		table.reload('testReload', {
        			where: {
        				sPostTitle: sPostTitle,
        				sAuthor:sAuthor
        			}
        		});
        	}
        };

        $('.demoTable .layui-btn').on('click', function(){
        	// alert("11");
        	var type = $(this).data('type');
        	active[type] ? active[type].call(this) : '';
        });

    });


</script>
@endsection