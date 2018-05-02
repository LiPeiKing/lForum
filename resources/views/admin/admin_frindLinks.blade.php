@extends('admin.admin_index')
@section('title')
友情链接
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
		.view input{
			border-width: 0;
		}
		.labelw{
			width:90px !important;
		}
		.inputw{
			width:500px !important;
		}
		#view{
			width: 650px;height: 330px;padding-top: 10px;display: none;
		}
		#edit{
			width: 650px;height: 330px;padding-top: 10px;display: none;
		}
		#edit #sLinkID{
			border-width: 0;
		}

	</style>


	<div class="demoTable">
		<form class="layui-form">
			<div class="layui-form-item">
			    <label class="layui-form-label">链接地址：</label>
				<div class="layui-input-inline">
					<input class="layui-input" name="sLinkAddress" id="sLinkAddress" lay-verify="url" autocomplete="off" placeholder="请输入链接地址！">
				</div>
				<label class="layui-form-label">链接名称：</label>
				<div class="layui-input-inline">
					<input class="layui-input" name="sLinkName" id="sLinkName" lay-verify="required" autocomplete="off" placeholder="请输入链接名称！">
				</div>
				<label class="layui-form-label" style="padding-left:10px;width: 100px; ">链接图片地址：</label>
				<div class="layui-input-inline">
					<input class="layui-input" name="sLinkImg" id="sLinkImg" lay-verify="url" autocomplete="off" placeholder="请输入链接图片地址！">
				</div>
				<button class="layui-btn" id="editAdmin" lay-submit lay-filter="editAdmin" data-type="reload"><i class="fa fa-plus"></i> 新增</button>
			</div>
		</form>
	</div>

	<!-- 查看页面 -->
	<div class="layui-container view" id="view">
		<div class="layui-form-item">
			<label class="layui-form-label labelw">链接ID:</label>
			<div class="layui-input-inline ">
				<input type="text" name="sLinkID" id="sLinkID" disabled class="layui-input inputw">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label labelw">链接名称:</label>
	        <div class="layui-input-inline">
	            <input type="text" name="sLinkName" id="sLinkName" disabled class="layui-input inputw">
	        </div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label labelw">添加者:</label>
	        <div class="layui-input-inline">
	            <input type="text" name="sCreateAdmin" id="sCreateAdmin" disabled class="layui-input inputw">
	        </div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label labelw">链接地址:</label>
			<div class="layui-input-inline">
				<input type="text" name="sLinkAddress" id="sLinkAddress" disabled class="layui-input inputw">
			</div>
		</div>
		<div class="layui-form-item">
        	<label class="layui-form-label labelw">链接图片地址:</label>
	        <div class="layui-input-inline ">
	            <input type="text" name="sLinkImg" id="sLinkImg" disabled class="layui-input inputw">
	        </div>
		</div>
		<div class="layui-form-item">
        	<label class="layui-form-label labelw">创建时间:</label>
	        <div class="layui-input-inline">
	            <input type="text" name="dCreateTime" id="dCreateTime" disabled class="layui-input inputw">
	        </div>
		</div>
	</div>

	<!-- 修改页面 -->
	<div class="layui-container edit" id="edit">
		<form>
			<div class="layui-form-item">
				<label class="layui-form-label labelw">链接ID:</label>
				<div class="layui-input-inline ">
					<input type="text" name="sLinkID" id="sLinkID" disabled class="layui-input inputw">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label labelw">链接名称:</label>
		        <div class="layui-input-inline">
		            <input type="text" name="sLinkName" id="sLinkName" class="layui-input inputw">
		        </div>
			</div>	
			<div class="layui-form-item">
				<label class="layui-form-label labelw">链接地址:</label>
				<div class="layui-input-inline">
					<input type="text" name="sLinkAddress" id="sLinkAddress" class="layui-input inputw">
				</div>
			</div>
			<div class="layui-form-item">
	        	<label class="layui-form-label labelw">链接图片地址:</label>
		        <div class="layui-input-inline ">
		            <input type="text" name="sLinkImg" id="sLinkImg" class="layui-input inputw">
		        </div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block" style="margin-left: 120px;">
					<button class="layui-btn" id="linkEdit" lay-submit lay-filter="formDemo"><i class="fa fa-pencil fa-fw"></i>修改</button>
				</div>
	        	
			</div>
		</form>
		
	</div>

	<table class="layui-hide" id="table_post" lay-filter="useruv"></table>
	<script type="text/html" id="barDemo">
		<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" lay-event="view"><i class="fa fa-eye fa-fw" style="font-size: 14px !important;"></i>查看</a>
		<a class="layui-btn layui-btn-sm layui-btn-radius" lay-event="edit"><i class="fa fa-edit fa-fw" style="font-size: 14px !important;"></i>编辑</a>
		<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" lay-event="del"><i class="fa fa-trash-o fa-fw" style="font-size: 14px !important;"></i>删除</a>
	</script>
	<script type="text/javascript">
	//主动加载jquery模块
	layui.use(['jquery'], function(){ 
	  // 重点处 转让 $ 使用
	  var $ = layui.$;
	  
	  //后面就跟你平时使用jQuery一样
	  $(function(){

	  	$("#extend").addClass("layui-nav-itemed");
	  	$("#extend dl dd").eq(0).addClass("layui-this");
	  }); 
	});

	// 链接修改
	$("#linkEdit").on('click',function(){
		var sLinkID = $("#edit #sLinkID").val();
		var sLinkName = $("#edit #sLinkName").val();
		var sLinkAddress = $("#edit #sLinkAddress").val();
		var sLinkImg = $("#edit #sLinkImg").val();
		// alert(sLinkAddress);
		$.ajax({
			type:'POST',
			url:'/link/edit',
			data:'{"sLinkID":"'+sLinkID+'","sLinkName":"'+sLinkName+'","sLinkAddress":"'+sLinkAddress+'","sLinkImg":"'+sLinkImg+'"}',
			contentType:"application/json",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
			},
			success:function(data){
				console.log(data);
				if(data == 1){

					layer.msg("修改成功", { icon: 6, time: 1500 });
					setTimeout("location.reload()",1000);
				}else{
					layer.msg("修改失败失败！", { icon: 5, time: 1500 });

				}
			},
			error:function(data){
					// console.log(data);
					layer.msg("因系统原因删除失败！", { icon: 5, time: 2000 });
				}
		});


		return false;
	});

	layui.use('form', function(){
      var form = layui.form;
      var $ = layui.$;
      // 监听提交
      form.on('submit(editAdmin)',function(data){
        // console.log(data);
        var sLinkAddress = data.field['sLinkAddress'];
        var sLinkImg = data.field['sLinkImg'];
        var sLinkName = data.field['sLinkName'];
        console.log(sLinkAddress);
        $.ajax({
            type:'post',
            url:'/link/save',
            data:'{"sLinkAddress":"'+sLinkAddress+'","sLinkImg":"'+sLinkImg+'","sLinkName":"'+sLinkName+'"}',
            contentType:"application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
            },
            success:function(data){
                console.log(data);
                if(data == 1){
                    layer.msg("链接添加成功！", { icon: 6, time: 1500 });
                    setTimeout("location.reload()",1000);
                }else if(data == 0){
                    // console.log(data);
                    layer.msg("链接添加失败！", { icon: 5, time: 1500 });
                }
            },
            error:function(data){
                // console.log(data);
                layer.msg("因系统原因链接添加失败！！", { icon: 3, time: 1500 });
            }
        });
        return false;
      });
    });


	// 加载table模块
	layui.use('table', function(){
		var table = layui.table;
		// 方法级渲染
		var tableIns = table.render({
			elem: '#table_post'
			,url: '/link/table'
			,cols: [[
			{checkbox: true, fixed: true}
			,{field:'sLinkID', title: '链接ID', width:251, sort: true, fixed: true}
			,{field:'sLinkName', title: '链接名称', width:240}
			,{field:'sUserName', title: '添加者', width:150}
			,{field:'dCreateTime', title: '添加时间', width:189}
			,{field:'right', title: '操作', width:244,toolbar:"#barDemo"}
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
        	console.log(data);
        	// 绑定显示页面的数据
        	$("#view #sLinkID").val(data.sLinkID);
        	$("#view #sLinkName").val(data.sLinkName);
        	$("#view #sLinkAddress").val(data.sLinkAddress);
        	$("#view #sLinkImg").val(data.sLinkImg);
        	$("#view #dCreateTime").val(data.dCreateTime);
        	$("#view #sCreateAdmin").val(data.sUserName);
        	if(obj.event === 'view'){
        		layer.open({
        			type: 1,
        			title: "链接信息查看",
        			closeBtn: 0,
        			area: ['650px', '380px'],
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
        			console.log(data.sLinkID);
        			var sLinkID = data.sLinkID;
        			$.ajax({
        				type:'POST',
        				url:'/link/del',
        				data:'{"sLinkID":"'+sLinkID+'"}',
        				contentType:"application/json",
        				headers: {
        					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
        				},
        				success:function(data){
        					console.log(data);
        					if(data == 1){
        						obj.del();
        						tableIns.reload();
        						layer.msg("删除成功了呦！", { icon: 6, time: 1500 });
        					}else{
        						layer.msg("删除失败了呦！", { icon: 5, time: 1500 });

        					}
        				},
        				error:function(data){
        						// console.log(data);
        						layer.msg("因为系统原因删除失败！", { icon: 5, time: 2000 });
        					}
        			});

        			layer.close(index);
        		});
        	} else if(obj.event === 'edit'){
        		$("#edit #sLinkID").val(data.sLinkID);
	        	$("#edit #sLinkName").val(data.sLinkName);
	        	$("#edit #sLinkAddress").val(data.sLinkAddress);
	        	$("#edit #sLinkImg").val(data.sLinkImg);
	        	$("#edit #dCreateTime").val(data.dCreateTime);
	        	$("#edit #sCreateAdmin").val(data.sUserName);
        		layer.open({
        			type: 1,
        			title: "链接信息修改",
        			closeBtn: 0,
        			area: ['650px', '380px'],
        			scrollbar: false,
        			shadeClose: true,
        			scrollbar: false,
        			content: $("#edit"),
        			success:function(layero){  
        				var mask = $(".layui-layer-shade");  
        				mask.appendTo(layero.parent()); 
        			} 
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