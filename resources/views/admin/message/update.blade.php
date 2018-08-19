<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico">
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
    <!-- 载入webupload.css文件 -->
    {{--<link rel="stylesheet" type="text/css" href="/admin/webuploader/0.1.5/webuploader.css">--}}
    <!--[if IE 6]>
<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
    <!--/meta 作为公共模版分离出去-->
    <title>添加用户 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>

<body>
    <article class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-member-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $v->game_name }}" placeholder="比赛名称" id="game_name" name="game_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="date" class="input-text" value="{{ $v->game_date }}" placeholder="比赛日期" id="game_date" name="game_date">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛时间：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="time" class="input-text" value="{{ $v->game_time }}" placeholder="比赛时间" id="game_time" name="game_time">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛阶段：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $v->game_stage }}" name="game_stage" id="game_stage">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">运动员：</label>
                <div class="formControls col-xs-8 col-sm-9">
                	<span class="select-box" style="width: 150px;">
						<select class="select" size="1" name="country_id">
							<option value="" selected>--运动员A--</option>

                            <option value="{{ $v->game_stage }}"></option>

						</select>
					</span>
                    <span class="select-box" style="width: 150px;">
						<select class="select" size="1" name="province_id">
							<option value="" selected>--运动员B--</option>
                            <!-- 数据追加的位置 -->
                            <option value="{{ $v->game_stage }}"></option>
						</select>
					</span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛项目：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $v->game_project }}" name="game_project" id="game_project">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛国家：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $v->state }}" name="state" id="state">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>比赛城市：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $v->city }}" name="city" id="city">
                </div>
            </div>
            <input type="hidden" name="add_time" value="{{date('Y-m-d H:i:s')}}">
            <input type="hidden" name="show" value="1">
            <input type="hidden" name="states" value="1">
            <!-- csrf -->
            {{csrf_field()}}
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
    <!--/_footer 作为公共模版分离出去-->
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <!-- 载入webuploader的js文件 -->
    {{--<script type="text/javascript" src="/admin/webuploader/0.1.5/webuploader.js"></script>--}}
    <script type="text/javascript">
    $(function() {
        $("#form-member-add").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 2,
                    maxlength: 20
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                gender: {
                    required: true,
                },
                mobile: {
                    required: true,
                    isMobile: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                // 头像
                avatar: {
                    required: true,
                },

            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function(form) {
                $(form).ajaxSubmit({
					type: 'post',
					url: "" ,	//提交给当前地址
					success: function(data){ 
						//判断返回值code
						if(data.code == '0'){
							//成功
							layer.msg(data.msg,{icon:1,time:2000},function(){
								var index = parent.layer.getFrameIndex(window.name);
								// parent.$('.btn-refresh').click();
								parent.location.href = parent.location.href;
								parent.layer.close(index);
							});
						}else{
							//失败
							layer.msg(data.msg,{icon:5,time:2000});
						}
					},
	                error: function(XmlHttpRequest, textStatus, errorThrown){
						layer.msg('error!',{icon:5,time:2000});
					}
				});
            }
        });
    });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
</body>

</html>