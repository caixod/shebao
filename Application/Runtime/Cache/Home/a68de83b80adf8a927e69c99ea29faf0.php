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
    btn-link:hover {text-underline: none;}
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
                <span style="display:block; float:left; margin-left:23px; font-size:18px; color:#ae2c26;">我的订单</span>
                <span style="float: right" class="nav_xiao"><img src="/Template/pc/default/Static/images/new/homeimg_03.jpg">当前位置：<a href="#">个人中心</a>&gt;<a href="" style="color:#ae2c26;">我的订单</a></span>
            </div>
            <div class="ab_r_cc">
                <!--<a href="javascript:history.back();" style="padding-left:90%;font-size: 18px;"> <i class="fa fa-angle-double-left"></i>返回</a>-->
                <div class="row">
              <!--<hr style="border: 2px solid #ddd;">-->
                    <div class="col-sm-12">

                        <div class="denglu">
                            <div class="denglu_div" style="background-color: #ffffff;">
                                <table class="table table-bordered table-striped text-center">
                                  <tr class="text-center">
                                      <th class="text-center">项目名称</th>
                                      <th class="text-center">订单总金额</th>
                                      <th class="text-center">抵扣金额</th>
                                      <th class="text-center">应付金额</th>
                                      <th class="text-center">实付金额</th>
                                      <th class="text-center">状态</th>
                                      <th class="text-center">申办时间</th>
                                      <th class="text-center">查看明细</th>
                                  </tr>

                              <?php if(is_array($shebao_bujiao)): $i = 0; $__LIST__ = $shebao_bujiao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>社保补缴</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?>已支付<?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <!--<td><button type="button" class="btn btn-link" onclick="get_info('sb_bujiao',<?php echo ($vo["id"]); ?>);">查看>></button></td>-->
                                      <td><a href="<?php echo U('Order/sb_bujiao',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_bujiao'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                              <?php if(is_array($sb_daijiao)): $i = 0; $__LIST__ = $sb_daijiao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>社保代缴</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/sb_daijiao',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_daijiao'));?>"  class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                              <?php if(is_array($shebao_zhuanyi)): $i = 0; $__LIST__ = $shebao_zhuanyi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>社保转移</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/sb_zhuanyi',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_zhuanyi'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                              <?php if(is_array($gjj_zhuanyi)): $i = 0; $__LIST__ = $gjj_zhuanyi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>公积金转移</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/gjj_zhuanyi',array('order_sn'=>$vo['order_sn'],'table_name'=>'gjj_zhuanyi'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($gjj_tiqu)): $i = 0; $__LIST__ = $gjj_tiqu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>公积金提取</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/gjj_tiqu',array('order_sn'=>$vo['order_sn'],'table_name'=>'gjj_tiqu'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($yl_sgz)): $i = 0; $__LIST__ = $yl_sgz;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>医疗手工报销</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/yl_sgz',array('order_sn'=>$vo['order_sn'],'table_name'=>'yl_sgz'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($sy_shenqing)): $i = 0; $__LIST__ = $sy_shenqing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>生育待遇申领</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/sy_shenqing',array('order_sn'=>$vo['order_sn'],'table_name'=>'sy_shenqing'));?>" class="btn btn-link"  >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($yd_bajy)): $i = 0; $__LIST__ = $yd_bajy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>异地就医备案</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a  href="<?php echo U('Order/yd_bajy',array('order_sn'=>$vo['order_sn'],'table_name'=>'yd_bajy'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($sb_editinfo)): $i = 0; $__LIST__ = $sb_editinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>社保信息修改</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a  href="<?php echo U('Order/sb_editinfo',array('order_sn'=>$vo['order_sn'],'table_name'=>'sb_editinfo'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($own_money)): $i = 0; $__LIST__ = $own_money;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>个人所得税申报</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a href="<?php echo U('Order/own_money',array('order_sn'=>$vo['order_sn'],'table_name'=>'own_money'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($tx_yanglao)): $i = 0; $__LIST__ = $tx_yanglao;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>退休养老办理</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a  href="<?php echo U('Order/tx_yanglao',array('order_sn'=>$vo['order_sn'],'table_name'=>'tx_yanglao'));?>" class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($school_info)): $i = 0; $__LIST__ = $school_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>孩子上学材料</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a  href="<?php echo U('Order/school_info',array('order_sn'=>$vo['order_sn'],'table_name'=>'school_info'));?>" class="btn btn-link">查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             <?php if(is_array($rc_yingjin)): $i = 0; $__LIST__ = $rc_yingjin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                      <td>天津人才引进</td>
                                      <td><?php echo ($vo["front_total"]); ?></td>
                                      <td><?php echo ($vo["coupon_fee"]); ?></td>
                                      <td><?php echo ($vo["total"]); ?></td>
                                      <td><?php echo ($vo["pay_money"]); ?></td>
                                      <td>
                                          <?php switch($vo["is_pay"]): case "0": ?><font style="color: red;">未支付</font><?php break;?>
                                              <?php case "1": ?><span style="color: lawngreen"> 已支付</span><?php break; endswitch;?>
                                      </td>
                                      <td><?php echo (date('Y-m-d',$vo["add_time"])); ?></td>
                                      <td><a  href="<?php echo U('Order/rc_yingjin',array('order_sn'=>$vo['order_sn'],'table_name'=>'rc_yingjin'));?>"  class="btn btn-link" >查看>></a></td>
                                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!--<div class="hhh" style="height: 3px;"></div>-->
                    <!--<div class="col-sm-12">-->
                        <!--<p class="p_sh">资料提交完成后可在个人中心里面查看订单进度 </p>-->
                    <!--</div>-->

                </div>

            </div>

        </div>
    </div>
</div>
<script src="/Public/layui/layui.js" charset="utf-8"></script>
<script src="/Public/js/layer/layer.js"></script>
<script>

//    var device = layui.device('myapp');
//    if(device.myapp){
//        alert('在我的App环境');
//    }
//    alert(device.myapp);
//    alert(device.ios);
    function get_info(table_name,id) {
        layer.open({
            type: 2,
            title: '查看订单详情',
            shadeClose: true,
//            shade: 0.8,
            area: ['85%', '90%'],
            content: '/index.php?m=Home&c=Order&a='+table_name+'&table_name='+table_name+'&id='+id //iframe的url
        });
    }
</script>

</div>
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