<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>支付-</title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<style type="text/css">
*{ margin:0; padding:0}
.wihe-ee{width:560px; height:420px; background:#FFF; padding:25px; color:#666; font-family:song,arial; font-size:14px; box-sizing:border-box; border-radius:6px; margin:0 auto; margin-top:5%}
.wihe-ee p{text-align:center}
.co999{color:#999}
.fo-si-18{font-size:18px}
.fail-fasu{float:left; width:200px; height:180px; padding-top:100px; background:url(/Template/pc/default/Static/images/icon-pay.png) 50px 0 no-repeat; text-align:center}
.success-fasu{float:right; width:200px; height:180px; padding-top:100px; background:url(/Template/pc/default/Static/images/icon-pay.png) -220px 0 no-repeat; text-align:center}
.fail-fasu a:hover{ background-color:#ee9775}
.fail-fasu a{padding:8px 24px; background-color:#f8a584; display:table; margin:0 auto; color:#fff; text-decoration:none; margin-top:10px}
.re-qtzfgg a,.success-fasu a{padding:8px 24px; background-color:#eee; display:table; margin:0 auto; color:#999; text-decoration:none; margin-top:10px}
.re-qtzfgg a{padding:8px 140px}
.re-qtzfgg a:hover,.success-fasu a:hover{background-color:#ddd;}
.fail-success{overflow:hidden; height:185px}
</style>
</head>
<body style="background-color:#666">
	<div class="tac-sd">
    	<div class="wihe-ee" style="width: 700px;">
        	<p>
            	<span class="fo-si-18">请使用支付宝或者微信扫码支付完成付款!</span>
                <br>
                <span class="co999">付款完成前请不要关闭此窗口。完成付款后请根据您的情况点击下面的按钮。</span>
            </p>
            <br>
            <br>
            <div class="fail-success">
            	<div class="fail-fasu">
                	支付完成
                    <br>
                    <a href="<?php echo U('Home/Dopay/success_pay');?>">支付成功</a>
                </div>
                <div class="fail-I-success" style="float:left;margin-left:20px;">
                	<img src="http://pan.baidu.com/share/qrcode?w=150&h=150&url=<?php echo ($code); ?>" width="200" height="200"/>
                </div>
            	<div class="success-fasu">
                	支付遇到问题
                    <br>
                    <a href="<?php echo U('Home/Checklogin/shebao_dj');?>">支付失败</a>
                </div>
            </div>
            <div class="re-qtzfgg">

            </div>
        </div>
    </div>
<lable style="display: none;" id="table" table_name="<?php echo ($table_name); ?>" sn="<?php echo ($order_sn); ?>"></lable>
</body>

<script src="/Template/pc/default/Static/js/jquery-1.11.0.min.js"></script>
<script src="/Template/pc/default/Static/js/other.js"></script>
<script src="/Public/js/layer/layer.js"></script>
<script >
    $(function(){
        var dsq= setInterval(is_pay,3000);

    });
    function is_pay(){
       var  table_name= $("#table").attr('table_name');
       var  sn= $("#table").attr('sn');
        $.ajax({
            url:"<?php echo U('Home/Dopay/ajax_is_pay');?>",
            type : "POST",
            data:{'table_name':table_name,'sn':sn},
            // async:false,  //同步方式
            dataType:'json',
            error: function(request) {
                alert("服务器繁忙!");
                return false;
            },
            success: function(v) {
                if(v.code==1){
                    layer.alert(v.mess, {icon: 6});
                    setTimeout(function(){
                    window.location.href="<?php echo U('Checklogin/shebao_dj');?>";
                    },1000);
                }else{
                }

            }
        });
    }



</script>
</html>