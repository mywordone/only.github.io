<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>试题列表</title>
</head>
<body>

<div class="page-container">
	<form class="form form-horizontal" id="form-admin-add" 
				action="" method="post" onsubmit="return checkForm();">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3" style="text-align: left; width: 100px;">比赛名称</label>
			<div class="formControls col-xs-3 col-sm-3"> <span class="select-box" style="width:350px;">
				<select class="select" name="matchname" size="1" id="match">
					<option value="0">请选择比赛名称</option>
					@foreach($matchinfos as $key => $data)
					<option value="{{ $data->id }}" 
						<?php if(isset($match_id) && $match_id == $data->id) echo 'selected'; ?> >
						{{ $data->match_name.' '.$data->match_item.' '.$data->match_phase  }}</option>
					@endforeach
				</select>
				</span>
			</div>
		</div>
		<!-- csrf -->
        {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3" style="text-align: left;width: 100px;"></label>
			<div class="col-xs-8 col-sm-9">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;查询&nbsp;&nbsp;">
				<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;重置&nbsp;&nbsp;"
				 onclick="resets()" >
			</div>
		</div>
	</form>
	<br>
	<table class="table table-border table-bordered table-bg " style="table-layout: fixed">
		<thead>
			<tr>
				<th scope="col" colspan="11">比赛成绩列表</th>
			</tr>
			<tr class="text-c">
				<th width="30">序号</th>
				<th width="100">比赛时间</th>
				<th width="200">比赛名称</th>
				<th width="100">比赛项目</th>
				<th width="100">比赛阶段</th>
				<th width="80">运动员A</th>
				<th width="80">运动员B</th>
				<th width="50">大比分</th>
				<th width="50">小比分</th>
				<th width="60">状态</th>
				<th width="50">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($matchinfos as $key => $data)
			<tr class="text-c">
				<td>{{ $key+1 }}</td>
				<td>{{ $data->match_time }}</td>
				<td>{{ $data->match_name }}</td>
				<td>{{ $data->match_item }}</td>
				<td>{{ $data->match_phase }}</td>
				<td>{{ $data->playerAname }}</td>
				<td>{{ $data->playerBname }}</td>
				<td>{{ $data->bigscore }}</td>
				<td style="width:100px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
					{{ $data->smallscore }}
				</td>
				<td>@if($data->status == 0) <span style="color: blue">已上线</span> 
					@else <span style="color: red">未上线</span> @endif</td>
				<td class="td-manage">
					@if($data->status == 0)
					<span style="color: grey">上线</span>
					<a href="javascript:;" onclick="downline('{{$data->id}}')" class="ml-5"
						 style="text-decoration:none;"><span style="color: red">下线</span>
					</a>
					@else
					<a href="javascript:;" onclick="upline('{{$data->id}}')" class="ml-5"
					style="text-decoration:none;"><span style="color: blue">上线</span></a>
					<span style="color: grey">下线</span>
					@endif
					
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
function checkForm(){
	var match = $.trim($('#match').val());
	if(match == 0){
		layer.alert('请选择比赛名称',{icon:2});
		return false;
	}
	return true;
}

function resets(){
	location.href = location.href;
}

/*比赛-上线*/
function upline(id){
	layer.confirm('确认要上线吗？',function(index){
		$.get('{{route("matchscore_upline")}}?id='+id, function(data) {
			if(data.code == 0){
				layer.msg(data.msg,{icon:1,time:1000});
				setTimeout(function(){
					window.location.reload();
				},1000);
			}else{
				layer.msg(data.msg,{icon:2,time:2000});
			}
		},'json');
	});
}

/*比赛-下线*/
function downline(id){
	layer.confirm('确认要下线吗？',function(index){
		$.get('{{route("matchscore_downline")}}?id='+id, function(data) {
			if(data.code == 0){
				layer.msg(data.msg,{icon:1,time:1000});
				setTimeout(function(){
					window.location.reload();
				},1000);
			}else{
				layer.msg(data.msg,{icon:2,time:2000});
			}
		},'json');
	});
}


// jQuery页面载入事件
$(function(){
	// dt初始化
	$('table').DataTable({
		// "ordering": false, // 禁止排序
		"columnDefs": [{ "orderable": false, "targets": 0 }],//禁止第1列排序
		"order": [[ 0, "asc" ]]	//指定第2列排序，默认为降序排列
	});
});
</script>
</body>
</html>