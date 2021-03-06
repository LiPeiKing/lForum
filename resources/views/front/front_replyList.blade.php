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
				<div class="col-xs-4">
					<a class="counter" href="/personal/postsList/{{$users->sUserID}}">{{$postNum}}</a>
					<span class="text">讨论</span">
				</div>
				<div class="col-xs-4">
					<a class="counter" href="/personal/linksList/{{$users->sUserID}}">{{$linkNum}}</a>
					<span class="text">链接</span>
				</div>
				
				<div class="col-xs-4">
					<a class="counter" href="/personal/replysList/{{$users->sUserID}}">{{$replyNum}}</a>
					<span class="text">回复</span>
				</div>
			
				
			</div>
			<hr>
			@if($users->sUserID == Session::get('sUserID'))
				<a class="btn btn-primary btn-block" id="editInfo" href="/edit/info">
					<i class="glyphicon glyphicon-cog"></i> 编辑个人资料
				</a>
			@endif
		</div>
	</div>
</div>

<!-- 右侧 -->
<div class="col-md-9">
	<!-- 回复 -->
	<div class="panel panel-default">
		<div class="panel-heading text-center" style="background-color: #ffffff !important;">
			<i class="fa fa-comments-o" aria-hidden="true"></i> 最近的回复
		</div>

		<div class="panel-body">
			@if($replyNum == 0)
				<div class="empty-block">还没有任何回复呦~~</div>
			@else 
				<ul class="list-group">
					@foreach($replys as $reply)
					<li class="list-group-item"> 对
						<a href="/personal/reply/{{$reply->sReplyID}}" title="{{$reply->sPostTitle}}的回复" class="">
							{{$reply->sPostTitle}}
						</a>的回复
						<span class="meta pull-right">
				            <i class="glyphicon glyphicon-tag"></i>
					        <span>回复</span>
					        <i class="glyphicon glyphicon-calendar"></i>

					        <span class="timeago">{{$reply->dCreateTime}}</span>
					    </span>
					</li>
					@endforeach
				</ul>
			@endif
		</div>
	</div>
</div>

@endsection