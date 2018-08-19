<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/admin/webuploader-0.1.5/webuploader.css">
<!--[if IE 6]>
<script type="text/javascript" src="admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>添加管理员 - 管理员管理 - H-ui.admin v3.1</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container" >
	<form class="form form-horizontal" id="form-admin-add" action="" method="post">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">模板下载</label>
			<div class="col-xs-8 col-sm-9 ">
				<input class="btn btn-primary radius" 
				style="background-color: rgb(0,183,238); border-color: rgb(0,183,238);" 
				type="button" value="&nbsp;&nbsp;下载&nbsp;&nbsp;"
				onclick="template_export()">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">比赛名称</label>
			<div class="formControls col-xs-3 col-sm-3"> <span class="select-box" style="width:350px;">
				<select class="select" name="matchname" id="match" size="1">
					<option value="0">请选择比赛名称</option>
					@foreach($matchinfos as $key => $data)
					<option value="{{ $data->id }}" >
						{{ $data->match_name.' '.$data->match_item.' '.$data->match_phase  }}</option>
					@endforeach
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">运动员</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="playername" id="player" size="1">
					<option value="0">请选择运动员</option>
				</select>
				</span> 
			</div>
		</div>
		
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">文件</label>
            <div class="formControls col-xs-8 col-sm-9"> 
		        <!-- 替换成webuploader的html示例代码 -->
		        <div id="uploader-demo">
		            <!--用来存放item-->
		            <div id="fileList" class="uploader-list"></div>
		            <div id="filePicker">选择Excel文件</div>
		        </div>
            </div>
        </div>
        <!-- csrf值 -->
        {{csrf_field()}}
        <!-- 存放头像的地址 -->
        <input type="hidden" name="excelpath" value="" id="excelpath"/>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" 
				style="background-color: rgb(0,183,238); border-color: rgb(0,183,238);" 
				type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" 
				onclick="matchdata_import();return false;">
			</div>
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去--> 
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<!-- 引入webuploader.js文件 -->
<script type="text/javascript" src="/admin/webuploader-0.1.5/webuploader.js"></script>
<!-- 引入单独的js上传文件（demo） -->
<script type="text/javascript">
    var _token = "{{csrf_token()}}";
</script>
<script type="text/javascript">
function template_export(){
	location.href = "{{ route('template_export') }}";
}

function matchdata_import(){
	if($('#match').val() == 0){
		return layer.alert('请选择比赛名称',{icon: 2});
	}
	if($('#player').val() == 0){
		return layer.alert('请选择运动员',{icon: 2});
	}
	if($('#excelpath').val() == ''){
		return layer.alert('请上传比赛数据',{icon: 2});
	}

	$.post('{{ route('matchdata_import') }}', $('form').serialize(), function(data) {
		// console.log($('form').serialize());
		if(data == '0'){
			//成功
			layer.msg('导入成功！',{icon:1,time:2000},function(){
				location.href = location.href;
			});
		}else{
			//失败
			layer.msg('导入失败！',{icon:5,time:2000});
		}
	});
}
$(function(){
	
    var $ = jQuery,$list = $('#fileList'),uploader;
    uploader = WebUploader.create({
        formData: {_token: _token},
        // 自动上传。
        auto: true,
        // swf文件路径
        swf: '/admin/webuploader-0.1.5/Uploader.swf',
        // 文件接收服务端。
        server: "http://www.pg_laravel.com/admin/matchdata/uploader",
        // server: "http://0717.com/admin/uploader/qiniu",
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
    });

    uploader.on( 'uploadSuccess', function( file , response ) {
            $( '#'+file.id ).addClass('upload-state-done');
            // 写入隐藏域
            // console.log(response);
            if(response.code == 0){
                layer.msg(response.msg,{icon: 1,time: 1500});
                $('#excelpath').val(response.filepath);
            }else{
                layer.msg(response.msg,{icon: 2,time: 2500});
            }
        });

	$('select[name="matchname"]').change(function(event) {
		var _id = $(this).val();
		var str = '';
		@foreach($matchinfos as $key => $data)
		if(_id == {{$data->id}}){
			str += '<option value="{{$data->playerA_id}}">{{$data->playerAname}}</option>';
			str += '<option value="{{$data->playerB_id}}">{{$data->playerBname}}</option>';
		}
		@endforeach
		$('select[name=playername]').find('option:gt(0)').remove();
		$('select[name="playername"]').append(str);
	});
	
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>