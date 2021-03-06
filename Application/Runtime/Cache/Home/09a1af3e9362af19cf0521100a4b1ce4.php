<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>登录</title>
	<!-- <link rel="stylesheet" href="css/reset.css"> -->
	<script src="/Template/pc/default/Static/js/mobile_js/jquery.min.js"></script>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_login_css/style.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_login_css/comeon.css">
	<script src="/Template/pc/default/Static/js/new_js/layer/layer.js"></script>
</head>
<body>
	<div class="top_out top_out1">
		<div class="container">
			<div class="row top text-center">
				<div class="col-xs-2">
					<img class="logo" src="http://www.zhongguoshebaodaili.cn/Public/Home/images/about_02.gif" width="130" height="50" alt="">
				</div>
				<div class="row col-xs-8 g_nav">
					<div class="col-xs-2 col-xs-offset-2">
						<a href="#" class="active">个人社保服务</a>
					</div>
					<div class="col-xs-2">
						<a href="#">企业社保服务</a>
					</div>
					<div class="col-xs-2">
						<a href="#">社保补缴</a>
					</div>
					<div class="col-xs-2">
						<a href="#">社保计算器</a>
					</div>
					<div class="col-xs-2 dropdown_out">
						<div class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								更多服务
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">服务一</a></li>
								<li><a href="#">服务二</a></li>
								<li><a href="#">服务三</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="top_out2">
		<img class="logo2" src="http://www.zhongguoshebaodaili.cn/Public/Home/images/about_02.gif" width="100%   " alt="">
		<div class="f_right">
			<a href="<?php echo U('Mobile/shebao_dj');?>">个人社保服务</a>
			<a href="<?php echo U('Mobile/company_order');?>">企业社保服务</a>
		</div>
	</div>
	<div class="_content2 clear">
		<div class="_left2">
			<ul class="_login">
				<li class="_act li">个人登录</li>
				<li class="li">企业登录</li>
				<li class="li2">
					<a href="<?php echo U('Mobile/register');?>">请注册</a>
					<a href="<?php echo U('Mobile/forget_login');?>">找回密码</a>
				</li>
			</ul>
			<form action="<?php echo U('Home/Mobile/do_login');?>" class="p_login p_login1 change_o" method="post" id="form1" style="width: 70%;font-size: 16px;">
				<label for="">手机号:</label>
				<input class="input" type="text" name="account_name" id="account_name" value="" style="height: 30px;"><br>
				<label for="">密码:</label>
				<input class="input" name="pwd" id="password"  value=""  type="password" style="height: 30px;"><br>
				<label for="">验证码:</label>
				<input class="input input2" name="check_f" id="check_f" value="" type="text" style="height: 30px;">
				<img class="po-ab to0" id="verify_code_img" width="120" height="40" src="<?php echo U('Home/Checklogin/verify');?>"  onclick="verify(this)" />
				<input class="_sub" type="button" onclick="check_feld();" value="登录">
				<input type="hidden" value="0" name="user_type"/>
			</form>
			<form action="<?php echo U('Home/Mobile/do_company_login');?>" class="p_login  change_t" style="width: 70%;font-size: 16px;" method="post" id="form2">
				<label for="">企业手机号:</label>
				<input class="input" type="text" name="account_name" id="account_name_t" value="" style="height: 30px;"><br>
				<label for="">密码:</label>
				<input class="input" name="pwd" id="password_t"  value=""  type="password" style="height: 30px;"><br>
				<label for="">验证码:</label>
				<input class="input input2" name="check_f" id="check_f_t" value="" type="text" style="height: 30px;">
				<img class="po-ab to0" id="verify_code_img_t" width="120" height="40" src="<?php echo U('Home/Checklogin/verify');?>"  onclick="verify_t(this)" />
				<input class="_sub" type="button" onclick="check_feld_t();" value="登录">
				<input type="hidden" value="1" name="user_type"/>
			</form>
		</div>
		
		<div class="_right2">
			<div class="main-article">
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
	<div class="ft-footer ft-footer1">
        <div class="ft-footer-nav page">
            <div class="ft-footer-nav-l fl">
                <ul class="about-us">
                    <li><a href="#">关于我们</a></li>
                    <li><a href="#">联系我们</a></li>
                    <li><a href="#">新浪微博</a></li>
                    <li><a href="#">加入我们</a></li>
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
                   <h2>400&nbsp;628&nbsp;0101</h2>
                    <p class="email">
                        <span>service@que360.com</span>
                    </p>
                    <p class="ads">版权所有(C)2016-2017欢雀科技&nbsp;粤ICP备15072594号-1</p>
                </div>
            </div>
        </div>
    </div>
    <div class="ft-footer2">
        <div class="ft-footer-nav2">
            <div class="ft-footer-nav-l2 fl2">
                <ul class="about-us2">
                    <li><a href="#">关于我们</a></li>
                    <li><a href="#">联系我们</a></li>
                    <li><a href="#">新浪微博</a></li>
                    <li><a href="#">加入我们</a></li>
                </ul>
                <div class="_url2">
                    <div >
                        <a href="http://www.mohrss.gov.cn/">中华人民共和国人力资源和社会保障部</a>
                        <a href="http://www.spicezee.com/">中国社保网</a>
                        <a href="http://www.bjrbj.gov.cn/">北京市人力资源和社会保障局</a>
                        <a href="http://www.szsi.gov.cn/">深圳市社会保险基金管理局</a>
                        <a href="http://www.12333sh.gov.cn/index.shtml">上海市人力资源和社会保障局</a>
                    </div>
                    <p class="ads2">版权所有(C)2016-2017欢雀科技&nbsp;粤ICP备15072594号-1</p>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
$(function() {
	if(navigator.userAgent.match(/mobile/i)) {  
        $("._right2").css("display","none");
        $("._content2").css("width","96%");
        $("._left2").css("width","100%");
        $(".top_out1").css("display","none");
        $(".ft-footer1").css("display","none");
        $(".top_out2").css("display","block");
        $(".ft-footer2").css("display","block");
        $("._login li").css({
        	"padding":"0",
        	"margin-right":"8px"
        });
        $(".input").css("width","120px");
        $(".input2").css("width","73px");
    }  
    var dom=$("._login .li");
    $.each(dom,function(index,dom) {
    	$(this).on("click",function() {
    		$(this).addClass("_act").siblings().removeClass("_act");
    		$(".p_login").css("display","none");
    		$(".p_login").eq(index).css("display","block");
    	})
    })
})

function verify(){
    $('#verify_code_img').attr('src','/index.php?m=Home&c=Checklogin&a=verify&r='+Math.random());
}
function verify_t(){
    $('#verify_code_img_t').attr('src','/index.php?m=Home&c=Checklogin&a=verify&r='+Math.random());
}

function check_feld(){
    var account_name=  $.trim($("#account_name").val());
    var password=  $.trim($("#password").val());
    var check_f=  $.trim($("#check_f").val());

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
</script>
</html>