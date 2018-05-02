@extends('front.front_userInfo')

@section('cantainer')


<div class="col-md-10 col-md-offset-1 panel">
	<div class="panel-body articles-create ">
		<p class="header text-center" style="line-height: 20px;font-weight:100;font-size: 28px;color: #6d6b6b;"><i class="glyphicon glyphicon-share" style="top: 5px;"></i> 分享链接</p>
		<hr>

		<form method="POST" action="" accept-charset="UTF-8" id="postForm" class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12">
					<input class="form-control" id="sTitle" placeholder="请填写标题" name="sTitle" type="text" value="{{$links->sTitle or ''}}">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<input class="form-control" id="sLinks" placeholder="分享的链接" name="sLinks" type="text" value="{{$links->sLinks or ''}}">
				</div>
			</div>	
			<div class="form-group">
				<div class="col-sm-12">
					<div id="summernote" class="col-sm-12"></div>
				</div>
				
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-primary submit-btn" id="topicSubmit"> <i class="fa fa-paper-plane"></i> 发布链接</button>
					
				</div>
			</div>
		</form>
		<input type="hidden" id="hidsContent" value="{{$links->sContent or ''}}">
		<input type="hidden" id="hidsPostID" value="{{$links->sPostID or ''}}">
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

	    // 将内容绑定到文本编辑器中
	    var sContent = $("#hidsContent").val();
	    var sPostID = $("#hidsPostID").val();
		if(sContent.length > 0){
			$('#summernote').summernote('code',sContent);
		}


	var form = $("#postForm");
	form.bootstrapValidator({
		message: '输入值不合法',
		feedbackIcons: {
			// valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields:{
			sTitle:{
				validators: {
					notEmpty: {
						message: '标题不能为空！'
					}
				}
			},
			sLinks:{
				validators: {
					notEmpty: {
						message: '地址不能为空！'
					},
					uri: {
						message: '地址格式错误！http://www.xxx.com'
					}
				}
			}
		}
	});

	$("#topicSubmit").on('click',function(){

		var bv = form.data('bootstrapValidator');
		bv.validate();
		var sContent = $('#summernote').summernote('code');
		var sTitle = $("#sTitle").val();
		var sLinks = $("#sLinks").val();
		console.log(sLinks);

		if(bv.isValid()){
			var links = {
	            sTitle:sTitle,
	            sContent:sContent,
	            sContent:sContent,
	            sLinks:sLinks,
	            sPostID:sPostID
	            
	        };
			$.ajax({
				type: 'POST',
				url: '/links/save',
				data: links,
				dataType:'text',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
				},
				success: function(data){
					if(data == 1){
						$.dialog({
							title:'',
							content: '<div style="text-align:center">发布成功！</div>',
						});
						setTimeout("location.href='/'",1500);
					}else{
						$.dialog({
							title:'',
							content: '<div style="text-align:center">发布失败！</div>',
						});
					}
				},
				error: function(xhr, type){
					$.dialog({
						title:'',
						content: '<div style="text-align:center">发布失败！</div>',
					});

				}

			});
		}

	});


});


</script>

@endsection