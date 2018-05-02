@extends('front.front_userInfo')

@section('cantainer')


<div class="col-md-10 col-md-offset-1 panel">
	<div class="panel-body articles-create ">
		<p class="header text-center" style="line-height: 20px;font-weight:100;font-size: 28px;color: #6d6b6b;"><i class="glyphicon glyphicon-edit" style="top: 5px;"></i> 新建话题</p>
		<hr>

		<form method="POST" action="" accept-charset="UTF-8" id="postForm" class="form-horizontal">
			<!-- <input type="hidden" name="_token" value="{{csrf_token()}}"/> -->
			<div class="form-group">
				<div class="col-sm-2">
                    <select class="form-control" name="postType" id="postType">
                        <option value="" disabled="" selected="">请选择分类</option>
                    	@foreach ($postTypes as $postType)
						    <option value="{{$postType->id}}" value="{{$postType->id}}">{{$postType->sName}}</option>
						@endforeach

                        
                    </select>
                </div>

                <div class="col-sm-10">
					
						<input class="form-control" id="sTitle" placeholder="请填写标题" name="sTitle" type="text" value="{{$posts->sTitle or ''}}">
				
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-12">
					<div id="summernote" class="col-sm-12"></div>
				</div>
			</div>
				
			
			
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-primary submit-btn" id="topicSubmit" type=""> <i class="glyphicon glyphicon-send"></i>&nbsp;发布文章</button>
				</div>
			</div>
			<input type="hidden" id="hidsPostType" value="{{$sPostType->id or ''}}">
			<input type="hidden" id="hidsContent" value="{{$posts->sContent or ''}}">
			<input type="hidden" id="hidsPostID" value="{{$posts->sPostID or ''}}">
		</form>

	
		

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

	// 编辑页面时将数据绑定扫页面上
	var sPostType = $("#hidsPostType").val();
	var sContent = $("#hidsContent").val();
	if(sPostType.length > 0){
		$("select").find("option[value ="+sPostType+" ]").attr("selected","selected");
		// $("#topicSubmit").html('<i class="glyphicon glyphicon-edit"></i> 发布文章');
	}
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
			postType:{
				validators: {
					notEmpty: {
						message: '类别不能为空！'
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
		var sTypeID = $("select option:selected").val();
		var sPostID = $("#hidsPostID").val();

		// console.log(sTypeID);
		// console.log(sTitle);
		// console.log(sContent);
		if(bv.isValid()){
			var posts = {
	            sTypeID:sTypeID,
	            sTitle:sTitle,
	            sContent:sContent,
	            sPostID:sPostID
	        };
			$.ajax({
				type: 'POST',
				url: '/topics/save',
				data: posts,
				dataType:'text',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="token"]').attr("content")
				},
				success: function(data){
					console.log(data);
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