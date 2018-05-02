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

	$("#topicSubmit").on('click',function(){

		var sReplyID = $("#hidsReplyID").val();
		var sContent = $('#summernote').summernote('code');
		if(sContent == "<p><br></p>"){
			$.dialog({
				title:'',
				content: '<div style="text-align:center">请注重自身修养！</div>',
			});
		}else{
			var replays = {
		        sReplyID:sReplyID,
		        sContent:sContent
		    };
		    console.log(replays);

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
		
	});

});


</script>

@endsection