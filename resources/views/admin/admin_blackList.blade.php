@extends('admin.admin_index')
@section('title')
黑名单管理
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
			<input class="layui-input" name="sLoginName" id="sLoginName" autocomplete="off" placeholder="请输入登录名！">
		</div>
		<label class="layui-form-label">用户名：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sUserName" id="sUserName" autocomplete="off" placeholder="请输入用户名！">
		</div>
		<button class="layui-btn" data-type="reload"><i class="fa fa-search"></i> 搜索</button>
	</div>
</div>
	<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" lay-event="restore"><i class="fa fa-key fa-fw" style="font-size: 14px !important;"></i>移除</a>
	</script>

<script type="text/javascript">
	//主动加载jquery模块
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){
	  	$("#user").addClass("layui-nav-itemed");
	  	$("#user dl dd").eq(2).addClass("layui-this");
	  }); 
	});

	// 加载依赖form模块
	layui.use('form', function(){
		var form = layui.form;
	  //监听提交依赖模块table
	  form.on('submit(search)', function(data){
	  	return false;
	  });
	});

	// 加载table模块
	layui.use('table', function(){
		var table = layui.table;
		// 方法级渲染
		var tableIns = table.render({
			elem: '#table_post'
			,url: '/blackList/table'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'sUserID', title: '用户ID', width:284, sort: true, fixed: true}
			,{field:'sLoginName', title: '登录名', width:180}
			,{field:'sUserName', title: '用户名', width:180}
			,{field:'dCreateTime', title: '用户创建时间', width:231}
			,{field:'right', title: '操作', width:200,toolbar:"#barDemo"}
			]]
			,id: 'testReload'
			,page: true
			,height: 420
		});
        // 监听表格复选框
        table.on('checkbox(useruv)', function(obj){
        	console.log(obj)
        });
        //监听工具条
        table.on('tool(useruv)', function(obj){
        	$ = layui.$;
        	var data = obj.data;
			if(obj.event === 'restore'){
        		layer.confirm('您确定将此用户移除黑名单么',{ icon: 3}, function(index){
        			console.log(obj);
        			var sUserID = data.sUserID;
        			$.ajax({
        				type:'POST',
        				url:'/blackList/restore',
        				data:'{"sUserID":"'+sUserID+'"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					if(data == 1){
        						obj.del();
        						tableIns.reload();
        						layer.msg("用户移除黑名单成功", { icon: 6, time: 2000 });
        					}else{
        						layer.msg("用户移除黑名单失败！", { icon: 5, time: 2000 });

        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("用户移除黑名单失败！", { icon: 5, time: 2000 });
        					}
        				});

        			layer.close(index);
        		});
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
