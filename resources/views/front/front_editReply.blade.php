@extends('front.front_userInfo')

@section('cantainer')


<div class="col-md-10 col-md-offset-1 panel">
	<div class="panel-body articles-create ">
		<p class="header text-center" style="line-height: 20px;font-weight:100;font-size: 28px;color: #6d6b6b;"><i class="fa fa-comments-o" style="top: 5px;"></i> 编辑回复</p>
		<hr>

		<form method="POST" action="" accept-charset="UTF-8" id="postForm" class="form-horizontal">
			<!-- <input type="hidden" name="_token" value="{{csrf_token()}}"/> -->
			<div class="form-group">
				<div class="col-sm-12">
					<div id="summernote" class="col-sm-12">
						{!!html_entity_decode($reply->sContent)!!}
					</div>
				</div>
			</div>
				
			
			
			<div class="form-group">
				<div class="col-sm-12 text-center">
					<button class="btn btn-primary" id="topicSubmit" type="button"> <i class="glyphicon glyphicon-leaf"></i>&nbsp;回复修改</button>
				</div>
			</div>
		</form>
		<input type="hidden" id="hidsReplyID" value="{{$reply->sReplyID or ''}}">

	</div>
</div>

@endsection

@section('script')

<script type="text/javascript">
	$(document).ready(function() {

		// 初始化编辑器
		$('#summernote').summernote({
			lang: 'zh-CN',
			placeholder: '请输入内容！',
			tabsize: 2,
	        // height: 350,
	        minHeight: 350,             // set minimum height of editor
	        maxHeight: null,
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

	//定义函数
	  function forbiddenStr(str){
	  	//定义敏感字符
			  var forbiddenArray =['xx','黄色','fuck','tmd','他妈的','李愚蠢','中国猪','台湾猪','进化不完全的生命体','贱人','装b','大sb','傻逼','傻b','煞逼','煞笔','刹笔','傻比','沙比','欠干','婊子养的','我日你','我操','我草','卧艹','卧槽','爆你菊','艹你','cao你','cao你ma','cao你吗','cao你妈','草拟吗','娘西皮','sb','贱货','人渣','按摩','高潮','呻吟','脱光','警察我们是为人民服务的','领导干部吃王八','孟玉','色情','激情网','激情'];
	      var re = '';
	      for(var i=0;i<forbiddenArray.length;i++){
	          if(i==forbiddenArray.length-1)
	             re+=forbiddenArray[i];
	         else
	             re+=forbiddenArray[i]+"|";
	     }
	     //定义正则表示式对象
	    //利用RegExp可以动态生成正则表示式
	     var pattern = new RegExp(re,"g");
	     if(pattern.test(str)){
	         return false;
	     }else{
	         return true;
	     }
	 }


	$("#topicSubmit").on('click',function(){

		var sReplyID = $("#hidsReplyID").val();
		var sContent = $('#summernote').summernote('code');
		tmps = sContent.trim();
		if(sContent == "<p><br></p>" || tmps == 0){
			$.dialog({
				title:'',
				content: '<div style="text-align:center">输入内容不能为空哟！</div>',
			});
		}else{
			var replays = {
		        sReplyID:sReplyID,
		        sContent:sContent
		    };
		    if(!forbiddenStr(sContent)){
		    	$.dialog({
					title:'',
					content: '<div style="text-align:center">含有敏感词不能发布！请注意您的言辞！</div>',
				});
		    }else{
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
							$.dialog({
								title:'',
								content: '<div style="text-align:center">回复修改成功！</div>',
							});
							setTimeout("location.href='/personal/reply/"+sReplyID+"'",1500);
							
						}
					},
					error: function(xhr, type){
						$.dialog({
							title:'',
							content: '<div style="text-align:center">系统原因回复修改失败！</div>',
						});

					}
				});
		    }

			

		}
		
	});

});


</script>

@endsection