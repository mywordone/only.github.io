<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
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
<title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 比赛中心 <span class="c-gray en">&gt;</span> 比赛管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a href="javascript:;" onclick="message_add('添加用户','{{ route('message_add') }}','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加比赛信息</a>
        </span>
        <span class="r">共有数据：<strong>88</strong> 条</span>
    </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">ID</th>
				<th width="100">比赛名称</th>
				<th width="100">比赛日期</th>
				<th width="70">比赛时间</th>
				<th width="90">比赛阶段</th>
				<th width="50">运动员A</th>
				<th width="50">运动员B</th>
				<th width="70">比赛项目</th>
				<th width="70">比赛国家</th>
				<th width="70">比赛城市</th>
				<th width="70">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $val)
			<tr class="text-c">
				<td><input type="checkbox" value="{{$val -> id}}" name=""></td>
				<td>{{$val -> id}}</td>
				<td>{{$val -> game_name}}</td>
				<td>{{$val -> game_date}}</td>
				<td>{{$val -> game_time}}</td>
				<td>{{$val -> game_stage}}</td>
				<td>{{$val -> aname}}</td>
				<td>{{$val -> bname}}</td>
				<td>{{$val -> game_project}}</td>
				<td>{{$val -> state}}</td>
				<td>{{$val -> city}}</td>
				<td class="td-manage">
                    <a title="编辑" href="javascript:;" onclick="message_update('编辑','{{ route('message_update') }}','{{$val -> id}}','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                    <a title="删除" href="javascript:;" onclick="message_del(this,'{{ $val -> id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
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
$(function(){
	$('.table-sort').dataTable({
		"aaSorting": [[ 1, "desc" ]],//默认第几个排序
		"bStateSave": true,//状态保存
		"aoColumnDefs": [
		  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
		  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
		]
	});
	
});
/*用户-添加*/
function message_add(title,url,w,h){
	layer_show(title,url,w,h);
}

/*用户-编辑*/
function message_update(title,url,id,w,h){
	layer_show(title,url+ '?id=' +id,w,h);
}

/*用户-删除*/
function message_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'get',
			url: '{{ route('message_del') }}',
            data:{id:id},
			dataType: 'json',
			success: function(data){
			    if (data.code == '0'){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }else {
			        console.log(data.msg);
                }
			},
		});		
	});
}
</script> 
</body>
</html>