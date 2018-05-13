@extends('front.front_userInfo')

@section('cantainer')


<div class="col-md-10 col-md-offset-1 panel">
	<div class="panel-body articles-create ">
		<p class="header text-center" style="line-height: 20px;font-weight:100;font-size: 28px;color: #6d6b6b;" id="sst"><i class="glyphicon glyphicon-edit" style="top: 5px;"></i> 新建讨论</p>
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
					<button class="btn btn-primary submit-btn" id="topicSubmit" type=""> <i class="glyphicon glyphicon-send"></i>&nbsp;发布讨论</button>
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
		$("#sst").html('<i class="glyphicon glyphicon-edit" style="top: 5px;"></i> 编辑讨论');
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

	//定义函数
      function forbiddenStr(str){
      	//定义敏感字符
 		  var forbiddenArray =['xx','黄色','fuck','tmd','他妈的','李愚蠢','中国猪','台湾猪','进化不完全的生命体','贱人','装b','大sb','傻逼','傻b','煞逼','煞笔','刹笔','傻比','沙比','欠干','婊子养的','我日你','我操','我草','卧艹','卧槽','爆你菊','艹你','cao你','cao你ma','cao你吗','cao你妈','草拟吗','娘西皮','sb','贱货','人渣','按摩','高潮','呻吟','脱光','警察我们是为人民服务的','领导干部吃王八','孟玉'];
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
	        
 		    if(!forbiddenStr(sContent)){
 		    	$.dialog({
					title:'',
					content: '<div style="text-align:center">含有敏感词不能发布！请注意您的言辞！</div>',
				});
 		    }else{
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
			
		}
	});

});


</script>

@endsection