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
                    <h3 class="panel-title"><i class="fa fa-list"></i> 订单处理</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">详情</a></li>
                    </ul>
                    <!--表单数据-->
                    <!--<form method="post" id="addEditBusinessUserForm" onsubmit="return checkName();">-->
                    <form method="post" id="addEditDishForm" enctype="multipart/form-data">
                        <!--通用信息-->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_tongyong">

                                <table class="table table-bordered table-striped" >
                                    <tbody>
                                    <tr>
                                        <td>账号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["account_name"]); ?>" name="account_name" class="form-control" style="width:250px;"/>
                                        </td>
                                        <td>姓名:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["username"]); ?>" name="username" class="form-control" style="width:250px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>身份证号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["idcard"]); ?>" name="idcard" class="form-control" style="width:250px;"/>
                                        </td>

                                        <td>办理人手机号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["mobile"]); ?>" name="mobile" id="mobile"  class="form-control" style="width:250px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>开户行:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["bank_name"]); ?>" name="bank_name" class="form-control" style="width:250px;"/>
                                        </td>
                                        <td>卡号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["bank_num"]); ?>" name="bank_num" class="form-control" style="width:250px;"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>户口性质:</td>
                                        <td>
                                            <label class="radio-inline">
                                                <input type="radio" name="nature" value="1" <?php if($info["nature"] == 1): ?>checked="checked"<?php endif; ?>>农村户口
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="nature"  value="2" <?php if($info["nature"] == 2): ?>checked="checked"<?php endif; ?>>城镇户口
                                            </label>
                                        </td>
                                        <td>性别:</td>
                                        <td>
                                            <label class="radio-inline">
                                                <input type="radio" name="sex" value="1" <?php if($info["sex"] == 1): ?>checked="checked"<?php endif; ?>>男
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="sex"  value="2" <?php if($info["sex"] == 2): ?>checked="checked"<?php endif; ?>>女
                                            </label>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pull-right">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo ($info["user_id"]); ?>">
                            <button class="btn btn-primary" data-toggle="tooltip" type="submit"  data-original-title="确定">确定</button>
                        </div>
                    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>


<script src="/Public/js/global.js"></script>
<script src="/Public/js/pc_common.js"></script>
<script>
    //发送短信通知
    function send_mess(id){

        var mobile=$.trim($("#mobile").val());
        var content=$.trim($("#content").val());
        if(mobile==''){
            layer.msg('请输入该用户的手机号码', {icon: 2,time: 3000});
            return false;
        }
        if(content==''){
            layer.msg('请输入发送的内容', {icon: 2,time: 3000}); //alert(v.msg);
            return false;
        }

        var url = "/index.php?m=Admin&c=Order&a=ajax_send_mess&table_name=rc_yingjin&mobile="+mobile+'&content='+content+"&id="+id;
        $.ajax({
            url:url,
            type:'get',
            dataType:'json',
            success:function(e){
                if(e.code==1){
                    layer.msg('已发送', {icon: 1,time: 3000}); //alert(v.msg);
                }else{
                    layer.msg('发送失败，请重试', {icon: 2,time: 3000}); //alert(v.msg);
                }
                window.location.reload();

            },
            error:function(a){
                layer.msg('错误……', {icon: 2,time: 3000}); //alert(v.msg);
                window.location.reload();
            }


        })
    }
</script>
</body>
</html>