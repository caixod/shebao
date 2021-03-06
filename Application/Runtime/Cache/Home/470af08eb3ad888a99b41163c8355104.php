<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>信息修改</title>

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
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Template/pc/default/Static/js/mobile_center_js/bootstrap.min.js"></script>
    <script src="/Template/pc/default/Static/js/mobile_center_js/Other.js"></script>
    <link rel="stylesheet" href="/Template/pc/default/Static/font_awesome/css/font-awesome.min.css">
    <script src="/Public/js/layer/layer.js"></script>
</head>
<body>

<!--导航栏-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <p class="nav_li nav_li1">
        <a href="<?php echo U('MobileOrder/index');?>">
            <i class="fa fa-angle-double-left fa-lg"></i> 返回</a>
    </p>
    <p class="nav_li nav_title  nav_li2">基本信息修改</p>
    <!--<p class="nav_li nav_li3"><a href="mingxi.html">明细</a></p>-->
</nav>

<section class="topheight">
    <div style="margin: 60px auto;width: 100%;height: auto;"  >


        <form role="form" method="post" action=""  enctype="multipart/form-data" id="form1">

            <div class="form-group" style="width: 70%;margin: 5px 15%;">
                <label for="username">姓名：</label>
                <input type="text" class="form-control" id="username" placeholder="请输入姓名" name="username" value="<?php echo ($info["username"]); ?>" style="font-size:15px;">
                <label for="mobile">联系电话：</label>
                <input type="text" class="form-control" id="mobile" placeholder="联系电话" name="mobile" value="<?php echo ($info["mobile"]); ?>" style="font-size:15px;">
                <label for="mobile">身份证号：</label>
                <input type="text" class="form-control" id="idcard" placeholder="身份证号码" name="idcard" value="<?php echo ($info["idcard"]); ?>" style="font-size:15px;">
                <label for="mobile">卡号：</label>
                <input type="text" class="form-control" id="bank_num" placeholder="首次办理社保用户必填" name="bank_num" value="<?php echo ($info["bank_num"]); ?>" style="font-size:15px;" >
                <label for="mobile">开户行：</label>
                <input type="text" class="form-control" id="bank_name" placeholder="首次办理社保用户必填" name="bank_name" value="<?php echo ($info["bank_name"]); ?>" style="font-size:15px;">
            </div>

            <div class="form-group" style="width: 70%;margin: 5px 15%;">
                <label for="mobile">性别：</label>
                <label class="radio-inline">
                    <input type="radio" name="sex" <?php if($info["sex"] == 1): ?>checked="checked"<?php endif; ?>  value="1" >男
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" <?php if($info["sex"] == 2): ?>checked="checked"<?php endif; ?>   value="2"> 女
                </label>
            </div>
            <div class="form-group" style="width: 70%;margin: 5px 15%;">
                <label for="mobile">户口性质：</label>
                <label class="radio-inline">
                    <input type="radio" name="nature" id="nature" value="1"  <?php if($info["nature"] == 1): ?>checked="checked"<?php endif; ?>  >农村
                </label>
                <label class="radio-inline">
                    <input type="radio" name="nature" id="optionsRadios4"  value="2"   <?php if($info["nature"] == 2): ?>checked="checked"<?php endif; ?> >  城镇
                </label>
            </div>
            <div class="form-group" style="width: 70%;margin: 5px 15%;">
                <label class="" for="image">上传身份证正面：</label><br>
                <input type="file" name="image" value="" id="image" style="display: inline-block;width: 50%;" >


                <?php if(!empty($info['image'])): ?><a href="<?php echo ($info["image"]); ?>" ><i class="fa fa-link"></i> 查看</a><?php endif; ?>
                <br>
                <label class=""  for="image_t">上传身份证反面：</label><br>
                <input type="file" name="image_t" value="" id="image_t"  style="display: inline-block;width: 50%;" >
                <?php if(!empty($info['image_t'])): ?><a href="<?php echo ($info["image_t"]); ?>" ><i class="fa fa-link"></i> 查看</a><?php endif; ?>
            </div>

            <input type="hidden" name="id" value="<?php echo ($info["user_id"]); ?>">            <button type="button" class="btn btn-success  btn-block" onclick="checkForm();" style="width: 70%;margin: 15px 15%;">保存</button>
        </form>
    </div>
</section>

<script>
    function checkForm() {

        var username = $.trim($('#username').val());
        var mobile = $.trim($('#mobile').val());

        var idcard = $.trim($('#idcard').val());
        var pattern = /^1[34578]\d{9}$/;
        if (username == '') {
            layer.alert('请输入您的姓名', {icon: 2});
            return false;
        }
        if (mobile == '' || !pattern.test(mobile)) {
            layer.alert('请填写正确的电话号码', {icon: 2});
            return false;
        }
        var pattern_idcard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if (idcard == '' || !pattern_idcard.test(idcard)) {
            layer.alert('请填写正确的身份证号', {icon: 2});
            return false;
        }

       $("#form1").submit();
    }
</script>
</body>
</html>