<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社保转移</title>
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/reset.css">
    <script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--<script src="/Template/pc/default/Static/js/other.js"></script>-->
    <!--<script src="/Template/pc/default/Static/js/global_no.js"></script>-->
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/style.css">
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/comeon.css">
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

</head>
<body>
<!--//导航栏-->
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
<!--导航栏end-->
<div class="content clear">
    <form action="<?php echo U('Checklogin/shebao_zhuanyi');?>" method="post" id="form1" >
        <div class="left">

            <div class="main-content-fun">
                <h4>社保转移办理</h4>
                <div class="main-content-fun-select g_padd new">
                    <h4>选择转出城市</h4>
                    <span>选择城市：</span>
                    <div class="bdbox">
                        <div class="xlbox">

                            <select class="dqxl" name="province" id="province" onChange="get_all_city(this);">
                                <option  value="0">请选择</option>
                                <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <select class="dqxl" name="city" id="city" onchange="get_area();" >
                                <option  value="0">请选择</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="main-content-fun-select g_padd new">
                    <h4>选择转入城市</h4>
                    <span>选择城市：</span>
                    <div class="bdbox">
                        <div class="xlbox">
                            <select class="dqxl" name="to_province" id="to_province" onChange="get_all_city_t(this);">
                                <option  value="0">请选择</option>
                                <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <select class="dqxl" name="to_city" id="to_city" onchange="is_lock();">
                                <option  value="0">请选择</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="main-content-fun-select g_padd new">
                    <h4>办理人员</h4>
                    <span>选择办理人：</span>
                    <div class="bdbox">
                        <div class="xlbox">
                            <select class="dqxl" name="user_id" id="user_id">
                                <option  value="0">请选择</option>
                                <?php if(is_array($friend)): $i = 0; $__LIST__ = $friend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["user_id"]); ?>"><?php echo ($p["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="main-content-fun-select g_padd new">
                    <h4>订单备注</h4>

                    <div class="bdbox">
                        <div class="xlbox">
                            <textarea rows="5" cols="50" style="margin-left: 20%;" name="mark"></textarea>
                        </div>
                    </div>
                </div>

                <!--<div class="main-content-fun-insuredPer g_re">-->
                    <!--<span>选择参保人：</span>-->
                    <!--<button class="btn btn-md btn-success" data-toggle="modal" data-target="#myModal">-->
                        <!--&lt;!&ndash; <label title="成龙">成龙<i>&times;</i></label>-->
                        <!--<label title="洪金宝">洪金宝<i>&times;</i></label>-->
                        <!--<label title="元彪">元彪<i>&times;</i></label> &ndash;&gt;-->
                        <!--添加参保人-->
                    <!--</button>-->

                <!--</div>-->

                <div class="main-content-fun-tips new" style="height: 10px;">
                    <h4></h4>

                </div>
            <div style="width:80%;height:50px;border: 1px solid #ccc;border-radius: 5px;margin: 1px auto;background-color: #ffecc7;">
                <p>特别提示:</p>
                <div>
                    1、 因客户自身原因（未了解清楚规则、无故撤单）退费的，服务费不予退还！ </div>
            </div>
                <div class="i_agree">
                    <input type="checkbox" id="agree" style="margin-top:6px" checked="checked"><label for="agree">我已阅读并同意<a href="" >《服务代理协议》</a></label>
                </div>
                <!--<div class="g_button">-->
                    <!--<button  type="button" onclick="to_jisuanfee();" class="btn btn-lg btn-success now_buy">下一步</button>-->
                    <!--&lt;!&ndash;<button class="btn btn-lg btn-success">计算明细</button>&ndash;&gt;-->
                <!--</div>-->
            </div>


            <div class="g_button">

                <button type="button" id="submit_order" onclick="check_field();"  class="btn btn-lg btn-success now_buy">确认支付</button>

            </div>
        </div>
    </form>
    <div class="right">
        <div class="main-article">
            <div class="g_tips">
                <p>当前已开通服务城市</p>

                <ul class="g_city">
                    <?php if(is_array($area_list)): foreach($area_list as $k=>$vo): ?><li>
                            <p><?php echo ($k); ?></p>
                            <?php if(is_array($vo)): foreach($vo as $key=>$v): ?><span><?php echo ($v["name"]); ?></span><?php endforeach; endif; ?>
                        </li><?php endforeach; endif; ?>
                </ul>

            </div>
            <div class="main-article-tips">
                <div class="default">
                    <h4>社保小贴士</h4>
                    <p>请选择您的参保城市</p>
                    <p>根据您选择的参保城市，提供以下信息：</p>
                    <p>1、下单截止日期</p>
                    <p>2、参保规则说明</p>
                    <p>3、需要提供的参保资料</p>
                    <p>4、服务费收取规则</p>
                </div>
                <div class="social_tips">
                    <p>特别提示:</p>
                    <div>
                        1、 因客户自身原因（未了解清楚规则、无故撤单）退费的，服务费不予退还！<br>
                        2、不承接现已怀孕、重病等特殊人员的社保代缴业务。如客户隐瞒孕情、病情下单，我司无法为其办理相应的社保待遇。如有生育计划，请在孕前3个月，即生育前13个月提前购买社保。<br>
                        3、关于生育待遇的申领，我司仅承接异地分娩，生育备案，医疗报销等业务。涉及生育津贴、产假工资的申领我司概不接受。<br>
                        4、首次支付时系统会提示上传身份证正反面材料，填写好个人信息支付订单后，我司会有人跟进，如后续需要其它材料补充，我司会再联系您。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade g_alert" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="g_title">
            <label>选择参保人</label>
            <i class="e-closePop" data-dismiss="modal">×</i>
        </div>
        <div>
            <ul>
                <li class="g_box" data-toggle='modal' id="btn2">
                    <a href="javascript:;"><span>+</span> 新增参保人</a>
                </li>
            </ul>
        </div>
        <div class="alert_footer">
            <button type="button" class="btn btn-lg btn-success">确定</button>
            <button type="button" class="btn btn-lg btn-success" data-dismiss="modal">取消</button>
        </div>
    </div>
    <div class="modal fade g_alert2" id='show2'>
        <div class="modal-dialog g_rela">
            <div class="g_title">
                <label>1. 新增参保人</label>
                <i class="e-closePop g_close">×</i>
            </div>
            <form id="new_person" action="<?php echo U('Checklogin/sb_add_user');?>">
                <div class="pop-content">
                    <div class="gg">
                        <p>
                            <input style="width:180px;" type="text" name="name" placeholder="姓名">
                            <!-- <label class="red error">* 请输入姓名</label> -->
                        </p>
                        <p>
                            <input style="width:180px;" type="text" name="mobile" placeholder="手机号码">
                            <!-- <label class="red error">* 请输入手机号</label> -->
                        </p>
                        <p>
                            <input style="width:180px;" type="text" name="card_no" placeholder="身份证号">
                            <!-- <label class="red error">* 请输入身份证号</label> -->
                        </p>
                    </div>
                    <div>
                        <p class="g_titel_2">
                            <span>2. 户口类型</span>
                        </p>
                        <div class="g_in g_wxd">
                            <!-- <span>户口类型：</span> -->
                            <input type="radio" id="nc" name="khh"><label for="nc">农村</label>
                            <input type="radio" id="cs" name="khh"><label for="cs">城市</label>
                        </div>
                    </div>
                    <div>
                        <p class="g_titel_2">
                            <span>3. 开户行</span>
                        </p>
                        <div class="g_in">
                            <!-- <span>开户行：</span> --><input type="text" placeholder="请输入开户行名称">
                        </div>
                        <div class="g_in">
                            <!-- <span>开户行卡号： --></span><input type="text" placeholder="请输入开户行卡号">
                        </div>
                    </div>
                    <div class="pop-content-left">
                        <p class="upload">
                            <label>上传证件：</label>
                            <label for="ID" id="ID-font" style="position: relative; z-index: 1;margin-left:10px"><span class="card-front-face"><input type="file" id="picker" name=""></span></label>
                            <label for="ID" id="ID-back" style="position: relative; z-index: 1;"><span class="card-front-back">身份证反面</span></label>
                            <label class="red error">* 请上传证件</label>
                        <div id="html5_1c33g07041bn517u0klf5e2ab23_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 0px; height: 0px; overflow: hidden; z-index: 0;"><input id="html5_1c33g07041bn517u0klf5e2ab23" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,.jpg,image/gif,.gif,image/png,.png"></div><div id="html5_1c33g0707m7ght9cqq7ssq1d6_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 0px; height: 0px; overflow: hidden; z-index: 0;"><input id="html5_1c33g0707m7ght9cqq7ssq1d6" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,.jpg,image/gif,.gif,image/png,.png"></div>
                        </p>
                    </div>
                    <div class="pop-content-right e-registry g_abso">
                        <div class="pop-content-tips">
                            <p>温馨提示：</p>
                            <p>
                                1、身份证扫描件照片单张不大于2M。身份证扫描照片需清晰可见；
                            </p>
                            <p>2、以原尺寸扫描件为佳，拍照照片需保证边框与证件边缘贴合。</p>
                        </div>
                    </div>
                </div>
                <div class="alert_footer">
                    <button type="submit" class="btn btn-lg btn-success">确定</button>
                    <button type="button" class="btn btn-lg btn-success g_quxiao">取消</button>
                </div>

            </form>
        </div>
    </div>
</div>
<span id="is_lock" is_lock="<?php echo ($is_lock); ?>"></span>
<div class="ft-footer">
    <div class="ft-footer-nav page">
        <div class="ft-footer-nav-l fl">
            <ul class="about-us">
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/2.html" >关于我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/33.html">联系我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/list/index/cid/4.html">大事记</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/16.html">加入我们</a></li>
            </ul>
            <div class="friendly-url" style="width:643px;overflow:hidden;">
                <span>相关链接：</span>
                <div style="width:583px; float:right;">
                    <a href="http://www.mohrss.gov.cn/">中华人民共和国人力资源和社会保障部</a>
                    <a href="http://www.spicezee.com/">中国社保网</a>
                    <a href="http://www.bjrbj.gov.cn/">北京市人力资源和社会保障局</a>
                    <a href="http://www.szsi.gov.cn/">深圳市社会保险基金管理局</a>
                    <a href="http://www.12333sh.gov.cn/index.shtml">上海市人力资源和社会保障局</a>
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
<script>

</script>
</body>

<script src="/Template/pc/default/Static/js/new_js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/diqu.js"></script>-->
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/not3.js"></script>-->
<script>
    $(function(){

        $("#btn2").click(function(){

            $("#show2").modal("show");
        });
        $(".g_quxiao").click(function(){
            $("#show2").modal("hide");
        })
        $(".g_close").click(function() {
            $("#show2").modal("hide");
        });
    })

</script>
<script>
    $(document).ready(function () {
        //alert($('#my_sb_Switch').attr('checked'));
        //alert($('#my_gjj_Switch').attr('checked'));

        $('#mss').click(function () {
            if($('#my_sb_Switch').attr('checked') == 'checked'){
                $('#my_sb_Switch').attr('checked',false);
                $('#date1').attr('disabled','disabled');
                $('#date2').attr('disabled','disabled');

            }else{
                $('#my_sb_Switch').attr('checked','checked');
                $('#date1').attr('disabled',false);
                $('#date2').attr('disabled',false);
            }


        });

        $('#mgs').click(function () {
            if($('#my_gjj_Switch').attr('checked') == 'checked'){
                $('#my_gjj_Switch').attr('checked',false);
                $('#date3').attr('disabled','disabled');
                $('#date4').attr('disabled','disabled');
            }else{
                $('#my_gjj_Switch').attr('checked','checked');
                $('#date3').attr('disabled',false);
                $('#date4').attr('disabled',false);
            }
        });


        //开发中提示
        /*$("a").click(function () {
            if($(this).attr("href") == '#'){
                alert('开发中...敬请期待');
            }
        });*/

    });
</script>
<script>

    function is_lock(){
        var is_lock=$("#is_lock").attr("is_lock");
        if(is_lock==1){
            layer.alert("请先完善个人信息", {icon: 2});
            setInterval(function(){window.location.href="<?php echo U('Home/Order/edit_info');?>";}, 2000);
            return false;
        }
        return true;
    }
    //点击去支付，提交表单，验证字段
    function check_field(){


        var to_city=$("#to_city").val();
        var city=$("#city").val();
        var user_id=$("#user_id").val();
        var agree=$("#agree").is(":checked");
      // alert(agree);

        if(agree==false){
            layer.alert("不同意代办协议将无法为您服务", {icon: 2});
            // $("html,body").animate({scrollTop:0},500);//返回顶部
            return false;
        }
        if(city==0){
            layer.alert("请选择要转出的城市", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
            return false;
        }
        if(to_city==0){
            layer.alert("请选择要转入的城市", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
            return false;
        }
        if(user_id==0){
            layer.alert("请选择要办理此服务的用户", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
            return false;
        }

        $.ajax({
            url:"<?php echo U('Checklogin/get_jishu');?>",
            type:'post',
            data:{'city':to_city},
            dataType:'json',
            async: false,
            success:function(data){
               if(data.code==1){
                   var index=layer.confirm('订单的服务费为'+data.data.sb_zhuanyi, {
                       btn: ['确认','取消'] //按钮
                   }, function(index){

                     layer.close(index);
                       $("#form1").submit();
                     // return true;
                   }, function(){
                       layer.close();
                   });
               }else{
                   layer.alert("参数错误,请重试", {icon: 2});
                   return false;
               }
            },
            error:function(e){
                layer.alert("服务器内部错误", {icon: 2});
                return false;
            }

        });


        return false;
    }

    function get_all_city(t){

        var parent_id = $(t).val();
        if(!parent_id > 0){
            return;
        }
        $('#twon').empty().css('display','none');
        //var url = '/index.php?m=Home&c=Api&a=getRegion&level=2&parent_id='+ parent_id;
        var url = '/index.php?m=Home&c=Api&a=getAllRegion&level=2&flag=1&parent_id='+ parent_id;
        $.ajax({
            type : "GET",
            url  : url,
            error: function(request) {
                alert("服务器繁忙, 请联系管理员!");
                return;
            },
            success: function(v) {
                v = '<option value="0">选择城市</option>'+ v;
                $('#city').empty().html(v);
            }
        });
    }

    //获取所有城市
    function get_all_city_t(t){

        var parent_id = $(t).val();

        if(!parent_id > 0){
            return;
        }
        $('#twon').empty().css('display','none');

        //var url = '/index.php?m=Home&c=Api&a=getRegion&level=2&parent_id='+ parent_id;
        var url = '/index.php?m=Home&c=Api&a=getAllRegion&flag=1&level=2&parent_id='+ parent_id;

        $.ajax({
            type : "GET",
            url  : url,
            error: function(request) {
                alert("服务器繁忙, 请联系管理员!");
                return;
            },
            success: function(v) {
                v = '<option value="0">选择城市</option>'+ v;
                $('#to_city').empty().html(v);
            }
        });
    }


    //执行一个laydate实例
    laydate.render({
        elem: '#date1' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date2' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date3' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date4' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });

    $("#to_top").click(function(){
        $("html,body").animate({scrollTop:0},500);//返回顶部
    })
</script>
</html>