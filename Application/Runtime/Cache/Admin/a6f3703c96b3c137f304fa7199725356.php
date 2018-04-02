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
    <!--<div class="container-fluid">-->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading row">
                <div class="pull-right">
                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
                </div>
            </div>

        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">信息(单图文消息请前往图文消息设置)</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <input type="hidden" id="img_id" name="img_id">
                    <input type="hidden" value="<?php echo ($keyword["id"]); ?>" name="kid">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <div class="row">
                                <td class="text-right col-sm-2">关键词：</td>
                                <td colspan="3">
                                    <input type="text" name="keyword" value="<?php echo ($keyword["keyword"]); ?>">
                                </td>
                            </div>
                        </tr>

                        <tr>
                            <div class="row">
                                <td class="text-right col-sm-2">图文：</td>
                                <td colspan="3">
                                    <button class="btn btn-primary btn-sm" type="button" onclick="selectImg()">添加</button>
                                </td>
                            </div>
                        </tr>


                        <tr>
                            <div class="row">
                                <td class="text-right col-sm-2"></td>
                                <td colspan="3">
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit" id="cancel">保存</button>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        </tbody>
                    </table>

                </form>
                <div class="col-lg-3">
                    <!-- small box -->
                    <div class="small-box bg-aqua" style="border: solid 1px saddlebrown;word-break: break-all">

                        <div class="inner" style="text-align: center">
                            <img src="/0.jpg" id="first-img" width="300" height="150" alt="">
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a class="small-box-footer" id="first-text" href="#">这里是标题呢</a>

                    </div>

                </div>

            </div>
        </div>


    </div>    <!-- /.content -->
        </section>
</div>
<script>

    function selectImg(){
        layer.open({
            type: 2,
            title: '添加图文',
            shadeClose: true,
            shade: 0.8,
            area: ['50%', '50%'],
            content: '/index.php/Admin/Wechat/select', //iframe的url
        });
    }

    function selected(img,title,id){
        /*
         <div class="inner" style="height: 70px;border:solid 1px saddlebrown">
         <div class="pull-right">
         <img src="/0.jpg" alt="" width="50" height="50">
         </div>
         <p >New Orders</p>
         </div>
        */
        var selected = $('input[name="img_id"]').val();
        var s = selected.split(',');
        s.pop();
        if($.inArray(id,s) != -1){
            layer.alert('已经存在', {icon: 2});  //alert(alert("已经存在");
            return;
        }
        //判断是否第一条
        var img_id = $('input[name="img_id"]').val();
        if(!img_id){
            $('#first-img').attr('src',img);
            $('#first-text').text(title);
            $('input[name="img_id"]').val(id+',');
        }else{
            var tpl = '';
            tpl = '<div class="inner" style="height: 70px;border:solid 1px saddlebrown">';
            tpl +='<div class="pull-right">';
            tpl = tpl + '<img src="'+img+'" alt="" width="50" height="50">';
            tpl +='</div>';
            tpl = tpl + '<p>'+title+'</p>';
            tpl +='</div>';
            $('.bg-aqua').append(tpl);
            $('input[name="img_id"]').val(img_id+id+',');

        }
        layer.closeAll();
    }
</script>

</body>
</html>