<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/Public/images/b.ico" type="img/x-ico" />
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>首页</title>
    <script src="/Template/pc/default/Static/js/jquery-1.11.0.min.js"></script>
    <!-- Bootstrap -->
    <link href="/Template/pc/default/Static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Template/pc/default/Static/css/style.css" rel="stylesheet">
    <script src="/Public/js/layer/layer.js"></script>
    <script src="/Template/pc/default/Static/js/other.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--<link href="/Template/pc/default/Static/css/zzsc.css" rel="stylesheet" type="text/css"/>-->
    <!--<link href="/Template/pc/default/Static/css/sq.style.css" rel="stylesheet" type="text/css"/>-->

    <script src="/Template/pc/default/Static/js/global_no.js"></script>
    <!--<script src="/Template/pc/default/Static/js/pc_common.js"></script>-->
    <script src="/Template/pc/default/Static/laydate/laydate.js"></script> <!-- 改成你的路径 -->
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/reset.css">
    <script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--<script src="/Template/pc/default/Static/js/other.js"></script>-->
    <!--<script src="/Template/pc/default/Static/js/global_no.js"></script>-->
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/style.css">

    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/bootstrap-switch.css">
    <script src="/Template/pc/default/Static/js/new_js/bootstrap-switch.min.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/plupload.full.min.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/laydate/laydate.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/layer/layer.js"></script>
    <link type="text/css" rel="stylesheet" href="/Template/pc/default/Static/css/new_css/jquery-ui-1.9.2.custom.css">
    <script src="/Template/pc/default/Static/js/other.js"></script>
    <script src="/Template/pc/default/Static/js/global_no.js"></script>
    <link rel="stylesheet" type="text/css" href="/Template/pc/default/Static/js/uploader/webuploader.css">
    <!--引入JS-->

    <script type="text/javascript" src="/Template/pc/default/Static/js/uploader/webuploader.js"></script>
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/comeon.css">
    <script>

        $(function () {
            $('.g_month>.start').hover(function () {
                layer.tips('包涵当前月份，例如选择 2018-2 到 2018-5，则交的是2018年2月1号 到 2018年5月1号之间的社保', $(this), {
                    tips: [1, '#78BA32'],
                    time: 5000
                });
            });
            $('.g_month>.end').hover(function () {
                layer.tips('不包涵当前月份，例如选择 2018-2 到 2018-5，则交的是2018年2月1号 到 2018年5月1号之间的社保', $(this), {
                    tips: [1, '#78BA32'],
                    time: 5000
                });
            });
            $('.g_zuidi').hover(function () {
                layer.tips('点击使用当前城市最小基数', $(this), {
                    tips: [1, '#78BA32'],
                    time: 2000
                });
            });

            $('select[name="city"]').change(function () {
                //n =
                var num = Math.floor(Math.random()*1000);
                var innerH = num.toString()+' 元 ~ '+(num+1234).toString()+' 元';
                $(".g_li>input").attr('placeholder',innerH);
            })
        });


    </script>
    <style>
        .main-content-fun h4{
            color:grey;
            font-weight:blod;
        }
        .g_on_off {
            position: absolute !important;
            left: 600px;
            top: 67px;
        }
        .i_agree {
            margin-left: 100px;
            margin-top: 30px;
            font-size: 15px;
            color: grey;
        }
        .i_agree>label {
            margin-left: 10px;
        }
        .g_wxd {
            margin-bottom: 30px;
        }
        .pop-content-left p{
            margin-top:20px;
        }
        .g_tips{
            border-radius:10px;
        }
        .main-article-tips{
            border-radius:10px;
        }
        /* .g_titel_2>span{
        color:grey;

        }
        .g_in>label{
        color:#333;
        } */
    </style>
    <script type="text/javascript" src="/Template/pc/default/Static/js/new_js/jquery-ui-1.9.2.custom.js" language="javascript"></script>
    <script type="text/javascript" src="/Template/pc/default/Static/js/new_js/share.js"></script>
    <link rel="stylesheet" href="/Template/pc/default/Static/font_awesome/css/font-awesome.min.css">
    <script type="text/javascript" src="/Template/pc/default/Static/js/new_js/share.js"></script>

    <script type="text/javascript">
        var loadIndex;
        $(document).ajaxStart(function(){
            loadIndex=layer.load(1)
        }).ajaxStop(function(){
            layer.close(loadIndex);
        });
    </script>
    <script>
        $(function () {
            var n = 1;
            $(".ggy").bind("click", function () {
                var $html = $("<li class='g_li'><span class='g_name'></span><input class='g_sbjs' type='text'><input class='g_gjjjs' type='text'><button style='margin-left:20px;vertical-align:top;float:left;' class='btn btn-md btn-success g_zuidi' onmouseover='add()'>最低基数</button><a href='#'><span style='width:14px;height:16px;margin-left:20px;' class='glyphicon glyphicon-remove g_delete'></span></a></li>");
                $("#g_put").append($html);
                n++;
            });
            $("#g_put").on("click", ".g_delete", function () {
                $(this).parents("li").remove();
            });
        });
    </script>


    <style type="text/css">
        .ab_left
        {
            /*border: 1px solid #ddd;border-radius:4px;*/
        }
    </style>
</head>
<script src="/Template/pc/default/Static/js/new_js/bootstrap.min.js"></script>
<script>

</script>


<body>



<div class="top_out">
    <div class="container">
        <div class="row top text-center">
            <div class="col-xs-2">
                <img class="logo" src="http://pc.zhongguoshebaodaili.cn/Public/Home/images/logo.png" style="width: 260px;height: 50px;" alt="">
            </div>

            <div class="row col-xs-8 g_nav">

                <?php if(($username == '游客') || ($user_type == 0)): ?><div class="col-xs-2 col-xs-offset-2" style="margin-left: 0px;">
                    <a href="<?php echo U('Home/Checklogin/shebao_dj');?>" <?php if($act == 'shebao_dj'): ?>class="active"<?php else: ?>class=""<?php endif; ?> >个人社保服务</a>
                </div><?php endif; ?>

                <?php if(($username == '游客') ||($user_type == 1)): ?><div class="col-xs-2">
                    <a href="<?php echo U('Home/Checklogin/company_order');?>" <?php if($act == 'company_order'): ?>class="active"<?php else: ?>class=""<?php endif; ?>>企业社保服务</a>
                </div><?php endif; ?>
                <div class="col-xs-2">
                    <a href="<?php echo U('Home/Checklogin/shebao_bujiao');?>" <?php if($act == 'shebao_bujiao'): ?>class="active"<?php else: ?>class=""<?php endif; ?>>社保补缴</a>
                </div>
                <div class="col-xs-2">
                    <a href="<?php echo U('Home/Checklogin/search');?>"  <?php if($act == 'search'): ?>class="active"<?php else: ?>class=""<?php endif; ?>>社保计算器</a>
                </div>
                <div class="col-xs-2 dropdown_out">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            更多服务
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('Home/Checklogin/shebao_zhuanyi');?>">社保转移</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/gjj_zhuanyi');?>">公积金转移</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/gjj_tiqu');?>">住房公积金提取</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/yl_sgz');?>">医疗手工报销</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/sy_shenqing');?>">生育待遇申领</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/yd_bajy');?>">异地就医备案</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/sb_editinfo');?>">社保信息修改</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/own_money');?>">个人所得税申报</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/tx_yanglao');?>">退休养老办理</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/school_info');?>">孩子上学材料</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/rc_yingjin');?>">天津人才引进</a></li>
                        </ul>
                    </div>
                </div>

            <div class="col-xs-2">
                <a href="<?php echo U('Home/Order/index');?>"  <?php if($act == 'index'): ?>class="active"<?php else: ?>class=""<?php endif; ?>>个人中心</a>
            </div>
            </div>
            <div class="col-xs-2 dropdown_out" style="width: 16%;">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                       <?php echo ($username); ?>
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <?php if($username == '游客'): ?><li><a href="<?php echo U('Home/Checklogin/login');?>">登录</a></li>
                            <li><a href="<?php echo U('Home/Checklogin/register');?>">注册</a></li>

                            <?php else: ?>
                            <li class="li2"><a href="<?php echo U('Home/Checklogin/logout');?>">退出</a></li><?php endif; ?>



                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--百度商桥-->
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?dfb8cdc0e8936389353c1a32560fbcb2";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<style>
    label {color: grey;}
</style>
<div class="con3">
    <div class="container m_p_none">
        <div class="ab_left" style="border: 1px solid #ddd;border-radius:10px;    width: 29%;">
    <div class="ab_l_tt" ><i class="fa fa-user-circle-o " aria-hidden="true" style="color: #0a0a0a;"></i>&nbsp;个人中心</div>

    <?php if($user_type == 0): ?><div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/index');?>" <?php if(($act == 'index') or ($act == 'sb_bujiao') or ($act == 'sb_daijiao') or ($act == 'sb_zhuanyi') or ($act == 'gjj_zhuanyi') or ($act == 'gjj_tiqu') or ($act == 'yl_sgz') or ($act == 'sy_shenqing') or ($act == 'yd_bajy') or ($act == 'sb_editinfo')): ?>style="color:red;"<?php endif; ?> > <i class="fa fa-window-maximize " aria-hidden="true" ></i>&nbsp;我的订单</a>
    </div><?php endif; ?>

    <?php if($user_type == 1): ?><div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/company_index');?>" <?php if(($act == 'company_index') or ($act == 'company_info')): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-window-restore " aria-hidden="true" ></i>&nbsp;企业订单</a>
    </div><?php endif; ?>

    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/edit_info');?>" <?php if($act == 'edit_info'): ?>style="color:red;"<?php endif; ?> > <i class="fa fa-address-card " aria-hidden="true" ></i>&nbsp;基本信息修改</a>
    </div>

    <?php if($user_type == 1): ?><div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/company');?>" <?php if($act == 'company'): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-building " aria-hidden="true" ></i>&nbsp;公司信息</a>
    </div>


    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/company_staff');?>" <?php if(($act == 'company_staff') or ($act == 'company_staff_add')): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-users " aria-hidden="true" ></i>&nbsp;员工信息</a>
    </div><?php endif; ?>

    <?php if($user_type == 0): ?><div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/friend_info');?>" <?php if(($act == 'friend_info') or ($act == 'add_friend_info')): ?>style="color:red;"<?php endif; ?> > <i class="fa fa-user " aria-hidden="true" ></i>&nbsp;朋友信息</a>
    </div><?php endif; ?>

    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/account');?>" <?php if($act == 'account'): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-user-plus " aria-hidden="true" ></i>&nbsp; 修改账号信息</a>
    </div>
    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/up_question');?>" <?php if($act == 'up_question'): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-envelope-open-o " aria-hidden="true" ></i>&nbsp; 问题反馈</a>
    </div>
    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/added_service');?>" <?php if($act == 'added_service'): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-hand-paper-o " aria-hidden="true" ></i>&nbsp; 增值服务提报</a>
    </div>
    <div class="ab_l_li" style="text-align: left;padding-left: 35%;">
        <a href="<?php echo U('Home/Order/news');?>" <?php if($act == 'news'): ?>style="color:red;"<?php endif; ?> ><i class="fa fa-comments-o " aria-hidden="true" ></i>&nbsp;我的消息</a>
    </div>
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/shebao_bujiao');?>" <?php if($act == 'shebao_bujiao'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >社保补缴</a>-->
    <!--</div>-->
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/gongjijin_bujiao');?>" <?php if($act == 'gongjijin_bujiao'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >公积金补缴</a>-->
    <!--</div>-->
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/shebao_zhuanyi');?>" <?php if($act == 'shebao_zhuanyi'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >社保转移</a>-->
    <!--</div>-->
   <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/gjj_zhuanyi');?>" <?php if($act == 'gjj_zhuanyi'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >公积金转移</a>-->
    <!--</div>-->
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/gjj_tiqu');?>" <?php if($act == 'gjj_tiqu'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >住房公积金提取</a>-->
    <!--</div>-->
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/yl_sgz');?>" <?php if($act == 'yl_sgz'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >医疗手工报销</a>-->
    <!--</div>-->
    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/sy_shenqing');?>" <?php if($act == 'sy_shenqing'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >生育待遇申领</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/yd_bajy');?>" <?php if($act == 'yd_bajy'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >异地就医备案</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/sb_editinfo');?>" <?php if($act == 'sb_editinfo'): ?>class="on"<?php else: ?>class=""<?php endif; ?> >社保信息修改</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/own_money');?>"  <?php if($act == 'own_money'): ?>class="on"<?php else: ?>class=""<?php endif; ?>>个人所得税申报</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/tx_yanglao');?>"  <?php if($act == 'tx_yanglao'): ?>class="on"<?php else: ?>class=""<?php endif; ?>>退休养老办理</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/school_info');?>"  <?php if($act == 'school_info'): ?>class="on"<?php else: ?>class=""<?php endif; ?>>孩子上学材料</a>-->
    <!--</div>-->

    <!--<div class="ab_l_li">-->
        <!--<a href="<?php echo U('Home/Order/rc_yingjin');?>"  <?php if($act == 'rc_yingjin'): ?>class="on"<?php else: ?>class=""<?php endif; ?>>天津人才引进</a>-->
    <!--</div>-->

    <br>
    <br>
    <br>
    <br>
    <br>
    <!--<div class="ab_l_box">-->
        <!--<div class="ab_lb_top"><img src="">全国联系热线:<br>400-086-4500</div>-->
        <!--<div class="ab_lb_bt"><img src="">售后咨询热线:<br>010-82753969</div>-->
    <!--</div>-->
</div>
        <div class="ab_right" style="border-radius: 10px;border: 1px solid #ddd;">
            <div class="ab_r_tt">
                <span style="display:block; float:left; margin-left:23px; font-size:18px; color:#ae2c26;">修改账号信息</span>
                <span style="float: right" class="nav_xiao"><img src="/Template/pc/default/Static/images/new/homeimg_03.jpg">当前位置：<a href="#">个人中心></a><a style="color:#ae2c26;">修改账号信息</a></span>
            </div>
            <div class="ab_r_cc">
                <div class="row">
                    <!--<hr style="border: 2px solid #ddd;">-->
                    <div class="col-sm-12">
                        <div class="denglu">
                            <div class="denglu_div" style="background-color: #ffffff;width: 90%;border: none;margin: 0px auto;">
                                <form role="form"  method="post" action="<?php echo U('Home/Checklogin/account');?>" onsubmit=" return checkForm();">

                                    <div class="form-group">
                                        <label for="account_name">账户名</label>  <hr style="margin: 0 5px;border: 1px solid #dddddd;margin-bottom: 15px;transform: scaleY(.5);">
                                        <input type="text" class="form-control" id="account_name" placeholder="6-18位数字字母下划线" readonly name="account_name" value="<?php echo ($info["account_name"]); ?>" style='width: 50%;margin-left: 50px;font-family: "Microsoft yahei", "微软雅黑", "Tahoma", "Verdana", "Arial", "sans-serif";font-size: inherit;height:38px;margin-bottom: 10px;'>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">原密码</label>
                                        <hr style="margin: 0 5px;border: 1px solid #dddddd;margin-bottom: 15px;transform: scaleY(.5);">   <input type="text" class="form-control" id="password" placeholder="18位数字字母下划线" name="password" value="" style='width: 50%;margin-left: 50px;font-family: "Microsoft yahei", "微软雅黑", "Tahoma", "Verdana", "Arial", "sans-serif";font-size: inherit;height:38px;margin-bottom: 10px;'>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">新密码</label><hr style="margin: 0 5px;border: 1px solid #dddddd;margin-bottom: 15px;transform: scaleY(.5);">
                                        <input type="text" class="form-control" id="new_password" placeholder="18位数字字母下划线" name="new_password" value="" style='width: 50%;margin-left: 50px;font-family: "Microsoft yahei", "微软雅黑", "Tahoma", "Verdana", "Arial", "sans-serif";font-size: inherit;height:38px;margin-bottom: 10px;'>
                                    </div>
                                    <div class="form-group">
                                        <hr style="margin: 0 5px;border: 1px solid #dddddd;margin-bottom: 15px;transform: scaleY(.5);"> <label for="r_new_password">确认新密码</label>
                                        <input type="text" class="form-control" id="r_new_password" placeholder="18位数字字母下划线" name="r_new_password" value="" style='width: 50%;margin-left: 50px;font-family: "Microsoft yahei", "微软雅黑", "Tahoma", "Verdana", "Arial", "sans-serif";font-size: inherit;height:38px;margin-bottom: 10px;'>
                                    </div>
                            <button type="submit" class="btn btn-success  btn-block"  style="width: 50%;margin-left: 25%;">确定修改</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--<div class="hhh"></div>-->


                </div>

            </div>

        </div>
    </div>
</div>


<script>
    function checkForm() {


        var account_name = $.trim($('#account_name').val());
        var r_new_password = $.trim($('#r_new_password').val());
        var new_password = $.trim($('#new_password').val());
        var password = $.trim($('#password').val());

        var pattern_t = /^[a-zA-Z0-9_]{6,18}$/;
        if ( !pattern_t.test(password)|| !pattern_t.test(new_password)) {
            layer.alert('密码为6-18位数字字母下划线', {icon: 5});
            return false;
        }
        if (new_password != r_new_password) {
            layer.alert('两次密码不一致', {icon: 5});
            return false;
        }

        $.ajax({
            url:"<?php echo U('Home/Order/ajax_account');?>",
            data:{'new_password':new_password,'password':password},
            type:'POST',
            dataType:'json',
            success:function(e){
                if(e.code==1){
                    layer.alert(e.mess, {icon: 6});
                    setTimeout(function(){
                        window.location.href=window.location.href;
                    },2000);

                }else{
                    layer.alert(e.mess, {icon: 5});
                    setTimeout(function(){
                        window.location.href=window.location.href;
                    },2000);

                }
            }

        })

        return false;
    }
</script>
<div class="ft-footer">
    <div class="ft-footer-nav page">
        <div class="ft-footer-nav-l fl">
            <ul class="about-us" >
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/2.html" style="width: 60px;color: #9099a9;text-decoration: none;background-color:transparent;">关于我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/33.html" style="width: 60px;color: #9099a9;text-decoration: none;background-color:transparent;">联系我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/list/index/cid/4.html" style="width: 90px;color: #9099a9;text-decoration: none;background-color:transparent;">大事记</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/16.html" style="width: 90px;color: #9099a9;text-decoration: none;background-color:transparent;">加入我们</a></li>
            </ul>
            <div class="friendly-url" style="width:643px;overflow:hidden;text-align: left;">
                <span style="">相关链接：</span>
                <div style="width:583px; float:right;">
                    <a href="http://www.mohrss.gov.cn/" style="color: #9099a9;text-decoration: none;background-color:transparent;">中华人民共和国人力资源和社会保障部</a>
                    <a href="http://www.spicezee.com/" style="color: #9099a9;text-decoration: none;background-color:transparent;">中国社保网</a>
                    <a href="http://www.bjrbj.gov.cn/" style="color: #9099a9;text-decoration: none;background-color:transparent;">北京市人力资源和社会保障局</a>
                    <a href="http://www.szsi.gov.cn/" style="color: #9099a9;text-decoration: none;background-color:transparent;">深圳市社会保险基金管理局</a>
                    <a href="http://www.12333sh.gov.cn/index.shtml" style="color: #9099a9;text-decoration: none;background-color:transparent;">上海市人力资源和社会保障局</a>
                </div>
            </div>
        </div>
        <div class="ft-footer-nav-r fr">
            <div class="contact fr">
                <h2>400-086-4500</h2>
                <p class="email">
                    <span>hzbs001@163.com</span>
                </p>
                <p class="ads">版权所有(C)2018-2020 慧智博思&nbsp;</p>
            </div>
        </div>
    </div>
</div>
<div class="nav_top" id="nav_top" style="width:50px;height: 50px;" onclick="displayDate()">
    更多服务
</div>
<div class="za" id="za"></div>
<div class="nav_top_div" id="nav_top_div" >
    <div class="glyphicon glyphicon-remove-circle cha" id="cha" onclick="displayDate2()"></div>
    <div class="navs_li2">
        <ul>
            <li><a href="<?php echo U('Home/Checklogin/shebao_bujiao');?>">社保补缴</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/shebao_dj');?>">社保代缴</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/shebao_zhuanyi');?>">社保转移</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/gjj_zhuanyi');?>">公积金转移</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/gjj_tiqu');?>">住房公积金提取</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/yl_sgz');?>">医疗手工报销</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/sy_shenqing');?>">生育待遇申领</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/yd_bajy');?>">异地就医备案</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/sb_editinfo');?>">社保信息修改</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/own_money');?>">个人所得税申报</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/tx_yanglao');?>">退休养老办理</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/school_info');?>">孩子上学材料</a> </li>
            <li><a href="<?php echo U('Home/Checklogin/rc_yingjin');?>">天津人才引进</a> </li>
            <!--<li><a href="#">工作居住证</a> </li>-->
            <!--<li><a href="#">养老退休</a> </li>-->
        </ul>
    </div>
</div>
<script>

</script>