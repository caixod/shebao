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
 

<!--<meta http-equiv="refresh" content="5">-->
<script src="/Public/laydate/laydate.js"></script>
<script src="/Public/artDialog/jquery.artDialog.js?skin=default"></script>
<script src="/Public/artDialog/plugins/iframeTools.js"></script>
<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <nav class="navbar navbar-default">
                            <div class="collapse navbar-collapse">
                                <form class="navbar-form form-inline" action="" method="post" >
                                    <div class="form-group">
                                        用户名：<input type="text" name="account_name" value="<?php echo ($account_name); ?>" class="form-control" style="width: 100px;">
                                    </div>

                                    <button type="submit" class="btn btn-primary">查询</button>
                                    <div class="form-group pull-right">
                                    </div>
                                </form>
                            </div>
                        </nav>

                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list-table" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr role="row" style="text-align: center;">
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;"> 用户名</th>
                                        <th style="text-align: center;">联系电话</th>
                                        <th style="text-align: center;">真实姓名</th>
                                        <th style="text-align: center;">性别</th>
                                        <th style="text-align: center;">注册日期</th>
                                        <!--<th>处理状态</th>.-->
                                        <th style="text-align: center;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php if(is_array($order_mess)): foreach($order_mess as $k=>$vo): ?><tr role="row" style="text-align: center;">
                                            <td><?php echo ($vo["no"]); ?></td>
                                            <td><?php echo ($vo["account_name"]); ?></td>
                                            <td><?php echo ($vo["mobile"]); ?></td>
                                            <td><?php echo ($vo["username"]); ?></td>
                                            <td>
                                                <?php if($vo["sex"] == 1): ?>男

                                                    <?php else: ?>
                                                    女<?php endif; ?>
                                            </td>
                                            <td><?php echo ($vo["add_time"]); ?></td>

                                            <td  style="width: 200px;">
                                                <!--<a href="javascript:distribute(<?php echo ($vo[id]); ?>,'<?php echo ($vo["username"]); ?>')" data-toggle="tooltip" title="" class="btn btn-info goods_list">处理订单</a>-->
                                                <a href="<?php echo U('Admin/User/edit_user',array('id'=>$vo['user_id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="处理订单"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0);" onclick="del('<?php echo ($vo[user_id]); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                            </div>
                            <div class="col-sm-6 text-right"><?php echo ($page); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>


        function showIntroDetail(id){
            art.dialog.open('<?php echo U('Dish/orderInfo');?>?id='+id,{lock:false,title:'订单详情',width:1100,height:620,yesText:'关闭',background: '#000',opacity: 0.87, close: function(){location.reload();}});
        }
        function del(id)
        {
            if(!confirm('确定要删除吗?'))
                return false;
            $.ajax({
                url:"/index.php?m=Admin&c=User&a=ajax_del&table=users&id="+id,
                dataType:'json',
                type:'get',
                success: function(v){
                    layer.msg(v.msg, {icon: 2,time: 3000}); //alert(v.msg);
                    window.location.reload();

                },
                error:function(e){
                    layer.msg('错误……', {icon: 2,time: 3000}); //alert(v.msg);
                    window.location.reload();
                }
            });
            return false;
        }



        laydate.render({
            elem: '#start_time'
        });
        laydate.render({
            elem: '#end_time'
        });
    </script>
</div>
</body>
</html>