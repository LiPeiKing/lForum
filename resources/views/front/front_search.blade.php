@extends('front.front_index')

@section('cantainer')
<style type="text/css">
	.search-results {
	    padding: 20px;
	    line-height: 25px;
	}
	.panel .panel-heading {
	    border-bottom: 1px solid #eeeeee;
	    background-color: #fff;
	}
	.search-results .panel-heading h3 {
	    color: #696969;
	    font-size: 15px;
	    margin-bottom: 12px;
	}
	.panel-body{
		padding-top: 11px;
		padding-left: 24px;
	}
	.result{
	    margin-bottom: -6px;
	}
	.panel-footer{
		background-color: #fcfcfc;
		border:none;
		padding: 0px;
		padding-left: 15px;
	}
	.info{
	    font-size: 13px;
	    padding-top: 10px;
	}

</style>

<div class="panel panel-default search-results">
	
	<div class="panel-heading">
	    <h3 class="panel-title ">
            <i class="fa fa-search"></i> 关于 “<span class="highlight">{{$keyWords}}</span>” 的搜索结果, 共 {{$counts}} 条
	    </h3>
	</div>


	<div class="panel-body">
		@if(!empty($users))
			@foreach($users as $user)
				<div class="result">
			      	<div class="info">
			      		<span class="glyphicon glyphicon-user" style="color: #5f5252;padding-right: 5px;"></span>
				        <a href="/view/personal/{{$user->sUserID}}">
				            <span class="highlight">@if(empty($user->sUserName)){{$user->sLoginName}}@else{{$user->sUserName}}@endif</span> 	
				        </a>

				        <span title="简介">@if(!empty($user->sIntroduction))| {{$user->sIntroduction}}@endif</span>
			      	</div>
			      	<div class="info number">
			      		<span title="会员">
			        		第 {{$user->id}} 位会员
			      		</span>
			          	
			        	<span title="注册日期">
			            	&nbsp;⋅&nbsp; {{$user->dCreateTime}}
			        	</span>
			        	<span title="性别">
			        		&nbsp;⋅&nbsp; {{$user->sSex}}
			        	</span>
			        	<span title="所在城市">
			        		&nbsp;⋅&nbsp; {{$user->sCity}}
			        	</span>
			      	</div>
				</div>
				<hr>
			@endforeach

		@elseif(!empty($posts))
			@foreach($posts as $post)
				
				<div class="result">
			      	<div class="number">
			      		<span class="glyphicon glyphicon-list-alt" style="color: #5f5252;padding-right: 5px;"></span>
				        <a href="/personal/post/{{$post->sPostID}}">
				            <span class="highlight">@if(empty($post->sTitle)){{$post->sUserName}}@else{{$post->sTitle}}@endif</span> 	
				        </a>
			      	</div>
			      	<div class="info">
			          	<span title="作者">
			        		{{$post->sAuthor}}
			        	</span>
			        	<span title="创建时间">
			            	&nbsp;⋅&nbsp; {{$post->dCreateTime}}
			        	</span>
			        	
			        	<span title="点赞">
			        		&nbsp;⋅&nbsp; <span class="glyphicon glyphicon-thumbs-up"></span> {{$post->iPraise}}
			        	</span>
			        	<span title="回复">
			        		&nbsp;⋅&nbsp; 
							<!-- <span class="glyphicon glyphicon-comment"></span> -->
							<i class="fa fa-comments-o" aria-hidden="true"></i>
			        		{{$post->iReplys}}
			        	</span>
			      	</div>
				</div>
				<hr>

			@endforeach
		@endif
		

	</div>

	


	<div class="panel-footer">
      	
  </div>

</div>

@endsection