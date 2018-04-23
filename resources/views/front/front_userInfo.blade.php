@extends('front.front_index')

@section('nav')
<style type="text/css">
#head{
	width: 30px;
	margin-top: 1px;
}
</style>
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
			<a id="login-out" class="button" href="/front/logout">
				<i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;&nbsp;&nbsp;退出登陆
			</a>
		</li>
	</ul>
</li>
@endsection

@section('side')
<div class="panel panel-default">
	<div class="panel-body text-center">
		<a style="margin: 8px;" class="btn btn-default" href="https://laravel-china.org/topics/create">
            <i class="fa fa-comment text-md"></i> 发起讨论
        </a>
        <a style="margin: 8px;" class="btn btn-default" href="https://laravel-china.org/links/share">
            <i class="fa fa-link text-md"></i> 分享链接
        </a>
	</div>
</div>
@endsection
