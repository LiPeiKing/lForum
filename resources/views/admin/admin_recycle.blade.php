@extends('admin.admin_index')
@section('title')
帖子回收站
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
	    <label class="layui-form-label" style="width: 170px;">标题：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sTitle" id="sTitle" autocomplete="off" placeholder="请输入标题！">
		</div>
		<label class="layui-form-label">作者：</label>
		<div class="layui-input-inline">
			<input class="layui-input" name="sAuthor" id="sAuthor" autocomplete="off" placeholder="请输入作者！">
		</div>
		<button class="layui-btn" data-type="reload"><i class="fa fa-search"></i> 搜索</button>
	</div>
</div>
	<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
	<script type="text/html" id="barDemo">
		<a lay-event="restore" class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"><i class="fa fa-reply fa-fw" style="font-size: 14px !important;"></i>恢复 </a>
	</script>

<script type="text/javascript">
	//主动加载jquery模块
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){
	  	$("#content").addClass("layui-nav-itemed");
	  	$("#content dl dd").eq(2).addClass("layui-this");
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
			,url: '/recycle/table'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'sPostID', title: '帖子ID', width:296, sort: true, fixed: true}
			,{field:'sTitle', title: '帖子标题', width:240}
			// ,{field:'iType', title: '类别', width:150}
			,{field:'sAuthor', title: '作者', width:150}
			,{field:'dCreateTime', title: '创建时间', width:189}
			,{field:'right', title: '帖子状态', width:200,toolbar:"#barDemo"}
			]]
			,id: 'testReload'
			,page: true
			,height: 420
		});
        // 监听表格复选框
        table.on('checkbox(useruv)', function(obj){
        	// console.log(obj)
        });
        //监听工具条
        table.on('tool(useruv)', function(obj){
        	$ = layui.$;
        	var data = obj.data;
			if(obj.event === 'restore'){
        		layer.confirm('您确定恢复这条数据么',{ icon: 3}, function(index){
        			var sPostID = data.sPostID;
        			$.ajax({
        				type:'POST',
        				url:'/recycle/restore',
        				data:'{"sPostID":"'+sPostID+'"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					if(data == 1){
        						obj.del();
        						tableIns.reload();
        						layer.msg("数据恢复成功", { icon: 6, time: 2000 });
        					}else{
        						layer.msg("数据恢复失败！", { icon: 5, time: 2000 });

        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("数据恢复失败！", { icon: 5, time: 2000 });
        					}
        				});

        			layer.close(index);
        		});
        	} 
        });

        // 查询
        var $ = layui.$, active = {
        	reload: function(){
        		var sTitle = $('#sTitle').val();
        		var sAuthor = $('#sAuthor').val();


        		table.reload('testReload', {
        			where: {
        				sTitle: sTitle,
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
