<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />

  <title>个人中心</title>

  <!-- Bootstrap -->
  <link href="/Template/pc/default/Static/css/mobile_center_css/bootstrap.min.css" rel="stylesheet">
  <link href="/Template/pc/default/Static/css/mobile_center_css/User.css" rel="stylesheet">
  <script src="/Template/pc/default/Static/js/mobile_center_js/jquery2.14.min.js"></script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="/Template/pc/default/Static/js/mobile_center_js/jquery2.14.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <link rel="stylesheet" href="/Template/pc/default/Static/font_awesome/css/font-awesome.min.css">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>-->
  <!--<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
  <!--<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>-->
  <!--<![endif]-->
</head>
<body class="body_user">
<section>
  <div class="user_top">
    <div class="touxiang"><img src='/Template/pc/default/Static/images/mobile_center_images/zhifu.jpg'> </div>
    <p class="nichen">个人中心</p>
  </div>
</section>
<section>
  <div class="user_div">

    <?php if($user_type == 0): ?><a href="<?php echo U('MobileOrder/my_index');?>"> <p><i class="fa fa-window-maximize " aria-hidden="true" style="color: #ae2c26;"></i> &nbsp; 我的订单<span>&gt;</span></p></a><?php endif; ?>

    <?php if($user_type == 1): ?><a href="<?php echo U('MobileOrder/company_index');?>"> <p><i class="fa fa-window-restore " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;企业订单<span>&gt;</span></p></a><?php endif; ?>

    <a href="<?php echo U('MobileOrder/edit_info');?>"> <p > <i class="fa fa-address-card " aria-hidden="true" style="color: #ae2c26;"></i> &nbsp;  基本信息修改<span>&gt;</span></p></a>

    <?php if($user_type == 1): ?><a href="<?php echo U('MobileOrder/company');?>"> <p > <i class="fa fa-building " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;公司信息<span>&gt;</span></p></a>
    <a href="<?php echo U('MobileOrder/company_staff');?>"> <p > <i class="fa fa-users " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;员工信息<span>&gt;</span></p></a><?php endif; ?>
    <?php if($user_type == 0): ?><a href="<?php echo U('MobileOrder/friend_info');?>"> <p > <i class="fa fa-user " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;朋友信息<span>&gt;</span></p></a><?php endif; ?>
    <a href="<?php echo U('MobileOrder/account');?>"> <p > <i class="fa fa-user-plus " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;修改账号信息<span>&gt;</span></p></a>
    <a href="<?php echo U('MobileOrder/up_question');?>"> <p ><i class="fa fa-envelope-open-o " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;  问题反馈<span>&gt;</span></p></a>
    <a href="<?php echo U('MobileOrder/added_service');?>"> <p> <i class="fa fa-hand-paper-o " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp;  增值服务提报<span>&gt;</span></p></a>
    <a href="<?php echo U('MobileOrder/news');?>"> <p class="boder_none"> <i class="fa fa-comments-o " aria-hidden="true" style="color: #ae2c26;"></i>&nbsp; 我的消息<span>&gt;</span></p></a>
    <br>
    <br>
  </div>
</section>
</body>
</html>