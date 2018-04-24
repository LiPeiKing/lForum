@extends('front.front_index')

@section('nav')
<style type="text/css">
#head{
	width: 30px;
	margin-top: 1px;
}
</style>
<li class="text-center">
	<a href="javascript:;" type="button">首页</a>
</li>
<li class="text-center">
	<a href="#" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dLabel">
		<img class="img-rounded" id="head" alt="liking" src="{{asset('./front/images/caomei.jpg')}}">
		{{Session::get('sLoginName')}}
		<span class="caret"></span>
	</a>
	<ul class="dropdown-menu" aria-labelledby="dLabel">
		<li class="text-center">
			<a class="button" href="/personal/center">
				<i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;个人中心
			</a>
		</li>
		<li class="text-center">
			<a class="button" href="/edit/info">
				<i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;&nbsp;&nbsp;编辑资料
			</a>
		</li>
		<li class="text-center">
			<a id="logout" class="button" href="javascript:;">
				<i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;&nbsp;&nbsp;退出登陆
			</a>
		</li>
	</ul>
</li>
@endsection

@section('side')
<div class="panel panel-default">
	<div class="panel-body text-center">
		<a style="margin: 4px;" class="btn btn-default" href="/topics/create">
            <i class="glyphicon glyphicon-pencil"></i> 发起讨论
        </a>
        <a style="margin: 4px;" class="btn btn-default" href="/links/share">
            <i class="glyphicon glyphicon-share"></i> 分享链接
        </a>
        
	</div>
</div>



@endsection

@section('script')
	
<script>
	$(function(){
		$("#logout").on('click',function(){
			$.confirm({
			    title: '提示：',
			    content:'您确定退出登录么？',
			    // offsetBottom:'10px',
			    buttons: {
			        确定: function () {
			            location.href = "/front/logout";
			        },
			        取消: function () {
			        }
			    }
			});
		})
	});
</script>
	
@endsection
