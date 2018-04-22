<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1"/> 
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="{{asset('./admin/css/normalize.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('./admin/css/demo.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('./admin/layui/css/layui.css')}}">
	<!--必要样式-->
	<link rel="stylesheet" type="text/css" href="{{asset('./admin/css/component.css')}}" />
	<link rel="stylesheet" href="{{asset('./admin/css/user.css')}}"/>
	<link rel="stylesheet" href="{{asset('/admin/layui/css/layui.css')}}">
<!--[if IE]>
<script src="js/html5.js"></script>
<![endif]-->
<style type="text/css">
	input::-webkit-input-placeholder{
            color:#AAAAAA;
        }
        input::-moz-placeholder{   /* Mozilla Firefox 19+ */
            color:#AAAAAA;
        }
        input:-moz-placeholder{    /* Mozilla Firefox 4 to 18 */
            color:#AAAAAA;
        }
        input:-ms-input-placeholder{  /* Internet Explorer 10-11 */ 
            color:#AAAAAA;
        }

</style>
</head>
<body>
	<div class="container demo-1">
		<div class="content">
			<div id="large-header" class="large-header">
				<canvas id="demo-canvas"></canvas>
				<div class="logo_box">
					<h3>欢迎您</h3>
					<form action="/admin/login" class="layui-form" name="login" method="post">
						<input type="hidden" name="_token" value="{{csrf_token()}}"/>
						
						<div class="input_outer layui-form-item">
							<div class="layui-input-inline">
								<span class="u_user"></span>
								<input id="logname" name="logname" class="text" style="color: #FFFFFF !important" type="text" required  lay-verify="required" placeholder="请输入账户" autocomplete="off" value="{{$logname or ''}}">
							</div>
						</div>
						<div class="input_outer layui-form-item">
							<div class="layui-input-inline">
								<span class="us_uer"></span>
							<input name="logpassword" id="logpassword" class="text" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" required  lay-verify="required" type="password" placeholder="请输入密码">
							</div>

							
						</div>
						<label class="form-inline">
					<!-- 		<div class="form-inline-font">
								请滑动验证
							</div>
							<div class="form-inline-input">
								<div class="code-box" id="code-box">
									<input type="text" name="code" class="code-input" />
									<p></p>
									<span> >>> </span>
								</div>
							</div> -->
						</label>
						<div class="mb2">
							<input type="submit" class="act-but submit" name="dosubmit" value="登录" lay-submit lay-filter="formDemo" onclick="checkLogin()" style="color: #FFFFFF;width:330px;height: 46px;">
						</div>
					</form>
					<input type="hidden" name="msg" id="msg" value="{{$msg or ''}}">
				</div>
			</div>
		</div>
	</div><!-- /container -->
	<script type="text/javascript" src="{{asset('./admin/layui/layui.js')}}"></script>
	<script src="{{asset('./admin/js/login.js')}}"></script>
	<script src="{{asset('./admin/js/TweenLite.min.js')}}"></script>
	<script src="{{asset('./admin/js/EasePack.min.js')}}"></script>
	<script src="{{asset('./admin/js/rAF.js')}}"></script>
	<script src="{{asset('./admin/js/demo-1.js')}}"></script>
	<script src="{{asset('./admin/js/jquery.min.js')}}"></script>
	<script src="{{asset('/admin/layui/layui.js')}}"></script>
	<script>
		layui.use(['jquery'], function(){ 
			// 重点处 转让 $ 使用
			var $ = layui.$;
			  
			//后面就跟你平时使用jQuery一样
			  	var msg = $("#msg").val().trim();

			  	layui.use('layer', function(){
				  var layer = layui.layer;
				  var $ = layui.$;
				  var msg = $("#msg").val();
				  if(msg.length>0){
				  	var msgt = layer.msg(msg,{icon:2},{
				  		offset:'30%',
  						shift: 6
				  	});
				  }

				});
		});




		layui.use('form', function(){
			var form = layui.form;

		  //监听提交
		  form.on('submit(formDemo)', function(data){
		  	// layer.msg();
		  // 	var bz = true;
		  // 	if($("#code-box p").text() != "验证成功"){
		  // 		layer.msg('验证失败！请重新验证！',{icon: 2}, function(){
		  // 			bz = false;
				//   alert(bz);
				// });
		  // 	}else{
		  // 		layer.msg('验证成功！',{icon: 1}, function(){

				// });
		  // 	}
		  // 	return false;
		  });
		});

		window.addEventListener('load',function(){

			//code是后台传入的验证字符串
			var code = "123",
			codeFn = new moveCode(code);
			
			//获取当前的code值
			console.log(codeFn.getCode());

			// alert($(".code-box p").text());

			//改变code值
			// code = '46asd546as5';
			// codeFn.setCode(code);
			//重置为初始状态
			codeFn.resetCode();
		});

		// function checkLogin(){
		// 	if($("#code-box p").text() == "验证成功"){
				
		// 	}else{
		// 		alert("请重新验证！");
		// 	}
		// }


	</script>
	
</body>
</html>