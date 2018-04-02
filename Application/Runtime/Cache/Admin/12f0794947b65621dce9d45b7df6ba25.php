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
                    <h3 class="panel-title"><i class="fa fa-list"></i> 修改社保信息</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">修改<?php echo ($info["name"]); ?>社保信息</a></li>
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditBrandForm" action="<?php echo U('Admin/Manage/sb_edit');?>" onsubmit="return checkName();">

                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>地区:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["name"]); ?>" name="name" class="form-control" readonly style="width:200px;"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td>滞纳金:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["stop_money"]); ?>" name="stop_money" class="form-control"  style="width:200px;"/>&nbsp;&nbsp; <label style="color: red;">（万分之五 只需要填写5即可,万分之三十 只需要填写30即可,）</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>养老保险最小基数::</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_one_min"]); ?>" name="xian_one_min" id="xian_one_min" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;养老保险最大基数:
                                        <input type="text" value="<?php echo ($info["xian_one_max"]); ?>" name="xian_one_max" id="xian_one_max"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                    </td>
                                </tr>
                                <tr>
                                    <td>养老保险比例（个人）:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_one"]); ?>" name="xian_one" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;养老保险比例（单位）:
                                        <input type="text" value="<?php echo ($info["c_xian_one"]); ?>" name="c_xian_one"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                    </td>
                                </tr>
                                <tr>
                                    <td>失业保险最小基数::</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_two_min"]); ?>" name="xian_two_min" id="xian_two_min" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;失业保险最大基数:
                                        <input type="text" value="<?php echo ($info["xian_two_max"]); ?>" name="xian_two_max" id="xian_two_max"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                    </td>
                                </tr>
                                <tr>
                                    <td>失业保险比例（个人）:</td>
                                    <td>
                                        城镇：<input type="text" value="<?php echo ($info["xian_two"]); ?>" name="xian_two" class="form-control" style="width:100px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                        农村：0%
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;失业保险比例（单位）:
                                        <input type="text" value="<?php echo ($info["c_xian_two"]); ?>" name="c_xian_two"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                    </td>
                                </tr>
                                <tr>
                                    <td>生育保险最小基数::</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_three_min"]); ?>" name="xian_three_min" id="xian_three_min" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;生育保险最大基数:
                                        <input type="text" value="<?php echo ($info["xian_three_max"]); ?>" name="xian_three_max" id="xian_three_max"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                    </td>
                                </tr>
                                <tr>
                                    <td>生育保险比例（个人）:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_three"]); ?>" name="xian_three" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;生育保险比例（单位）:
                                        <input type="text" value="<?php echo ($info["c_xian_three"]); ?>" name="c_xian_three"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                    </td>
                                </tr>
                                <tr>
                                    <td>工伤保险最小基数::</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_four_min"]); ?>" name="xian_four_min" id="xian_four_min" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;工伤保险最大基数:
                                        <input type="text" value="<?php echo ($info["xian_four_max"]); ?>" name="xian_four_max" id="xian_four_max"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                    </td>
                                </tr>
                                <tr>
                                    <td>工伤保险比例（个人）:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_four"]); ?>" name="xian_four" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;工伤保险比例（单位）:
                                        <input type="text" value="<?php echo ($info["c_xian_four"]); ?>" name="c_xian_four"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                    </td>
                                </tr>
                                <tr>
                                    <td>医疗保险最小基数::</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_five_min"]); ?>" name="xian_five_min" id="xian_five_min" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;医疗保险最大基数:
                                        <input type="text" value="<?php echo ($info["xian_five_max"]); ?>" name="xian_five_max" id="xian_five_max"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;元
                                    </td>
                                </tr>
                                <tr>
                                    <td>医疗保险比例（个人）:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($info["xian_five"]); ?>" name="xian_five" class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;% +3元
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;医疗保险比例（单位）:
                                        <input type="text" value="<?php echo ($info["c_xian_five"]); ?>" name="c_xian_five"  class="form-control" style="width:250px;"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}"/>&nbsp;&nbsp;%
                                    </td>
                                </tr>

                                </tbody>                                
                                </table>
                            <label style="color: red">温馨提示：如：2% 只需要填写2即可，0.5% 只需要填写0.5即可</label>
                        </div>                           
                    </div>              
                    <div class="pull-right">

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

// 判断输入框是否为空
function checkName(){

    // var shebao_minbase = $.trim($("#shebao_minbase").val());
    // var shebao_maxbase = $.trim($("#shebao_maxbase").val());

    // if(shebao_maxbase =='' || shebao_minbase=='')
    // {
    //     layer.msg('请填写社保的基数范围', {icon: 2,time: 3000});
    //     return false;
    // }
	return true;
}


</script>
</body>
</html>