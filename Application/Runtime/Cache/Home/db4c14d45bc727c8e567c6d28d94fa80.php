<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>消息</title>

    <!-- Bootstrap -->
    <link href="/Template/pc/default/Static/css/mobile_center_css/bootstrap.min.css" rel="stylesheet">
    <link href="/Template/pc/default/Static/css/mobile_center_css/zhangmu.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
    <!--<script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->
    <script src="/Template/pc/default/Static/js/mobile_js/jquery.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/Template/pc/default/Static/js/mobile_center_js/jquery2.14.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/Template/pc/default/Static/js/mobile_center_js/jquery2.14.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Template/pc/default/Static/js/mobile_center_js/bootstrap.min.js"></script>
    <script src="/Template/pc/default/Static/js/mobile_center_js/Other.js"></script>
    <link rel="stylesheet" href="/Template/pc/default/Static/font_awesome/css/font-awesome.min.css">
    <script src="/Public/js/layer/layer.js"></script>
</head>
<body>

<!--导航栏-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color: #ffffff;">
    <p class="nav_li nav_li1">
        <a href="<?php echo U('MobileOrder/index');?>">
            <i class="fa fa-angle-double-left fa-lg"></i> 返回</a>
    </p>
    <p class="nav_li nav_title  nav_li2">朋友信息</p>
    <p class="nav_li nav_li3"><a href="<?php echo U('Home/MobileOrder/add_friend_info');?>">添加</a></p>
</nav>

<section class="topheight">
    <div style="margin: 60px auto;background-color: #ffffff;">


        <table class="table table-striped">
            <!--<caption>条纹表格布局</caption>-->
            <thead>
            <tr>
                <th>姓名</th>
                <th>性别</th>
                <th>户口性质</th>
                <th>修改</th>
                <th>删除</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["username"]); ?></td>
                    <td>
                        <?php if($vo["sex"] == 1): ?>男
                        <?php else: ?>
                        女<?php endif; ?></td>
                    <td>      <?php if($vo["nature"] == 1): ?>农村户口
                        <?php else: ?>
                        城镇户口<?php endif; ?></td>
                    <td>
                        <a href="<?php echo U('Home/MobileOrder/add_friend_info',array('user_id'=>$vo['user_id'] ));?>"> <i class="fa fa-edit fa-lg" ></i></a>
                    </td>
                    <td>
                        <i class="fa fa-trash-o fa-lg" onclick="del(this,<?php echo ($vo["user_id"]); ?>);"></i>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    function del(obj,user_id){
        $.ajax({
            url:'<?php echo U("Home/Order/ajax_del");?>',
            type:'post',
            data:{'user_id':user_id},
            dataType:'json',
            success:function(e){
                if(e.code==1){
                   $(obj).parent().parent().remove();
                }else{
                    layer.alert(e.mess, {icon: 5});
                }
                // window.location.reload();
            }
        })
    }
</script>
</body>
</html>