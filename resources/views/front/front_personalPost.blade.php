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
						{{$users->sUserName}}
					</h3>
					<div class="item">
					</div>
					<div class="item">
						第 {{$users->iNum}} 位会员
					</div>
					<div class="item number">
						注册于 <span class="timeago">{{$time}}</span>
					</div>
					<div class="item number">
						活跃于 <span class="timeago">刚刚</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="follow-info row">
				<div class="col-xs-6">
					<a class="counter" href="/personal/postsList">{{$postNum}}</a>
					<span class="text">讨论</span">
				</div>
				<div class="col-xs-6">
					<a class="counter" href="/personal/linksList">{{$linkNum}}</a>
					<span class="text">链接</span>
				</div>
			</div>
			<hr>
			<a class="btn btn-primary btn-block" href="/edit/info">
				<i class="glyphicon glyphicon-cog"></i> 编辑个人资料
			</a>
		</div>
	</div>
</div>

<!-- 右侧 -->
<div class="col-md-9">
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
				<div class="actions">
		    		<a id="postDelete" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="删除">
		        		<i class="glyphicon glyphicon-trash"></i>
					</a>
		            <a id="topic-edit-button" href="/topics/create/{{$posts->sPostID}}" data-toggle="tooltip" data-placement="top" title="编辑">
		            	<i class="glyphicon glyphicon-edit"></i>
		          	</a>      
    			</div>
			</div>



		<input type="hidden" id="sPostID" value="{{$posts->sPostID}}">
		<input type="hidden" id="iType" value="{{$posts->iType}}">
		<input type="hidden" id="sLinks" value="{{$posts->sLinks}}">

	    </div>  
  	</div>
</div>
<a href=""></a>

<input type="hidden" id="content" value="{{$posts->sContent}}">
<script type="text/javascript">
	$(function () {

		// 处理链接显示效果
		var iType = $("#iType").val();
		var sLinks = $("#sLinks").val();
		if(iType =="2"){
			var sl = '<a class="glyphicon glyphicon-link" target="_blank" href="'+sLinks+'">链接</a>';
	  		$("#emojify").append(sl);

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
											setTimeout("location.href='/personal/linksList'",1500);
										}else{
											setTimeout("location.href='/personal/postsList'",1500);
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



	});
</script>

@endsection

@section('script')
@endsection