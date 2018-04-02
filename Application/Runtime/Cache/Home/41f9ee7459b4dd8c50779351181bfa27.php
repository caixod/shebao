<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社保计算器</title>
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/reset.css">
    <script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
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
    <script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Template/pc/default/Static/css/sb_css/style.css">
    <link rel="stylesheet" href="/Template/pc/default/Static/css/sb_css/comeon.css">
    <style>
        input,select{
            outline: none;
        }
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
        .title_cout{
            font-size:18px;
            color:#ae2c26;
            border-bottom:1px solid #ccc;
            padding-bottom:20px;
            margin-bottom:10px;
        }
        .p_title{
            color:#c2000b;
            padding-right:10px;
            font-size: 14px;
        }
        .main-content-detail{
            margin-top:30px;
        }
        .sub_form{
            margin-top:7px;
        }
        .money_num{
            display: inline-block;
            width: 200px;
            height: 30px;
            border: 1px solid #e2e1e1;
            margin-right: 10px;
            line-height: 30px;
            text-indent: 10px;
            font-size: 14px;
            color:#333;
            border-radius: 5px;
        }
        .money_num2{
            margin-left:82px;
            margin-top:10px;
        }
        tr td {
            border: 1px solid #999;
        }
        ._sub,._sub2{
            width: 100px;
            height: 32px;
            background: #5cb85c;
            border: none;
            color: #fff;
            font-size: 15px;
            margin-left: 30px;
            border-radius: 4px;
        }
        .main-content-fun-select span{
            width:70px;
            color:#ae2c26;
            font-weight: 700;
            font-size: 14px;
        }
        .dqxl{
            height:30px;
            line-height:30px;
            width:166px;
        }
        .g_padd{
            padding:15px 0 5px;
        }
        .bdbox{
            margin-left:67px;
        }
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
<div class="content clear"  style="width: 100%;">
    <div class="_content2 clear">
        <div class="_left2">
            <ul class="_login">
                <li class="_act li">注册</li>
            </ul>
            <form action="" class="p_login  p_login1" style="font-size: 16px;" id="form1" method="post" >
                <label for="">手机号:</label>
                <input class="input" type="text" name="account_name" id="account_name" value=""><br>
                <label for="">密码:</label>
                <input class="input" type="password" name="pwd" id="pwd" value=""><br>
                <label for="">确认密码:</label>
                <input class="input" type="password" name="r_pwd" id="r_pwd" value="">
                <label for="">验证码:</label>
                <input class="input" type="text"  name="code" id="code" value="" style="width:80px;">
                <div class="_send">发送验证码</div><br>
                <label for="">图片验证码:</label>
                <input class="input input2" type="text" style="width: 80px;" name="check_f" id="check_f" value="">
                <img class="po-ab to0" id="verify_code_img" width="120" height="40" src="<?php echo U('Home/Checklogin/verify');?>"  onclick="verify(this)" /><br>
                <label for="">注册类别:</label>
              <input type="radio" name="user_type" value="0" checked="checked">个人用户注册
              <input type="radio" name="user_type" value="1">企业注册
                <input class="_sub" type="button" onclick="check_feld();" value="注册">
            </form>
        </div>
        <div class="right">
            <div class="main-article">
                <!-- <div class="g_tips">
                    <p>当前已开通服务城市</p>
                    <ul class="g_city">
                        <li>
                            <p>XX省</p>
                            <span> xx 市</span>
                            <span> xx 市</span>
                            <span> xx 市</span>
                        </li>
                    </ul>
                </div> -->
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
<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/diqu.js"></script>
<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/not3.js"></script>
<script>

    $("#one").click(function(){
        $("#one").addClass("_act");
        $("#two").removeClass("_act");
        $(".change_o").addClass("p_login1");
        $(".change_t").removeClass("p_login1");
    });
    $("#two").click(function(){
        $("#two").addClass("_act");
        $("#one").removeClass("_act");
        $(".change_t").addClass("p_login1");
        $(".change_o").removeClass("p_login1");
    });


    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Home&c=Checklogin&a=verify&r='+Math.random());
    }
    function verify_t(){
        $('#verify_code_img_t').attr('src','/index.php?m=Home&c=Checklogin&a=verify&r='+Math.random());
    }

    function check_feld(){
        var account_name=  $.trim($("#account_name").val());
        var pwd=  $.trim($("#pwd").val());
        var r_pwd=  $.trim($("#r_pwd").val());
        var code=  $.trim($("#code").val());
        var check_f=  $.trim($("#check_f").val());

        var reg = /^(\w){6,18}$/;

        var pattern = /^1[34578]\d{9}$/;
        if(account_name=='' || !pattern.test(account_name)){
            layer.alert('请输入正确的手机号', {icon: 2});
            return false;
        }
        if(pwd=='' || !reg.test(pwd)){
            layer.alert('密码为6-18位数字字母下划线', {icon: 2});
            return false;
        }
        if(pwd != r_pwd){
            layer.alert('两次密码不一致', {icon: 2});
            return false;
        }

        if(check_f=='' || code==""){
            layer.alert('请输入验证码', {icon: 2});
            return false;
        }

        $("#form1").submit();

    }



    function check_feld_t(){
        var account_name=  $.trim($("#account_name_t").val());
        var password=  $.trim($("#password_t").val());
        var check_f=  $.trim($("#check_f_t").val());

        var reg = /^(\w){6,18}$/;

        var pattern = /^1[34578]\d{9}$/;
        if(account_name=='' || !pattern.test(account_name)){
            layer.alert('请输入正确的手机号', {icon: 2});
            return false;
        }
        if(password=='' || !reg.test(password)){
            layer.alert('密码为6-18位数字字母下划线', {icon: 2});
            return false;
        }

        if(check_f==''){
            layer.alert('请输入验证码', {icon: 2});
            return false;
        }

        $("#form2").submit();

    }
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
    $(function() {
        if(navigator.userAgent.match(/mobile/i)) {
            $("._right2").css("display","none");
            $("._content2").css("width","96%");
            $("._left2").css("width","100%");
            $(".top_out1").css("display","none");
            $(".ft-footer1").css("display","none");
            $(".top_out2").css("display","block");
            $(".ft-footer2").css("display","block");
            $(".input").css("width","120px");
            $(".input2").css("width","73px");
        }
        $("._send").on("click",function() {
            var account_name=  $.trim($("#account_name").val());
            var pattern = /^1[34578]\d{9}$/;
            if(account_name=='' || !pattern.test(account_name)){
                layer.alert('请输入正确的手机号', {icon: 2});
                return false;
            }
            $.ajax({
                url:"<?php echo U('Home/Checklogin/send_sms');?>",
                type:"post",
                data:{'mobile':account_name},
                dataType:'json',
                success:function(e){

                }
            });
            $("._send").off("click");
            var text=60;
            $("._send").html(text+"s");
            var set=setInterval(function() {
                text-=1;
                $("._send").html(text+"s");
                if(text==0){
                    clearInterval(set);
                    history.go(0);
                }
            },1000)
        })
    })
</script>

<script>

</script>
</html>