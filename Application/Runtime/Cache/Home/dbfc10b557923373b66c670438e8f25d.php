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



<div class="con3">
    <div class="container">

        </div>
        <div class="ab_right" style="border-radius:10px;">
            <div class="ab_r_tt">
                <span style="display:block; float:left; margin-left:23px; font-size:18px; color:#ae2c26;">服务代理协议</span>
                
            </div>
            <div class="ab_r_cc">
                            <div><?php $info = M('Tips')->find(); echo $info['xieyi']; ?></div>
                

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <!--<tr>-->
                            <!--<td><a href="\">海淀区</a> </td>-->
                            <!--<td><a href="\">通州区</a> </td>-->
                            <!--<td><a href="\">朝阳区</a> </td>-->
                            <!--<td><a href="\">丰台区</a> </td>-->
                        <!--</tr>-->
                        <!--<tr>-->
                            <!--<td><a href="\">西城区</a> </td>-->
                            <!--<td><a href="\">东城区</a> </td>-->
                            <!--<td><a href="\">昌平区</a> </td>-->
                            <!--<td><a href="\">石景山区</a> </td>-->
                        <!--</tr>-->
                        </tbody>
                    </table>
                </div>

                </div>
    </div>
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