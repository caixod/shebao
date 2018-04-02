<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>个人订单</title>

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
    <p class="nav_li nav_title  nav_li2">个人订单</p>
    <!--<p class="nav_li nav_li3"><a href="<?php echo U('Home/MobileOrder/company_staff_add');?>">添加员工</a></p>-->
</nav>

<section class="topheight">
    <div style="margin: 60px auto;background-color: #ffffff;">

        <table class="table table-bordered table-striped text-center">
            <tr class="text-center">
                <th class="text-center">项目<br>名称</th>
                <th class="text-center">订单<br>总金额</th>
                <th class="text-center">抵扣<br>金额</th>
                <th class="text-center">应付<br>金额</th>
                <th class="text-center">实付<br>金额</th>
                <th class="text-center">状态</th>
                <!--<th class="text-center">申办时间</th>-->
                <th class="text-center">查看<br>明细</th>
            </tr>

            <?php if(is_array($shebao_bujiao)): $i = 0; $__LIST__ = $shebao_bujiao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>社保补缴</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <!--<td><button type="button" class="btn btn-link" onclick="get_info('sb_bujiao',<?php echo ($vo["id"]); ?>);">查看>></button></td>-->
                    <td><a href="<?php echo U('MobileOrder/sb_bujiao',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_bujiao'));?>" class="btn btn-link">查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($sb_daijiao)): $i = 0; $__LIST__ = $sb_daijiao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>社保代缴</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/sb_daijiao',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_daijiao'));?>"  class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            <?php if(is_array($shebao_zhuanyi)): $i = 0; $__LIST__ = $shebao_zhuanyi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>社保转移</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/sb_zhuanyi',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_zhuanyi'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($gjj_zhuanyi)): $i = 0; $__LIST__ = $gjj_zhuanyi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>公积金转移</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/gjj_zhuanyi',array('order_sn'=>$vo['order_sn'],'table_name'=>'gjj_zhuanyi'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($gjj_tiqu)): $i = 0; $__LIST__ = $gjj_tiqu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>公积金提取</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/gjj_tiqu',array('order_sn'=>$vo['order_sn'],'table_name'=>'gjj_tiqu'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($yl_sgz)): $i = 0; $__LIST__ = $yl_sgz;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>医疗手工报销</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/yl_sgz',array('order_sn'=>$vo['order_sn'],'table_name'=>'yl_sgz'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($sy_shenqing)): $i = 0; $__LIST__ = $sy_shenqing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>生育待遇申领</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/sy_shenqing',array('order_sn'=>$vo['order_sn'],'table_name'=>'sy_shenqing'));?>" class="btn btn-link"  >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($yd_bajy)): $i = 0; $__LIST__ = $yd_bajy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>异地就医备案</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a  href="<?php echo U('MobileOrder/yd_bajy',array('order_sn'=>$vo['order_sn'],'table_name'=>'yd_bajy'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($sb_editinfo)): $i = 0; $__LIST__ = $sb_editinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>社保信息修改</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a  href="<?php echo U('MobileOrder/sb_editinfo',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_editinfo'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($own_money)): $i = 0; $__LIST__ = $own_money;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>个人所得税申报</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a href="<?php echo U('MobileOrder/own_money',array('order_sn'=>$vo['order_sn'],'table_name'=>'own_money'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($tx_yanglao)): $i = 0; $__LIST__ = $tx_yanglao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>退休养老办理</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a  href="<?php echo U('MobileOrder/tx_yanglao',array('order_sn'=>$vo['order_sn'],'table_name'=>'tx_yanglao'));?>" class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($school_info)): $i = 0; $__LIST__ = $school_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>孩子上学材料</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a  href="<?php echo U('MobileOrder/school_info',array('order_sn'=>$vo['order_sn'],'table_name'=>'school_info'));?>" class="btn btn-link">查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(is_array($rc_yingjin)): $i = 0; $__LIST__ = $rc_yingjin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>天津人才引进</td>
                    <td><?php echo ($vo["front_total"]); ?></td>
                    <td><?php echo ($vo["coupon_fee"]); ?></td>
                    <td><?php echo ($vo["total"]); ?></td>
                    <td><?php echo ($vo["pay_money"]); ?></td>
                    <td>
                        <?php switch($vo["is_pay"]): case "0": ?>未支付<?php break;?>
                            <?php case "1": ?>已支付<?php break; endswitch;?>
                    </td>
                    <!--<td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>-->
                    <td><a  href="<?php echo U('MobileOrder/rc_yingjin',array('order_sn'=>$vo['order_sn'],'table_name'=>'rc_yingjin'));?>"  class="btn btn-link" >查看>></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

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