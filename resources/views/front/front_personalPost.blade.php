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
                <i class="glyphicon glyphicon-time"></i> <span title="3小时前" class="timeago">3小时前</span> &nbsp;&nbsp;
                <!-- 点赞 -->
                <i class="glyphicon glyphicon-thumbs-up"></i> <span>1</span>
            </div>
            <div class="content-body">
			    <div class="markdown-body topic-content-big-font" id="emojify">

			    </div>
		    </div>                        

			<div class="panel-footer">
				<div class="actions">
		    		<a id="postDelete" href="javascript:void(0);" data-url="" data-toggle="tooltip" data-placement="top" title="删除">
		        		<i class="glyphicon glyphicon-trash"></i>
					</a>
		            <a id="topic-edit-button" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="编辑">
		            	<i class="glyphicon glyphicon-edit"></i>
		          	</a>      
    			</div>
			</div>






            
	    </div>  
  	</div>
</div>


<input type="hidden" id="content" value="{{$posts->sContent}}">
<script type="text/javascript">
	$(function () {
	  $('a[data-toggle="tooltip"]').tooltip();

	  // 将
	  var content = $("#content").val();
	  $("#emojify").append(content);


	});
</script>

@endsection