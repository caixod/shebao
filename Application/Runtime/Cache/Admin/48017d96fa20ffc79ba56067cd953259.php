<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>慧智博思管理后台111</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <link rel="icon" href="/Public/images/b.ico" type="img/x-ico" />
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
 	<link href="/Public/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script src="/Public/date/WdatePicker.js"></script>
    <script src="/Public/laydate/laydate.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    //全选
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }   
    
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['90%', '90%'],
            content: $(obj).attr('data-url'), 
        });
    }
    
    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    					layer.closeAll();
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);	
    }
    laydate.render({
        elem: '#start_time'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#end_time'
        ,min: 0
        ,max: 2000
    });
    </script>

  </head>
  <body style="background-color:#ecf0f5;">
 

<script src="/Public/laydate/laydate.js"></script>
<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
           		<!--<a href="javascript:;" class="btn btn-default" data-url="http://www.shop.yiqidongfang.com/Doc/Index/article/id/1010/developer/user.html" onclick="get_help(this)"><i class="fa fa-question-circle"></i> 帮助</a>-->
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 发放代金券</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">添加信息</a></li>
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditBrandForm" action="" onsubmit="return checkName();">

                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>发放对象:</td>
                                        <td>
                                        <select class="form-control" name="user" id="user" style="width:250px;" onchange="get_user(this);">
                                            <option value="">选择发放对象</option>

                                            <?php if(is_array($user_list)): foreach($user_list as $k=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td>对象列表:</td>
                                    <td  colspan="3" >
                                        <div  id="div_l" style="width: 600px;height: auto;">

                                        </div>

                                    </td>
                                </tr>

                                <tr>
                                    <td>有效期:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["start_time"]); ?>" name="start_time" id="start_time" class="form-control" style="width:250px;" />——
                                        <input type="text" value="<?php echo ($info["end_time"]); ?>" name="end_time" id="end_time" class="form-control" style="width:250px;" />&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>代金券设置:</td>
                                    <td>
                                       满 &nbsp;<input type="text" value="<?php echo ($info["max_fee"]); ?>" name="max_fee" id="max_fee" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}" />&nbsp;元 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;减&nbsp;&nbsp;
                                        <input type="text" value="<?php echo ($info["money"]); ?>" name="money" id="money" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}" />&nbsp;元
                                    </td>
                                </tr>


                                </tbody>
                                </table>
                        </div>                           
                    </div>              
                    <div class="pull-left" style="margin-left:200px;">
                        <input type="hidden" name="id" value="<?php echo ($id); ?>">
                        <button class="btn btn-primary" data-toggle="tooltip" type="submit" data-original-title="保存">保存</button>
                    </div>
			    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>
<script>
    function get_user(obj){
        var user_id=$(obj).val();
        var username=$(obj).find(":checked").text();
        if(user_id==""){
            return false;
        }
        var html="";
        html+="<input type='checkbox' style='margin: 5px 5px;' checked='checked' name='user_id[]' value='"+user_id+"'>"+username;
        $("#div_l").append(html);
        $(obj).find(":checked").hide();
    }
// 判断输入框是否为空
function checkName(){

     var start_time=$("#start_time").val();
     var end_time=$("#end_time").val();
     var money=$("#money").val();
     var max_fee=$("#max_fee").val();
    var new_arr=[];
       $("input[name='user_id[]']").each(function(i){
           if ($(this).is(':checked')) {
               new_arr.push($(this).val());
           }
       })
    if(new_arr.length==0){
        layer.msg("请选择发放对象", {icon: 2,time: 3000});
        return false;
    }

    if($.trim(start_time) >= $.trim(end_time))
	{
        layer.msg("请选择正确的时间", {icon: 2,time: 3000});
		return false;
	}
	if($.trim(max_fee)=="")
	{
        layer.msg("请输入满额数", {icon: 2,time: 3000});
		return false;
	}
	if($.trim(money)=="")
	{
        layer.msg("请输入面额", {icon: 2,time: 3000});
		return false;
	}
	return true;
}

laydate.render({
    elem: '#start_time'
});
laydate.render({
    elem: '#end_time'
});
</script>
</body>
</html>