@extends('front.front_userInfo')
@section('cantainer')
<style type="text/css">
	.box {
		background-color: #fff;
		padding: 10px;
		margin: 0 0 20px 0;
		-webkit-box-shadow: 0 0.2em 0 0 #ddd, 0 0 0 1px #ddd;
		box-shadow: 0 0.2em 0 0 #ddd, 0 0 0 1px #ddd;
	}

	.user-basic-info .follow-info, .user-cards .follow-info {
		text-align: center;
		margin-top: 15px;
	}


	.media-left .image img{
		width: 112px;
		border-radius: 50%;
		border: 1px solid #ddd;
		/*padding: 3px;*/
	}
	.user-basic-info .media-heading {
		margin: 10px 0px;
	}
	.user-basic-info .item {
		margin: 6px 0;
	}
	span.timeago {
		color: #aaa;
	}

	.user-basic-info .follow-info a.counter {
		color: #337AB7;
		font-size: 25px;
		display: block;
		text-decoration: none;
	}
	h1 {
	    margin: 1.1em auto 1em;
	    font-size: 28px !important;
	    line-height: 38px !important;
	}
	.article-meta {
	    margin: 20px 0px 32px;
	    color: #aaa;
	    font-size: 13px;
	}
	.content-body{
		padding-left: 20px;
	    font-size: 16px;
	}
	.panel-footer {
	    background-color: #fff;
	    padding: 10px 15px;
	    border-top: none;
	}
	.actions {
	    line-height: 36px;
	}
	.actions a{
		padding: 1px 5px;
	    color: #a9a7a7;
	    text-decoration: none;
	}
	.actions a:hover{
		color: #f46660;
	}
	.note-editor.note-frame {
	    border: 1px solid #dde2e8;
	}

</style>

<!-- 左侧 -->
<div class="col-md-3">
	
	<div class="box">
		<div class="padding-sm user-basic-info">
			<div class="media">
				<div class="media-left">
					<div class="image">
						<a href="">
							<img class="img-circle" src="{{asset('./front/images/caomei.jpg')}}">
						</a>
					</div>
				</div>
				<div class="media-body">
					<h3 class="media-heading">
						{{$users->sUserName or ''}}
					</h3>
					<div class="item">
					</div>
					<div class="item">
						第 {{$userNum->id or ''}} 位会员
					</div>
					<div class="item number">
						注册于 <span class="timeago">{{$time or ''}}</span>
					</div>
					<div class="item number">
						活跃于 <span class="timeago">刚刚</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="follow-info row">
				<div class="col-xs-6">
					<a class="counter" href="/personal/postsList/{{$users->sUserID}}">{{$postNum or ''}}</a>
					<span class="text">讨论</span">
				</div>
				<div class="col-xs-6">
					<a class="counter" href="/personal/linksList/{{$users->sUserID}}">{{$linkNum or ''}}</a>
					<span class="text">链接</span>
				</div>
			</div>
			<hr>
			@if($posts->sUserID == Session::get('sUserID'))
				<a class="btn btn-primary btn-block" id="editInfo" href="/edit/info">
					<i class="glyphicon glyphicon-cog"></i> 编辑个人资料
				</a>
			@endif
			
		</div>
	</div>
</div>

<!-- 右侧 -->
<div class="col-md-9">
	<!-- 查看部分 -->
	<div class="panel">
        <div class="panel-body">
            <h1 class="text-center">
                {{$posts->sTitle}}
            </h1>
            <!-- 标题下的图标 -->
            <div class="article-meta text-center">
            	<!-- 发表时间 -->
                <i class="glyphicon glyphicon-time"></i> <span title="" class="timeago">{{$posts->dCreateTime or ''}}</span> &nbsp;&nbsp;
                <!-- 点赞 -->
                <i class="glyphicon glyphicon-thumbs-up"></i> <span>{{$posts->iPraise or '0'}}</span>
            </div>
            <div class="content-body">
			    <div class="markdown-body topic-content-big-font" id="emojify">


			    </div>
		    </div>                        
			<div class="panel-footer">
				<div class="actions" id="user">
		    		<a id="postDelete" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="删除">
		        		<i class="glyphicon glyphicon-trash"></i>
					</a>
		            <a id="postEdit" href="" data-toggle="tooltip" data-placement="top" title="编辑">
		            	<i class="glyphicon glyphicon-edit"></i>
		          	</a>      
    			</div>
			</div>



		<input type="hidden" id="sPostID" value="{{$posts->sPostID}}">
		<input type="hidden" id="iType" value="{{$posts->iType}}">
		<input type="hidden" id="sLinks" value="{{$posts->sLinks}}">
		<input type="hidden" id="hidsAuthorID" value="{{$posts->sUserID}}">
		<input type="hidden" id="hidsLoginID" value="{{Session::get('sUserID')}}">
		<input type="hidden" id="hidisPraise" value="{{$praise}}">
	    </div>  
  	</div>

  	<!-- 点赞部分 -->
  	<div class="votes-container panel panel-default padding-md">
	    <div class="panel-body vote-box text-center">
	        <div class="btn-group">
	            <a class="btn btn-primary" id="praise" href="javascript:void(0);" data-toggle="tooltip" data-placement="top"  title="点击两次就会取消呦！">
	                <i class="glyphicon glyphicon-thumbs-up"></i>
	                点赞
	            </a>
	        </div>     
	    </div>
  	</div>

  	<!-- 回复显示部分 -->
	<div class=" panel panel-default " id="replies">

	    <div class="panel-heading" style="background-color: #ffffff !important;">
	        <div class="total">回复数量: <b>{{$replayCount or '0'}}</b> </div>
	    </div>

	    <div class="panel-body">
	    	@if(empty($replys))
	        	<div id="replies-empty-block" class="empty-block">暂无评论~~</div>
				
	    	@else
				<ul class="list-group row">
					@foreach($replys as $reply)

						<div class="infos" style="margin-left: 30px;">
					      	<div class="media-heading" >
					      		<i class="glyphicon glyphicon-user" style="padding-right: 5px;color: #5f5252;"></i>
								<span class="timeago">{{$reply->sAuthor}}</span>&nbsp;
								<i class="glyphicon glyphicon-calendar" style="padding-right: 5px;color: #5f5252;"></i>
	            				<span class="timeago" title="{{$reply->dCreateTime}}"><?php 
	            					$now_time = date("Y-m-d H:i:s", time());
							        $now_time = strtotime($now_time);  
							        $show_time = strtotime($reply->dCreateTime);  
							        $dur = $now_time - $show_time;
							        $time="";
							        if ($dur < 0) {  
							            $time = $reply->dCreateTime;  
							        } else {  
							            if ($dur < 60) {  
							                $time = $dur . '秒前';  
							            } else {  
							                if ($dur < 3600) {  
							                    $time = floor($dur / 60) . '分钟前';  
							                } else {  
							                    if ($dur < 86400) {  
							                        $time = floor($dur / 3600) . '小时前';  
							                    } else {  
							                            $time = floor($dur/(60*60*24)) . '天前';  
							                         
							                    }  
							                }  
							            }  
							        } 
							        echo $time;   
	            				 ?></span>
					  		</div>
					  		<div id="replayContent" class="media-heading" style="padding-left: 25px;">
								{!!html_entity_decode($reply->sContent)!!}
						    </div>

					    </div>
					@endforeach
				</ul>
	    	@endif
	        
	    </div>

  	</div>

  	<!-- 回复添加 -->
  	


	
	
	<div class="panel panel-default">
		<div class="alert alert-dismissable alert-info" style="margin: 15px">
	        <i class="fa fa-info" aria-hidden="true"></i> &nbsp;&nbsp;请勿发布不友善或者负能量的内容。与人为善，比聪明更重要！
	    </div>
	    <div class="panel-body">

			<div id="summernote" class="col-sm-12"></div>
			<div class="text-center">
	            <button class="btn btn-primary" id="replay" style="width: 80px">
	                <i class="glyphicon glyphicon-leaf"></i> 回复
	            </button>
	        </div>
	    </div>

	</div>
</div>




<input type="hidden" id="content" value="{{$posts->sContent}}">

<script type="text/javascript">
	$(function () {



		// 初始化编辑器
		$('#summernote').summernote({
			lang: 'zh-CN',
			placeholder: '请输入内容！',
			tabsize: 2,
	        // height: 350,
	        minHeight: 350,             // set minimum height of editor
	        maxHeight: null ,
	        toolbar: [
			    ['style', ['style']],
			    ['font', ['bold', 'italic', 'underline', 'clear']],
			    ['fontname', ['fontname']],
			    ['color', ['color']],
			    ['para', ['ul', 'ol', 'paragraph']],
			    // ['height', ['height']],
			    ['table', ['table']],
			    ['insert', ['link', 'hr']],
			    ['view', ['fullscreen', 'codeview']],
			    ['help', ['help']]
			  ]
	    });


		// 处理点赞按钮加载样式
		var isPraise = $("#hidisPraise").val();
		if(isPraise == '1'){
			$("#praise").attr("class","btn btn-success");
			$("#praise").text("已点赞");
		}


		// 处理所有者和其余人查看帖子显示效果
		var sAuthorID = $("#hidsAuthorID").val();
		var sLoginID = $("#hidsLoginID").val();
		if(sLoginID.length == 0){
			$("#user").hide();
			$("#guest").hide();
			$("#myInfo").hide();
		}else if(sLoginID == sAuthorID){
			$("#user").show();
			$("#guest").hide();
		}else{
			$("#user").hide();
			$("#guest").show();
			$("#myInfo").hide();

		}


		// 处理链接显示效果
		var iType = $("#iType").val();
		var sLinks = $("#sLinks").val();

		// 处理 编辑 帖子和链接跳转的编辑页面不同
		// /topics/create/{{$posts->sPostID}} -- 帖子
		// /links/share/{{$posts->sPostID}} --- 链接

		var postHref = "/topics/create/{{$posts->sPostID}}";
		var linkHref = "/links/share/{{$posts->sPostID}}";


		if(iType =="2"){
			var sl = '<a class="glyphicon glyphicon-link" target="_blank" href="'+sLinks+'">链接</a>';
	  		$("#emojify").append(sl);
	  		$("#postEdit").attr("href",linkHref);
		}else{
	  		$("#postEdit").attr("href",postHref);
			
		}

		// 模态框显示提示信息
	  	$('a[data-toggle="tooltip"]').tooltip();

	  	// 获得内容
	  	var content = $("#content").val();
	  	// 将文本内容写入页面
	  	$("#emojify").append(content);


	  	// 删除帖子
	  	$("#postDelete").on('click',function(){
	  		var sPostID = $("#sPostID").val();	
			console.log(sPostID);
	  		$.confirm({
			    title: '警告',
			    content: '<div style="text-align:center">您确定删除么！</div>',
			    buttons: {
			        确定:{
			            btnClass: 'btn-blue',
			            action:function(){
			            	$.ajax({
								type: 'POST',
								url: '/topics/delete',
								data: '{"sPostID":"'+sPostID+'"}',
							    contentType: "application/json",
								headers: {
									'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
								},
								success: function(data){
									console.log(data);
									if(data == 1){
										$.dialog({
											title:'',
											content: '<div style="text-align:center">删除成功了呦！</div>',
										});
										if(iType == '2'){
											setTimeout("location.href='/personal/center'",1500);
										}else{
											setTimeout("location.href='/personal/center'",1500);
										}
									}else if(data == 0){
										$.dialog({
											title:'',
											content: '<div style="text-align:center">系统原因删除失败！</div>',
										});
									}else{
										$.dialog({
											title:'',
											content: '<div style="text-align:center">删除失败了呦！</div>',
										});
									}
								},
								error: function(xhr, type){
									$.dialog({
										title:'',
										content: '<div style="text-align:center">系统原因删除失败！</div>',
									});

								}

							});

			            }
			        	


			        },
			        取消: function () {
			            
			        }
			    }
			});
	  		
	  	});

	  	// 点赞
	  	$("#praise").on('click',function(){
	  		var sPostID = $("#sPostID").val();
	  		var sUserID = $("#hidsLoginID").val();
	  		
	  		$.ajax({
				type: 'POST',
				url: '/topics/praise',
				data: '{"sPostID":"'+sPostID+'","sUserID":"'+sUserID+'"}',
			    contentType: "application/json",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
				},
				success: function(data){
					console.log(data);
					if(data == 1){
						location.reload();
					}
				},
				error: function(xhr, type){
					$.dialog({
						title:'',
						content: '<div style="text-align:center">系统原因点赞失败！</div>',
					});

				}
			});
	  	});


	  	// 回复

	  	$("#replay").on('click',function(){
	  		var sPostID = $("#sPostID").val();
	  		var sLoginID = $("#hidsLoginID").val(); 
	  		var sPostAuthorID = $("#hidsAuthorID").val();
	  		var sContent = $('#summernote').summernote('code');
	  		if(sContent == "<p><br></p>"){
	  			$.dialog({
					title:'',
					content: '<div style="text-align:center">请注重自身修养！</div>',
				});
	  		}else{
	  			console.log(sContent);
	  			var replays = {
		            sPostID:sPostID,
		            sLoginID:sLoginID,
		            sPostAuthorID:sPostAuthorID,
		            sContent:sContent
		        };

		  		$.ajax({
					type: 'POST',
					url: '/topics/replay',
					data: replays,
				    dataType:'text',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
					},
					success: function(data){
						console.log(data);
						if(data == 1){
							location.reload();
						}
					},
					error: function(xhr, type){
						$.dialog({
							title:'',
							content: '<div style="text-align:center">系统原因点赞失败！</div>',
						});

					}
				});

	  		}

	  	

	  	});



	});
</script>

@endsection

@section('script')
@endsection