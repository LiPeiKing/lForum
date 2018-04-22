@extends('admin.admin_index')
@section('title')
普通用户管理
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
		<label class="layui-form-label">登录名：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sLoginName" placeholder="请输入登录名" id="sLoginName" autocomplete="off">
		</div>
		<label class="layui-form-label">用户名：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sUserName" placeholder="请输入用户名" id="sUserName" autocomplete="off">
		</div>
		<button class="layui-btn" data-type="reload">搜索</button>
	</div>
</div>
<!-- 表格 -->
<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
<script type="text/html" id="barDemo">
	<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" lay-event="view">查看</a>
	<a class="layui-btn layui-btn-sm layui-btn-radius" lay-event="edit">编辑</a>
	<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" lay-event="del">拉黑</a>
</script>

<!-- 查看页面 -->
<div class="layui-container" id="view" style="width: 430px;height: 240px;margin-top: 10px;display: none;">
	<div class="layui-form-item">
		<label class="layui-form-label">用户ID:</label>
		<div class="layui-input-block">
			<input type="text" name="sUserID" id="sUserID" disabled class="layui-input">
		</div>
        <label class="layui-form-label">角色:</label>
        <div class="layui-input-inline">
            <input type="text" name="sRole" id="sRole" disabled class="layui-input">
        </div>
		<label class="layui-form-label">登录名:</label>
		<div class="layui-input-inline">
			<input type="text" name="sLoginName" id="sLoginName" disabled class="layui-input">
		</div>
        <label class="layui-form-label">用户名:</label>
        <div class="layui-input-inline">
            <input type="text" name="sUserName" id="sUserName" disabled class="layui-input">
        </div>
        <label class="layui-form-label">性别:</label>
        <div class="layui-input-inline">
            <input type="text" name="sSex" id="sSex" disabled class="layui-input">
        </div>
        <label class="layui-form-label">创建时间:</label>
        <div class="layui-input-inline">
            <input type="text" name="dCreateTime" id="dCreateTime" disabled class="layui-input">
        </div>
	</div>

<script type="text/javascript">
	// 加载jQuery
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){
	  	$("#user").addClass("layui-nav-itemed");
	  	$("#user dl dd").eq(0).addClass("layui-this");
	  }); 
	});


	// 加载table模块
	layui.use('table', function(){
		var table = layui.table;
		// 方法级渲染
		var tableIns = table.render({
			elem: '#table_post'
			,url: '/common/table'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'sUserID', title: '用户ID', width:300, sort: true, fixed: true}
			,{field:'sLoginName', title: '登录名', width:180}
			,{field:'sUserName', title: '用户名', width:180}
			,{field:'dCreateTime', title: '用户创建时间', width:231}
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
        	$("#view #sUserID").val(data.sUserID);
        	$("#view #sRole").val("普通用户");
        	$("#view #sLoginName").val(data.sLoginName);
            $("#view #sUserName").val(data.sUserName);
            $("#view #sSex").val(data.sSex);
            $("#view #dCreateTime").val(data.dCreateTime);

        	if(obj.event === 'view'){
        		layer.open({
        			type: 1,
        			title: "基础信息查看",
        			closeBtn: 0,
        			area: ['430px', '300px'],
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
        		layer.confirm('您确定拉黑该用户么',{ icon: 3}, function(index){
        			// console.log(data);
        			var sUserID = data.sUserID;
        			console.log(sUserID);
        			$.ajax({
        				type:'POST',
        				url:'/common/del',
        				data:'{"sUserID":"'+sUserID+'"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					console.log(data);
        					if(data == 1){
        						obj.del();
                                tableIns.reload();
        						layer.msg("添加黑名单成功", { icon: 6, time: 2000 });
        					}else{
        						layer.msg("添加黑名单失败！", { icon: 3, time: 2000 });

        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("添加黑名单失败！", { icon: 5, time: 2000 });
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
        		var sLoginName = $('#sLoginName').val();
        		var sUserName = $('#sUserName').val();

        		table.reload('testReload', {
        			where: {
        				sLoginName: sLoginName,
        				sUserName:sUserName
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