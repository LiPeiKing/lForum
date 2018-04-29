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
.empty-block {
	text-align: center;
	line-height: 60px;
	margin: 10px;
	color: #ccc;
}
.list-group {
	margin-bottom: 0px;
	padding-left: 0;
}



.list-group .list-group-item {
	/*margin-bottom: 20px;*/
	padding: 10px 24px;
	border: none;
	margin-bottom: 0px;
	border-bottom: 1px solid #f2f2f2 !important;
}
.list-group .list-group-item span.meta {
    color: #d0d0d0;
}
.list-group .list-group-item span.meta a{
    color: #d0d0d0;
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
						第 {{$userNum->id}} 位会员
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
					<a class="counter" href="/personal/postsList/{{$users->sUserID}}">{{$postNum}}</a>
					<span class="text">讨论</span">
				</div>
				<div class="col-xs-6">
					<a class="counter" href="/personal/linksList/{{$users->sUserID}}">{{$linkNum}}</a>
					<span class="text">链接</span>
				</div>
			</div>
			<hr>
			<a class="btn btn-primary btn-block" id="editInfo" href="/edit/info">
				<i class="glyphicon glyphicon-cog"></i> 编辑个人资料
			</a>
		</div>
	</div>
</div>

<!-- 右侧 -->
<div class="col-md-9">
	<div class="panel panel-default">
		<div class="panel-heading text-center" style="background-color: #ffffff !important;">
			<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> 最近发起的讨论
		</div>
		<div class="panel-body">
			@if($postNum == 0)
				<div class="empty-block">没有任何数据~~</div>
			@else
				<ul class="list-group">
					@foreach($posts as $post)
					<li class="list-group-item"> 
						<a href="/personal/post/{{$post->sPostID}}" title="{{$post->sTitle}}" class="">
							{{$post->sTitle}}
						</a>
						<span class="meta pull-right">
				            <i class="glyphicon glyphicon-tag"></i>
					        <span> {{$post->sName}}&nbsp;</span>
					        <i class="glyphicon glyphicon-thumbs-up"></i>
					        <span> {{$post->iPraise or '0'}} &nbsp;</span>
					        <i class="glyphicon glyphicon-calendar"></i>
					        <span class="timeago">{{$post->dCreateTime}}</span>
					    </span>
					</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading text-center" style="background-color: #ffffff !important;">
			<i class="glyphicon glyphicon-share" aria-hidden="true"></i> 最近分享的链接
		</div>

		<div class="panel-body">
			@if($linkNum == 0)
				<div class="empty-block">没有任何数据~~</div>
			@else 
				<ul class="list-group">
					@foreach($links as $link)
					<li class="list-group-item"> 
						<a href="/personal/link/{{$link->sPostID}}" title="{{$link->sTitle}}" class="">
							{{$link->sTitle}}
						</a>
						<span class="meta pull-right">
				            <i class="glyphicon glyphicon-tag"></i>
					        <span>链接</span>
					        <i class="glyphicon glyphicon-thumbs-up"></i>
					        <span> {{$post->iPraise or '0'}} &nbsp;</span>
					        <i class="glyphicon glyphicon-calendar"></i>

					        <span class="timeago">{{$post->dCreateTime}}</span>
					    </span>
					</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>
</div>
<input type="hidden" id="hidsAuthor" value="{{$post->sUserID or ''}}}">
<input type="hidden" id="hidsUserID" value="{{Session::get('sUserID')}}}">

<script type="text/javascript">
	var sAuthorID = $("#hidsAuthor").val();
	var sUserID = $("#hidsUserID").val();
	if(sAuthorID == sUserID){
		$("#editInfo").show();
	}else{
		$("#editInfo").hide();
	}
</script>
@endsection