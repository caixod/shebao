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
    <p class="nav_li nav_title  nav_li2">增值服务提报</p>
    <!--<p class="nav_li nav_li3"><a href="mingxi.html">明细</a></p>-->
</nav>

<section class="topheight">
    <div style="margin: 60px auto;width: 100%;height: auto;"  >


        <form role="form" method="post" action="" id="form1" >
            <div class="form-group" style="width: 70%;margin: 5px 15%;">
                <label for="username">联系人：</label>
                <input type="text" class="form-control" id="username" placeholder="联系人" name="username" value="" style="font-size:15px;">
            </div>
            <div class="form-group" style="width: 70%;margin: 10px 15%;">
                <label for="username">联系电话：</label>
                <input type="text" class="form-control" id="mobile" placeholder="手机号码" name="mobile" value="" style="font-size:15px;">
            </div>
            <div class="form-group" style="width: 70%;margin: 10px 15%;">
                <label for="username">增值服务标题：</label>
                <input type="text" class="form-control" id="title" placeholder="请输入标题" name="title" value="" style="font-size:15px;">
            </div>
            <div class="form-group" style="width: 70%;margin: 10px 15%;">
                <label for="name">增值服务内容</label>
                <textarea class="form-control" rows="3" name="content" id="content" style="font-size:15px;"></textarea>
            </div>

            <button type="button" class="btn btn-success  btn-block" onclick="checkForm();"  style="width: 70%;margin: 10px 15%;">提交</button>
        </form>
    </div>
</section>

<script>
    function checkForm() {

        var title = $.trim($('#title').val());
        var content = $.trim($('#content').val());
        var username = $.trim($('#username').val());
        var mobile = $.trim($('#mobile').val());
        var pattern = /^1[34578]\d{9}$/;

        if (username == '') {
            layer.alert('请输入联系人', {icon: 2});
            return false;
        }
        if (mobile == '' || !pattern.test(mobile)) {
            layer.alert('请输入正确的手机号', {icon: 2});
            return false;
        }
        if (title == ''){
            layer.alert('请输入标题', {icon: 2});
            return false;
        }
        if (content == '') {
            layer.alert('请输入内容', {icon: 2});
            return false;
        }


       $("#form1").submit();
    }
</script>
</body>
</html>