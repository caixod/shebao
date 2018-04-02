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
                                        <td>下单账号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["account_name"]); ?>" name="account_name" class="form-control" style="width:250px;"/>
                                        </td>
                                        <td>下单人姓名:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["uname"]); ?>" name="uname" id="uname"  class="form-control" style="width:250px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>办理人姓名:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["username"]); ?>" name="username" class="form-control" style="width:250px;"/>
                                        </td>
                                        <td>办理人手机号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["mobile"]); ?>" name="mobile" id="mobile"  class="form-control" style="width:250px;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>身份证号:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["idcard"]); ?>" name="idcard" class="form-control" style="width:250px;"/>
                                        </td>
                                        <td>卡所属的开户行:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["belong_bank"]); ?>" name="belong_bank" class="form-control" style="width:250px;"/>
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
                                        <td>是否缴纳公积金:</td>

                                        <td style="color: red;">
                                            <?php switch($info["is_gjj"]): case "2": ?>不缴纳<?php break;?>
                                                <?php case "1": ?>缴纳<?php break; endswitch;?>
                                        </td>
                                        </td>
                                        <td>付款状态:</td>
                                        <td style="color: red;">
                                            <?php switch($info["is_pay"]): case "0": ?>未付款<?php break;?>
                                                <?php case "1": ?>已付款<?php break;?>
                                                <?php default: ?>default<?php endswitch;?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>订单总金额:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["money"]); ?>" name="money"  class="form-control" style="width:250px;"/>&nbsp;元
                                        </td>
                                        <td>服务费:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["service_fee"]); ?>" name="service_fee"  class="form-control" style="width:250px;"/>&nbsp;元
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>社保办理基数:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["sb_base"]); ?>" name="sb_base" class="form-control"  style="width:250px;"/>元
                                        </td>

                                        <td>公积金办理基数:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["gjj_base"]); ?>" name="gjj_base" class="form-control"  style="width:250px;"/>元
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>社保缴纳总额:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["sb_fee"]); ?>" name="sb_fee" class="form-control"  style="width:250px;"/>&nbsp;元
                                        </td>
                                        <td>每月社保费用:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["sb_unit_fee"]); ?>" name="sb_unit_fee" class="form-control"  style="width:250px;"/>元/月
                                        </td>
                                    </tr>
                                    <!--公积金也办理-->
                                    <tr>
                                        <td>公积金缴纳总额:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["gjj_fee"]); ?>" name="gjj_fee" class="form-control"  style="width:250px;"/>&nbsp;元
                                        </td>
                                        <td>每月公积金费用:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["gjj_unit_fee"]); ?>" name="gjj_unit_fee" class="form-control"  style="width:250px;"/>元/月
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>办理城市:</td>
                                        <td>
                                            <?php echo ($info["top_name"]); ?>--<?php echo ($info["toc_name"]); ?>
                                        </td>
                                        <td>缴纳时间段:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["start_time"]); ?>" name="start_time" class="form-control" id="start_time" style="width:150px;"/>——
                                            <input type="text" value="<?php echo ($info["end_time"]); ?>" name="end_time" class="form-control"  id="end_time" style="width:150px;"/>
                                    </tr>


                                    <tr>
                                        <td>办理状态</td>
                                        <td >
                                            <label class="radio-inline">
                                                <input type="radio" name="status" value="0" <?php if($info["status"] == 0): ?>checked="checked"<?php endif; ?>>未审核
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="status"  value="1" <?php if($info["status"] == 1): ?>checked="checked"<?php endif; ?>>已审核
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="status"  value="2" <?php if($info["status"] == 2): ?>checked="checked"<?php endif; ?>>审核通过
                                            </label>   <label class="radio-inline">
                                            <input type="radio"  name="status"  value="3" <?php if($info["status"] == 3): ?>checked="checked"<?php endif; ?>>办理中
                                        </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="status"  value="4" <?php if($info["status"] == 4): ?>checked="checked"<?php endif; ?>>已完成
                                            </label>
                                        </td>
                                        <td>户口性质:</td>
                                        <td>
                                            <label class="radio-inline">
                                                <input type="radio" name="nature" value="1" <?php if($info["nature"] == 1): ?>checked="checked"<?php endif; ?>>农村户口
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio"  name="nature"  value="2" <?php if($info["nature"] == 2): ?>checked="checked"<?php endif; ?>>城镇户口
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>档案存放时间:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["record_book"]); ?>" name="record_book" id="record_book" class="form-control" style="width:250px;"/>

                                        </td>
                                        <td>档案存放费:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["record_book_fee"]); ?>" name="record_book_fee" class="form-control" style="width:250px;" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}" />元

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>状态:</td>
                                        <td colspan="3">
                                            <select name="deal_status" class="form-control" style="width: 200px;">
                                                <option value="0" <?php if($info["deal_status"] == 0): ?>selected="selected"<?php endif; ?>>正常</option>
                                                <option value="1" <?php if($info["deal_status"] == 1): ?>selected="selected"<?php endif; ?>>到期</option>
                                                <option value="2" <?php if($info["deal_status"] == 2): ?>selected="selected"<?php endif; ?>>续费成功</option>
                                                <option value="3" <?php if($info["deal_status"] == 3): ?>selected="selected"<?php endif; ?>>减员完成</option>
                                                <!--<option value="4" <?php if($info["deal_status"] == 4): ?>selected="selected"<?php endif; ?>>减员完成</option>-->
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>存折领取:</td>
                                        <td>
                                            <select name="bankbook" class="form-control" style="width: 200px;">
                                                <option value="0" <?php if($info["bankbook"] == 0): ?>selected="selected"<?php endif; ?>>未领取</option>
                                                <option value="1" <?php if($info["bankbook"] == 1): ?>selected="selected"<?php endif; ?>>已领取</option>
                                            </select>

                                        </td>
                                        <td>存折领取时间:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["bankbook_time"]); ?>" name="bankbook_time" id="bankbook_time" class="form-control" style="width:250px;" />

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>合同签订日期:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["ht_time"]); ?>" name="ht_time" id="ht_time" class="form-control" style="width:250px;" />

                                        </td>
                                        <td>合同到期日期:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["ht_end_time"]); ?>" name="ht_end_time" id="ht_end_time" class="form-control" style="width:250px;" />

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>是否缴纳个税:</td>
                                        <td>
                                            <select name="is_ownmoney" class="form-control" style="width: 200px;">
                                                <option value="0" <?php if($info["is_ownmoney"] == 0): ?>selected="selected"<?php endif; ?>>不缴纳</option>
                                                <option value="1" <?php if($info["is_ownmoney"] == 1): ?>selected="selected"<?php endif; ?>>缴纳</option>
                                            </select>

                                        </td>
                                        <td>合作状态:</td>
                                        <td>
                                            <select name="business_status" class="form-control" style="width: 200px;">
                                                <option value="0" <?php if($info["business_status"] == 0): ?>selected="selected"<?php endif; ?>>合作中</option>
                                                <option value="1" <?php if($info["business_status"] == 1): ?>selected="selected"<?php endif; ?>>已终止</option>
                                            </select>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>负责人:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["deal_people"]); ?>" name="deal_people" class="form-control" style="width:250px;"/>

                                        </td>
                                        <td>承办人1:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["deal_people_o"]); ?>" name="deal_people_o" class="form-control" style="width:250px;"/>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>承办人2:</td>
                                        <td>
                                            <input type="text" value="<?php echo ($info["deal_people_t"]); ?>" name="deal_people_t" class="form-control" style="width:250px;"/>

                                        </td>
                                        <td>代金券使用金额:</td>
                                        <td >
                                            <input type="text" value="<?php echo ($info["coupon_fee"]); ?>" name="coupon_fee" class="form-control" style="width:250px;" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){ layer.msg('只能是数字或者小数', {icon: 2,time: 3000});this.value='';}" />

                                    </tr>
                                    <tr>
                                        <td >身份证:</td>
                                        <td colspan="3">
                                            <a href="<?php echo ($info["image"]); ?>" target="_blank"><image style="width: 200px;height: 200px;" src="<?php echo ($info["image"]); ?>" /></a>
                                            <a href="<?php echo ($info["image"]); ?>" target="_blank">  <image style="width: 200px;height: 200px;" src="<?php echo ($info["image_t"]); ?>" /></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>订单处理备注:</td>
                                        <td colspan="3">
                                            <textarea name="deal_mark" cols="100" rows="3"><?php echo ($info["deal_mark"]); ?></textarea>
                                        </td>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td>合同:</td>
                                        <td>
                                            <?php if($info["ht"] == '0'): ?><input type="file" name="ht" id="ht" value="">      <span style="color: red;">(审核通过之后请上合同文件)</span>
                                                <?php else: ?>
                                                &nbsp;&nbsp;&nbsp;

                                                <div class="form-group form-inline">
                                                    <label for="exampleInputName2"></label>
                                                    <a  href="<?php echo ($info["ht"]); ?>">点击下载查看原合同</a>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">更换原合同</label>
                                                    <input type="file"  name="ht"  value="">   </div><?php endif; ?>
                                        <td style="text-align: center;">办理凭证:</td>
                                        <td>
                                            <?php if($info["certify"] == '0'): ?><input type="file" name="certify" id="certify" value="">      <span style="color: red;">(办理完成请上传凭证)</span>
                                                <?php else: ?>
                                                &nbsp;&nbsp;&nbsp;

                                                <div class="form-group form-inline">
                                                    <label for="exampleInputName2"></label>
                                                    <a  href="<?php echo ($info["certify"]); ?>">点击下载查看原凭证</a>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail2">更换原凭证</label>
                                                    <input type="file"  name="certify"  value="">   </div><?php endif; ?>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: center;">发送通知短信给该用户:</td>
                                        <td colspan="3">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="content" class="form-control" style="width: 700px;">
                                                        <span class="input-group-btn">
						<button class="btn btn-default" onclick="send_mess(<?php echo ($info["id"]); ?>);" type="button">
							点击发送此内容
						</button>
					</span>
                                                    </div><!-- /input-group -->
                                                </div><!-- /.col-lg-6 -->
                                            </div><!-- /.row -->
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pull-right">
                            <input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>">
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

        var url = "/index.php?m=Admin&c=Order&a=ajax_send_mess&table_name=sb_bujiao&mobile="+mobile+'&content='+content+"&id="+id;
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
    laydate.render({
        elem: '#record_book'
    });
    laydate.render({
        elem: '#bankbook_time'
    });
    laydate.render({
        elem: '#ht_time'
    });
    laydate.render({
        elem: '#ht_end_time'
    });
</script>
</body>
</html>