<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<title>社保计算</title>
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/reset.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/bootstrap.min.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/mpicker.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/common.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/style.css">
	<script src="/Template/pc/default/Static/js/mobile_js/jquery.min.js"></script>
	<script src="/Template/pc/default/Static/js/mobile_js/bootstrap.min.js"></script>
	<script src="/Template/pc/default/Static/js/other.js"></script>
	<script src="/Template/pc/default/Static/js/global_no.js"></script>
	<script src="/Template/pc/default/Static/js/new_js/layer/layer.js"></script>

</head>
<body>
<div class="container">
    <div class="row top text-center no_margin">
        <div class="col-xs-3">
            <img class="logo" src="http://www.zhongguoshebaodaili.cn/Public/Home/images/about_02.gif" width="100%   " alt="">
        </div>
        <div class="row no_margin col-xs-6 _title" style="width: 30%;">

        </div>

        <div class="col-xs-3 _title" style="width: 40%;">
            <?php if($username == '游客'): ?><a href="<?php echo U('Home/Mobile/login');?>">登录</a>
            <!--<a href="<?php echo U('Home/Checklogin/company_login');?>">企业登录</a>-->
            <a href="<?php echo U('Home/Mobile/register');?>">注册</a>

               <?php else: ?>

               <span><?php echo ($username); ?></span>&nbsp;&nbsp;
                <a href="<?php echo U('Home/Mobile/logout');?>">退出</a><?php endif; ?>
        </div>
    </div>
</div>
<div class="conunt_m">
	<div class="m_title">社保计算器</div>
	<form action="">
		<div class="slide_out">
			<div class="slide2" style="text-align: right;">选择城市：</div>
			<div data-toggle="distpicker" class="dist">
				<label class="sr-only" for="province7">省份</label>
				<select class="form-control"  name="to_province" id="to_province" onChange="get_city_t(this);" style="height: 35px;">
					<option  value="0">请选择</option>
					<?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				<label class="sr-only" for="city7">市区</label>
				<select class="form-control" name="to_city" id="to_city" onchange="to_shebao_jishu();" style="height: 35px;">
					<option  value="0">请选择</option>

				</select>
			</div>
		</div>
		<label for="">
			<span class="slide2">社保缴纳基数：</span>
			<input name="shebao_base" id="shebao_base" class="money_num money_num2 money_num3"   type="text"   onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}" style="height: 30px;" value="">&nbsp;&nbsp;&nbsp;元
		</label>
		<label for="">
			<span class="slide2">公积金缴纳基数：</span>
			<input  class="money_num money_num2 money_num3" type="text" min="1"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}" name="gjj_base" id="gjj_base"  style="height: 30px;" value="">&nbsp;&nbsp;&nbsp;元
		</label>
		<div class="_sub2_out">
			<input type="button" onclick="to_jisuanfee();" value="提交" class="_sub2">
		</div>
	</form>
	<div class="main-content-detail t-countDetail m_table" id="table">
		<table border="0" cellspacing="0" class="sbao_box">
			<tr bgcolor="#F9F9F9" align="center">
				<td height="56" rowspan="2" width="66">户口类别</td>
				<td  colspan='2'>社保</td>
				<td  colspan='2'>公积金</td>
				<td rowspan="2" >企业合计</td>
				<td rowspan="2" >个人合计</td>
				<td rowspan="2" >总合计</td>
			</tr>
			<tr bgcolor="#F9F9F9" align="center">
				<td>企业</td>
				<td>个人</td>
				<td>企业</td>
				<td>个人</td>
			</tr>
			<tr align="center">
				<td height="56">城镇户口</td>
				<td id="v1" ></td>
				<td id="v2"></td>
				<td id="v3" ></td>
				<td id="v4"></td>
				<td id="v5"></td>
				<td id="v6"></td>
				<td id="v7"></td>
			</tr>
			<tr align="center">
				<td height="56">农村户口</td>
				<td id="v16" ></td>
				<td id="v17"></td>
				<td id="v18"></td>
				<td id="v19"></td>
				<td id="v20"></td>
				<td id="v21"></td>
				<td id="v22"></td>
			</tr>
			<tr>
				<td align="center">备注</td>
				<td colspan="15" style="padding:15px; line-height:24px; text-align:left;">	1、北京市：养老基数下限是<?php echo ($info["xian_one_min"]); ?>、失业基数下限是<?php echo ($info["xian_two_min"]); ?>、医疗基数下限是<?php echo ($info["xian_five_min"]); ?>、生育基数下限是<?php echo ($info["xian_three_min"]); ?>、工伤基数下限是<?php echo ($info["xian_four_min"]); ?>，<br /></td>
			</tr>
		</table>
	</div>
</div>
<div class="ft-footer">
    <div class="ft-footer-nav">
        <div class="ft-footer-nav-l fl">
            <ul class="about-us">
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/2.html">关于我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/33.html">联系我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/list/index/cid/4.html">大事记</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/16.html">加入我们</a></li>
            </ul>
            <div class="_url">
                <div >
                    <a href="http://www.mohrss.gov.cn/">中华人民共和国人力资源和社会保障部</a>
                    <a href="http://www.spicezee.com/">中国社保网</a>
                    <a href="http://www.bjrbj.gov.cn/">北京市人力资源和社会保障局</a>
                    <a href="http://www.szsi.gov.cn/">深圳市社会保险基金管理局</a>
                    <a href="http://www.12333sh.gov.cn/index.shtml">上海市人力资源和社会保障局</a>
                </div>
                <p class="ads">版权所有(C)2018-2020慧智博思&nbsp;</p>
            </div>
        </div>
    </div>
</div>
</body>

<script>
    //点击下一步时候，计算出费用
    function to_jisuanfee(){

        var city=$.trim($("#to_city").val());
        var gjj_base=$.trim($("#gjj_base").val());
        var shebao_base=$.trim($("#shebao_base").val());

        if(city==0){
            layer.alert("请选择城市", {icon: 2});
            return false;
        }

        if(shebao_base=="" && gjj_base==""){
            layer.alert("两个基数请至少填写一个", {icon: 2});
            return false;
        }

        $.ajax({
            url:"<?php echo U('Mobile/search_calculate');?>",
            type:'post',
            data:{'city':city,'gjj_base':gjj_base,'shebao_base':shebao_base},
            success:function(data){
                $("#table").html(data);
                // var h = $(document).height()-$(window).height();
                // $(document).scrollTop(h);
                // $(window).scrollTop(0);//返回底部
                // $("html,body").animate({scrollTop:0},500);//返回顶部
            },
            error:function(e){
                layer.alert("服务器内部错误", {icon: 2});
                return false;
            }

        })


//		alert(is_shebao);
//		$("html,body").animate({scrollTop:0},500);//返回顶部
//		$(window).scrollTop(0);//返回底部
    }

    $(function() {
        $('.select-value').mPicker({
            level:2,
            dataJson: city3,
            Linkage:true,
            rows:6,
            idDefault:true,
            splitStr:'-',
            header:'<div class="mPicker-header">请选择参保城市</div>',
            confirm:function(json){
                console.info('当前选中json：',json);
                console.info('【json里有不带value时】');
                console.info('选中的id序号为：', json.ids);
                console.info('选中的value为：', json.values);
            },
            cancel:function(json){
                console.info('当前选中json：',json);
            }
        })
    });
    $(".close").on("click",function() {
        $(this).parent().parent().remove();
    })
</script>
</html>