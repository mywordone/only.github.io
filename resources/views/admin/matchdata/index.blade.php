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
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3" style="text-align: left;width: 100px;">运动员</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="playername" size="1" id="player">
					<option value="0">请选择运动员</option>
					@foreach($matchinfos as $key => $data)
						@if($match_id == $data->id)
						<option value="{{$data->playerA_id}}" 
						{{$player_id == $data->playerA_id ? 'selected' : '' }}	
						>{{$data->playerAname}}</option>
						<option value="{{$data->playerB_id}}"
						{{$player_id == $data->playerB_id ? 'selected' : '' }}
						>{{$data->playerBname}}</option>
						@endif
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
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="9">比赛数据列表</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="100">局数</th>
				<th width="75">得分</th>
				<th width="75">失分</th>
				<th width="100">发接轮次</th>
				<th width="100">拍数</th>
				<th width="100">手段</th>
				<th width="75">得失分</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($matchdatas)){ ?>
			@foreach ($matchdatas as $key => $data)
			<tr class="text-c">
				<td>{{ $key+1 }}</td>
				<td>{{ $data->name }}</td>
				<td>{{ $data->getscore }}</td>
				<td>{{ $data->losescore }}</td>
				<td>{{ $data->take_send }}</td>
				<td>{{ $data->patnum }}</td>
				<td>{{ $data->methods }}</td>
				<td>{{ $data->get_lose }}</td>
				<td class="td-manage">
					<a title="编辑" href="javascript:;" 
					onclick="data_edit('编辑','{{route('matchdata_edit')}}','{{$data->id}}','600','400')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
					<a title="删除" href="javascript:;" onclick="data_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
				</td>
			</tr>
			@endforeach
			<?php } ?>
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

function resets(){
	location.href = location.href;
}
//表单提交验证
function checkForm(){
	var match = $.trim($('#match').val());
	var player = $.trim($('#player').val());
	if(match == 0){
		layer.alert('请选择比赛名称',{icon:2});
		return false;
	}
	if(player == 0){
		layer.alert('请选择运动员',{icon:2});
		return false;
	}
	return true;
}

/*比赛数据-删除*/
function data_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'get',
			url: '{{route('matchdata_delete')}}?id='+id,
			dataType: 'json',
			success: function(data){
				if(data.code == 0){
					$(obj).parents("tr").remove();
					layer.msg(data.msg,{icon:1,time:1000});
				}else{
					layer.msg(data.msg,{icon:2,time:1000});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*比赛数据-编辑*/
function data_edit(title,url,id,w,h){
	layer_show(title,url+'?id='+id,w,h);
}

// jQuery页面载入事件
$(function(){
	// dt初始化
	$('table').DataTable({
		// "ordering": false, // 禁止排序
		"columnDefs": [{ "orderable": false, "targets": 0 }],//禁止第1列排序
		"order": [[ 0, "asc" ]]	//指定第2列排序，默认为降序排列
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
</body>
</html>