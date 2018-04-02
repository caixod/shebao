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
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i>社保信息列表</h3>
            <div class="box-header">
                <!--<nav class="navbar navbar-default">-->
                    <!--<div class="collapse navbar-collapse">-->
                        <!--<div class="navbar-form row">-->
                            <!--<div class="col-md-10">-->
                                <!--&lt;!&ndash;<button class="btn bg-navy" type="button" onclick="tree_open(this);"><i class="fa fa-angle-double-down"></i>展开</button>-->
                            <!--</div>-->
                            <!--<div class="col-md-9">-->
                                <!--<span class="warning">温馨提示：顶级分类（一级大类）设为推荐时才会在首页楼层中显示</span>&ndash;&gt;-->
                            <!--</div>-->
                            <!--&lt;!&ndash;<div class="col-md-2">&ndash;&gt;-->
                                <!--&lt;!&ndash;<a href="<?php echo U('Manage/area_new_add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>新增地区</a>&ndash;&gt;-->
                            <!--&lt;!&ndash;</div>&ndash;&gt;-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</nav>-->
            </div>
        </div>

        <div class="panel-body">    

                        
          <div id="ajax_return"> 
                 
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center" rowspan="2">ID</th>
                                <th class="sorting text-center" rowspan="2">省</th>
                                <th class="sorting text-center" rowspan="2">市</th>
                                <th class="sorting text-center"  rowspan="2">养老保险比例<br>个人|单位</th>
                                <th class="sorting text-center"  rowspan="2">失业保险<br>个人|单位</th>
                                <th class="sorting text-center"  rowspan="2">生育保险<br>个人|单位</th>
                                <th class="sorting text-center"  rowspan="2">工伤保险<br>个人|单位</th>
                                <th class="sorting text-center"  rowspan="2">医疗保险<br>个人|单位</th>

                                <th class="sorting text-center"  rowspan="2">操作</th>
                            </tr>
                            <tr>
                                <!--<th class="sorting text-center">ID</th>-->
                                <!--<th class="sorting text-center">省</th>-->
                                <!--<th class="sorting text-center">市</th>-->
                                <!--<th class="sorting text-center">个人|单位</th>-->
                                <!--<th class="sorting text-center">个人|单位</th>-->
                                <!--<th class="sorting text-center">个人|单位</th>-->
                                <!--<th class="sorting text-center">个人|单位</th>-->
                                <!--<th class="sorting text-center">个人|单位</th>-->

                                <!--<th class="sorting text-center">操作</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($area_list)): $k = 0; $__LIST__ = $area_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($k % 2 );++$k;?><tr>
                                    <td class="text-center"><?php echo ($k); ?></td>
                                    <td class="text-center"><?php echo ($list["province"]); ?></td>
                                    <td class="text-center"><?php echo ($list["city"]["name"]); ?></td>
                                    <td class="text-center">
                                        <?php echo ($list["city"]["xian_one"]); ?>% | <?php echo ($list["city"]["c_xian_one"]); ?>%
                                    </td>
                                    <td class="text-center">
                                        <?php echo ($list["city"]["xian_two"]); ?>% | <?php echo ($list["city"]["c_xian_two"]); ?>%
                                    </td>

                                      <td class="text-center">
                                        <?php echo ($list["city"]["xian_three"]); ?>% | <?php echo ($list["city"]["c_xian_three"]); ?>%
                                    </td>
                                      <td class="text-center">
                                        <?php echo ($list["city"]["xian_four"]); ?>% | <?php echo ($list["city"]["c_xian_four"]); ?>%
                                    </td>
                                      <td class="text-center">
                                        <?php echo ($list["city"]["xian_five"]); ?>% | <?php echo ($list["city"]["c_xian_five"]); ?>%
                                    </td>

                                    <td class="text-center">
                                        <a href="<?php echo U('Admin/Manage/sb_edit',array('id'=>$list['id']));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!--<a href="javascript:void(0);" onclick="del('<?php echo ($list[id]); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>-->
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                
                <div class="row">
                    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right"><?php echo ($show); ?></div>
                </div>
          
          </div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
 <script>
 // 删除操作 Admin/Manage/area_add
function del(id)
{
    layer.msg('如果要删掉本地区的社保信息,直接删掉该地区即可', {icon: 2,time: 3000}); //alert(v.msg);
    location.href='<?php echo U("Admin/Manage/area_list");?>';
//	if(!confirm('确定要删除吗?'))
//		return false;
//		$.ajax({
//			url:"/index.php?m=Admin&c=Manage&a=sb_del&id="+id,
//            dataType:'json',
//            type:'get',
//			success: function(v){
//                layer.msg(v.msg, {icon: 2,time: 3000}); //alert(v.msg);
//                location.href='<?php echo U("Admin/Manage/sb_list");?>';
//
//			},
//            error:function(e){
//                layer.msg('错误……', {icon: 2,time: 3000}); //alert(v.msg);
//                location.href='<?php echo U("Admin/Manage/sb_list");?>';
//            }
//		});
	 return false;
}
 

//修改指定表的指定字段值
function changeBrandField(field,id,obj)
{
 
     var isshow = $(obj).data('isshow');
     if(isshow == 1)
     {
         $(obj).data('isshow','0');    
         var value = 0;
         $(obj).attr('src','/Public/images/cancel.png');
         
     }else{
         $(obj).data('isshow','1');
         var value = 1;
         $(obj).attr('src','/Public/images/yes.png');
     }    
     
     $.ajax({
             url:'/index.php?m=Admin&c=goods&a=changeBrandField&field='+field+'&id='+id+'&value='+value,			
             success: function(data){					                                                                      
                     //  
             }
     });		
     
}
 </script>
</body>
</html>