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
    <link rel="stylesheet" type="text/css" href="/admin/webuploader-0.1.5/webuploader.css">
    <!--[if IE 6]>
<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
    <!--/meta 作为公共模版分离出去-->
    <title>修改比赛数据</title>
    <meta name="keywords" content="H-ui.admin ">
    <meta name="description" content="H-ui.admin ">
    <style>
        label{text-align: right;}
        .row.cl{margin-bottom: 5px;}
    </style>
</head>

<body>
    <article class="page-container">
        <form>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">局数</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:150px;">
                    <select class="select" name="round_id" id="round_id" size="1">
                        @foreach($rounds as $key => $round)
                        <option value="{{ $round->id }}" 
                            <?php echo $round->id == $data->round_id ? 'selected':'' ?> >
                            {{ $round->name }}</option>
                        @endforeach
                    </select>
                    </span> 
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">总得</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" name="getscore" id="getscore" 
                    class="input-text" value="{{$data->getscore}}" min="0" style="width:150px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">总失</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" name="losescore" id="losescore" 
                    class="input-text" value="{{$data->losescore}}" min="0" style="width:150px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">发接轮次</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box" style="padding: 0">
                        <input name="take_send" type="radio" value="发" id="take_send-1"
                        <?php echo $data->take_send == '发'? 'checked':'' ?> >
                        <label for="take_send-1" style="padding-left: 5px">发</label>
                    </div>
                    <div class="radio-box" style="padding-left: 10px">
                        <input type="radio" id="take_send-2" value="接" name="take_send"
                        <?php echo $data->take_send == '接'? 'checked':'' ?> >
                        <label for="take_send-2" style="padding-left: 5px">接</label>
                    </div>
                </div>
            </div> 
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">拍数</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:150px;">
                    <select class="select" name="patnum" id="patnum" size="1">
                        <option value="发球" <?php echo $data->patnum == '发球' ? 'selected':'' ?>>发球</option>
                        <option value="接发球" <?php echo $data->patnum == '接发球' ? 'selected':'' ?>>接发球</option>
                        <option value="第三板" <?php echo $data->patnum == '第三板' ? 'selected':'' ?>>第三板</option>
                        <option value="第四板" <?php echo $data->patnum == '第四板' ? 'selected':'' ?>>第四板</option>
                        <option value="第五板" <?php echo $data->patnum == '第五板' ? 'selected':'' ?>>第五板</option>
                        <option value="第六板" <?php echo $data->patnum == '第六板' ? 'selected':'' ?>>第六板</option>
                        <option value="相持" <?php echo $data->patnum == '相持' ? 'selected':'' ?>>相持</option>
                    </select>
                    </span> 
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">手段</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:150px;">
                    <select class="select" name="methods" id="methods" size="1">
                        <option value="发球" <?php echo $data->methods == '发球' ? 'selected':'' ?>>发球</option>
                        <option value="对方发球失误" <?php echo $data->methods == '对方发球失误' ? 'selected':'' ?>>对方发球失误</option>
                        <option value="正手" <?php echo $data->methods == '正手' ? 'selected':'' ?>>正手</option>
                        <option value="反手" <?php echo $data->methods == '反手' ? 'selected':'' ?>>反手</option>
                        <option value="侧身" <?php echo $data->methods == '侧身' ? 'selected':'' ?>>侧身</option>
                        <option value="控制" <?php echo $data->methods == '控制' ? 'selected':'' ?>>控制</option>
                        <option value="意外" <?php echo $data->methods == '意外' ? 'selected':'' ?>>意外</option>
                    </select>
                    </span> 
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">得失分</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box" style="padding: 0">
                        <input name="get_lose" type="radio" value="得" id="get_lose-1" 
                        <?php echo $data->get_lose == '得'? 'checked':'' ?> >
                        <label for="get_lose-1" style="padding-left: 5px">得</label>
                    </div>
                    <div class="radio-box" style="padding-left: 10px">
                        <input type="radio" id="get_lose-2" value="失" name="get_lose"
                        <?php echo $data->get_lose == '失'? 'checked':'' ?>>
                        <label for="get_lose-2" style="padding-left: 5px">失</label>
                    </div>
                </div>
            </div> 
            <!-- csrf -->
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" onclick="save()"  
                type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <input class="btn btn-primary radius" type="reset" value="&nbsp;&nbsp;重置&nbsp;&nbsp;">
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
    <script type="text/javascript" src="/admin/webuploader-0.1.5/webuploader.js"></script>
    <script type="text/javascript">
    //表单提交验证
    function save(){
        var round = $.trim($('#round_id').val());
        var getscore = $.trim($('#getscore').val());
        var losescore = $.trim($('#losescore').val());
        var take_send = $.trim($('input[name="take_send"]:checked').val());
        var patnum = $.trim($('#patnum').val());
        var methods = $.trim($('#methods').val());
        var get_lose = $.trim($('input[name="get_lose"]:checked').val());
        if(round == 0){
            layer.alert('请选择局数',{icon:2});
            return false;
        }
        if(getscore == ''){
            layer.alert('总得不能为空',{icon:2});
            return false;
        }
        if(losescore == ''){
            layer.alert('总失不能为空',{icon:2});
            return false;
        }
        if(patnum == 0){
            layer.alert('请选择拍数',{icon:2});
            return false;
        }
        if(methods == 0){
            layer.alert('请选择手段',{icon:2});
            return false;
        }
        
        $.post('{{route('matchdata_edit')}}',$('form').serialize(),function(res){
            if(res.code == 0){
                layer.msg(res.msg,{icon:1});
                setTimeout(function(){parent.window.location.reload();},1000);
            }
        },'json');
    }

    $(function(){      
        
    });
        
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
</body>

</html>