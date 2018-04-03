<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>个人社保代缴</title>
	<!--<link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/reset.css">-->
	<script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
	<!--<script src="/Template/pc/default/Static/js/other.js"></script>-->
	<!--<script src="/Template/pc/default/Static/js/global_no.js"></script>-->
	<link href="/Template/pc/default/Static/css/uploader_css/uploader.css" rel="stylesheet">
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
	<script src="/Template/pc/default/Static/js/uploader_js/uploader.1.2.js" ></script>
	<script>

        $(function () {
            $('.g_month>input[type="text"]').hover(function () {
                layer.tips('包涵当前月份，例如选择 2018-2 到 2018-5，则交的是2018年2月1号 到 2018年5月1号之间的社保', $(this), {
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


		.upl { clear: both; }
		.upl p { width: 100px; height: 100px; line-height: 100px; text-align: center; float: left; margin-right: 15px; background-color: #fff; border-radius: 3px; border: 1px solid #ccc; }
		.upl img { max-width: 80px; max-height: 80px; vertical-align: middle; }
		.selfile { margin-bottom: 10px; }
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
		<form action="<?php echo U('Checklogin/shebao_dj');?>" onsubmit="return check_field();" method="post" >
		<div class="left">

			<div class="main-content-fun">
                <h4>社保公积金代缴</h4>
                <div class="main-content-fun-select g_padd new">
                	<h4>参保城市</h4>
                    <span>选择城市：</span>
                   <div class="bdbox">
				      <div class="xlbox">
						  <select class="dqxl" name="to_province" id="to_province" onChange="get_city_t(this);">
							  <option  value="0">请选择</option>
							  <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						  </select>
						  <select class="dqxl" name="to_city" id="to_city" onchange="to_shebao_jishu();" >
							  <option  value="0">请选择</option>
						  </select>
				      </div>
				    </div>
                </div>
                <ul id="g_put" class="main-content-fun-social on new">
                	<h4>参保人员</h4>
                	<!-- <div class="g_btn">
                		<button class="btn btn-md btn-success ggy">添加</button>
                	</div> -->
                    <li class="g_li" style="font-size: 18px;">
                    	<p style="padding-left:20px;">姓&nbsp;&nbsp;&nbsp;名</p>
                    	<p>社保基数</p>
                    	<p>公积金基数</p>
                    </li>
				<?php if(is_array($friend)): $k = 0; $__LIST__ = array_slice($friend,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="g_li had_user" user_id="<?php echo ($vo["user_id"]); ?>">
						<span class="g_name" style="color: gray;"><?php echo ($vo["username"]); ?></span>
						<input class="g_sbjs" type="text" name="shebao_jishu[<?php echo ($vo["user_id"]); ?>]" placeholder="" value="" user_id="<?php echo ($vo["user_id"]); ?>"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}">
						<input class="g_gjjjs" type="text" name="gjj_jishu[<?php echo ($vo["user_id"]); ?>]" placeholder="" value="" user_id="<?php echo ($vo["user_id"]); ?>"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}">
						<span style="margin-left:20px;vertical-align:top;float:left;cursor:pointer;color:#4cae4c" class="g_zuidi" onclick="add(this)">使用最低基数</span>
						<a href="#">
							<span style="width:14px;height:16px;margin-left:20px;" class="glyphicon glyphicon-remove g_delete"></span>
						</a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
                <div class="main-content-fun-insuredPer g_re">
                    <span>选择参保人：</span>
                    <a class="btn btn-md btn-success" data-toggle="modal" data-target="#myModal">
                        <!-- <label title="成龙">成龙<i>&times;</i></label>
                        <label title="洪金宝">洪金宝<i>&times;</i></label>
                        <label title="元彪">元彪<i>&times;</i></label> -->
                        添加参保人
                    </a>
                    
                </div>
                <div class="main-content-fun-insuredMon new">
                	<h4>参保月份</h4>
                	
					<div class="g_month_wrap">
						<span> 社保 ：</span> 
						<div  class="switch g_on_off" id="mss" data-on="primary" data-off="" style="top:55px">
					    <input id="my_sb_Switch" name="is_shebao" value="1" type="checkbox" checked='checked' />
					</div>
                    <div class="g_month sb_month">
                    	 <input type="text" class="" id="date1" readonly value="" name="shebao_start_time" style="margin-left:10px" placeholder="年 - 月"/> -
						<input type="text" name="shebao_end_time" class="" id="date2" readonly value="" placeholder="年 - 月"/>
						
                    </div>
					</div>
                    <div class="g_month_wrap" style="margin-top: 10px;">
						<span>公积金：</span>
						<div  class="switch g_on_off" id="mgs" data-on="primary" data-off="" style="top:100px">
					    <input id="my_gjj_Switch" name="is_gjj" value="1" type="checkbox" checked="checked" />
					</div>
                    <div class="g_month gjj_month">
                    	<input type="text" class="" id="date3" readonly value="" name="gjj_start_time" placeholder="年 - 月"/> -
						<input type="text" class="" id="date4" readonly value="" name="gjj_end_time" placeholder="年 - 月"/>
						
                    </div>
					</div>
                </div>

                <div class="i_agree">
					<input type="checkbox" id="agree" style="margin-top:6px" checked><label for="agree">我已阅读并同意<a href="" >《服务代理协议》</a></label>
		        </div>
                <div class="g_button">
                    <button  type="button" onclick="to_jisuanfee();" class="btn btn-lg btn-success now_buy">下一步</button>
					<!--<button class="btn btn-lg btn-success">计算明细</button>-->
                </div>
            </div>

            <div class="main-content-detail t-countDetail" id="table_area">
	            <table class="table table-striped table-hover table-bordered">
	                <thead>
	                <tr>
	                    <th>名称</th>
	                    <th colspan="2">缴纳项目</th>
	                    <th>养老保险</th>
	                    <th>失业保险</th>
						<th>生育保险	</th>
	                    <th>工伤保险</th>
	                    <th>医疗保险</th>
	                    <th>公积金</th>
	                    <th>小计</th>
	                </tr>
	                <!--<tr>-->
	                    <!--<th>缴纳比例</th>-->
	                    <!--<th>缴纳金额</th>-->
	                    <!--<th>缴纳比例</th>-->
	                    <!--<th>缴纳金额</th>-->
	                <!--</tr>-->
	                </thead>
	                <tbody id="first_tbody">
	                <tr>
	                    <td>姓名</td>
	                    <td rowspan="2">企业缴纳</td>
	                    <td>比例(%)</td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td>
	                        -
	                    </td>
	                </tr>
	                <tr>

	                    <td></td>
	                    <td>金额(元)</td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>

	                </tr>
					<tr>
	                    <td>缴纳基数</td>
	                    <td rowspan="2">个人缴纳</td>
	                    <td>比例(%)</td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td>
	                        -
	                    </td>
	                </tr>
	                <tr>

	                    <td></td>
	                    <td>金额(元)</td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>

	                </tr>

	                <tr>
	                    <td colspan="10" style="text-align:left;padding-left:85%;background-color:#fff;">服务费：<span class="t-allTotal">0.00</span></td>
	                </tr>
					<tr>
	                    <td colspan="10" style="text-align:left;padding-left:85%;background-color:#fff;">总费用：<span class="t-allTotal">0.00</span></td>
	                </tr>
	                </tbody>
	            </table>
	        </div>

			<div class="g_button">
				<a class="btn btn-lg btn-success" id="to_top">上一步</a>
				<button type="submit" id="submit_order"  class="btn btn-lg btn-success now_buy">确认支付</button>

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
            <?php $tips = M('tips')->find(); ?>
			<div class="main-article-tips">
				<div class="default">
					<h4>社保小贴士</h4>
					<div><?php echo $tips['tips1']; ?></div>
				</div>
				<div class="social_tips">
					<p>特别提示:</p>
					<div>
					<?php echo $tips['tips2']; ?>
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
			<ul class="g_box_out" id="float_ul">
				<?php if(is_array($friend)): $k = 0; $__LIST__ = array_slice($friend,1,1000,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="g_box all_friend" user_id="<?php echo ($vo["user_id"]); ?>" username="<?php echo ($vo["username"]); ?>" onclick="check_li(this,<?php echo ($vo["user_id"]); ?>);">
					<div>
						<span><?php echo ($vo["username"]); ?></span><br>
						<span><?php echo ($vo["idcard"]); ?></span>
						<i class="glyphicon glyphicon-ok" aria-hidden="true"></i>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>

				<li class="g_box" data-toggle='modal' id="btn2">
					<a href="javascript:;"><span>+</span> 新增参保人</a>
				</li>

			</ul>
		</div>
		<div class="alert_footer">
			<button type="button" onclick="each_all_checked();" class="btn btn-lg btn-success">确定</button>
			<button type="button" class="btn btn-lg btn-success"  data-dismiss="modal" onclick="cacle_btn_float();">取消</button>
		</div>
	</div>
	<div class="modal fade g_alert2" id='show2'>
		<div class="close_out">
			<i class="e-closePop g_close">×</i>
		</div>
		<div class="modal-dialog g_rela">

			<div class="g_title">
				<label>1. 新增参保人</label>

			</div>
			<form id="new_person">
				<div class="pop-content">
					<div class="gg">
						<p>
							<input style="width:180px;" type="text" name="username" placeholder="姓名" id="username" value="">
							<!-- <label class="red error">* 请输入姓名</label> -->
						</p>
						<p>
							<input style="width:180px;" type="text" name="mobile" placeholder="手机号码" id="mobile" value="">
							<!-- <label class="red error">* 请输入手机号</label> -->
						</p>
						<p>
							<input style="width:180px;" type="text" name="idcard" placeholder="身份证号" id="idcard" value="">
							<!-- <label class="red error">* 请输入身份证号</label> -->
						</p>
					</div>
					<div>
						<p class="g_titel_2">
							<span>2. 户口类型</span>
						</p>
						<div class="g_in g_wxd">
							<!-- <span>户口类型：</span> -->
							<input type="radio" id="nc" name="nature" checked="checked"><label for="nc">农村</label>
							<input type="radio" id="cs" name="nature"><label for="cs">城市</label>
						</div>
					</div>
					<div>
						<p class="g_titel_2">
							<span>3. 开户行</span>
						</p>
						<div class="g_in">
							 <span>开户行：</span><input type="text" placeholder="首次参保用户必填" name="bank_name" value="" id="bank_name">
						</div>
						<div class="g_in">
							 <span>开户行卡号：
							</span><input type="text" placeholder="首次参保用户必填"  name="bank_num" value="" id="bank_num">
						</div>
					</div>
					<div class="pop-content-left">
						<p class="upload">
							<label>上传证件：</label>
							<label for="ID"  style="position: relative; z-index: 1;margin-left:10px" id="uploader">
								<span class="card-front-face selfile" id="s1">身份证正面</span>
								<input type="hidden" name="img1" value="" id="img1">

							</label>


							<label for="ID"  style="position: relative; z-index: 1;"  id="uploader2">
								<span class="card-front-back selfile" id="s2">身份证反面</span>
								<input type="hidden" name="img2" value="" id="img2">
							</label>
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
					<div class="s_clear"></div>
				</div>
				<div class="alert_footer2">
					<button type="button" class="btn btn-lg btn-success" onclick="upload_info();">确定</button>
					<button type="button" class="btn btn-lg btn-success g_quxiao" onclick="cancle_upload_info();">取消</button>
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

<script type="text/javascript">
	$(function(){
		/*
		 自定义样式一（按钮）
		 注意此时需要把点击触发选择文件的样式类加上 selfile，如想点击span标签触发选择文件，就要这样写<span class="selfile"></span>

		 初始触发是图片也是同理
		 想去掉默认预览样式，只需传入 onPreview 函数
		 */
		$.uploader({
			upBox   : $('#uploader'),
			upUrl   : "<?php echo U('Checklogin/uploader_img');?>",
			maxSize : 1024*1024*2,
			skin    : 2,
			auto    : true,
			allowExt: '.jpg,.jpeg,.png,.gif,.bmp',
			onBeforeGetFiles : function(selNum, waitNum, upNum) {

			},
			onPreview : function(file, img) {
				//自定义预览，如果你不想要预览，这里可以什么都不写
			},
			onSuccess  : function(file, response) {
				//当有文件上传成功后触发
//				alert(response);
//				$('#s1').append('上传成功');
				$('#s1').html('<img src="'+response+'" style="width:100%;height: 100%;">');
				$('#img1').val(response);
			},
			onFailure  : function(file, response) {
				//当有文件上传失败后触发
			}
		});

		$.uploader({
			upBox   : $('#uploader2'),
			upUrl   : "<?php echo U('Checklogin/uploader_img');?>",
			maxSize : 1024*1024*2,
			skin    : 2,
			auto    : true,
			allowExt: '.jpg,.jpeg,.png,.gif,.bmp',
			onBeforeGetFiles : function(selNum, waitNum, upNum) {

			},
			onPreview : function(file, img) {
				//自定义预览，如果你不想要预览，这里可以什么都不写
			},
			onSuccess  : function(file, response) {
				//当有文件上传成功后触发
				$('#s2').html('<img src="'+response+'" style="width:100%;height: 100%;">');
				$('#img2').val(response);
			},
			onFailure  : function(file, response) {
				//当有文件上传失败后触发
			}
		});


	});
</script>
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/diqu.js"></script>-->
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/not3.js"></script>-->
<script>

	/**点击选中参保人，选中参保人**/
	var user_info_arr=[];
	function check_li(obj,user_id){
		 var ret=$.inArray(user_id,user_info_arr);
		   if(ret<0){
			   user_info_arr.push(user_id);
			   $(obj).addClass('g_select');
		   }else{
			   user_info_arr.splice($.inArray(user_id, user_info_arr), 1);
			   $(obj).removeClass('g_select');
		   }
//		   alert(ret);


	}
	/**********点击弹出层的取消按钮，关闭弹出层**********/
	function cacle_btn_float(){
		$('#myModal').modal('hide');
	}



	/*********点击选择完弹出框的确定按钮，将数据拼接到参保人列表******/
	function each_all_checked(){
		var html='';
		var had_arr=[];//已经添加过去的用户usrid数据// 。

		$(".had_user").each(function(i){
				var user_id=$(this).attr("user_id");

			  had_arr.push(user_id);
		});

		$(".all_friend").each(function(i){
			var user_id=$(this).attr("user_id");
			var username=$(this).attr('username');

			//那边没有的拼接上去，有的就不在拼接
			if($(this).hasClass("g_select") && $.inArray(user_id,had_arr)<0){
//				alert(user_id);
				html+='<li class="g_li had_user" user_id="'+user_id+'"><span class="g_name" style="color: gray;">'+username+'</span><input class="g_sbjs" type="text" name="shebao_jishu['+user_id+']" placeholder="" value="" user_id="'+user_id+'"  onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert(\'只能输入数字，小数点后只能保留两位\', {icon: 6});this.value=0;}"><input class="g_gjjjs" type="text" name="gjj_jishu['+user_id+']" placeholder="" value="" user_id="'+user_id+'" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert(\'只能输入数字，小数点后只能保留两位\', {icon: 6});this.value=0;}"><span style="margin-left:20px;vertical-align:top;float:left;cursor:pointer;color:#4cae4c" class="g_zuidi" onclick="add(this)">使用最低基数</span><a href="#"><span style="width:14px;height:16px;margin-left:20px;" class="glyphicon glyphicon-remove g_delete"></span></a></li>';
			}

		});

		$("#g_put").append(html);
//		if(html==""){
//			layer.alert("请选择人员", {icon: 6});
//		}else{
			layer.alert("已添加", {icon: 6});
        $('#myModal').modal('hide');
//		}

	}


	/***************点击新增用户取消按钮，。******************/

	function cancle_upload_info(){
		$('#show2').modal('hide');
	}
	/***************点击新增用户，提交资料。******************/


	function upload_info(){
		var img1=$("#img1").val();
		var img2=$("#img2").val();

		var mobile= $.trim($("#mobile").val());
		var idcard= $.trim($("#idcard").val());
		var username= $.trim($("#username").val());
		var bank_name=$.trim($("#bank_name").val());
		var bank_num=$.trim($("#bank_num").val());
		var nature=$("input[name='nature']:checked").val();
		var pattern = /^1[34578]\d{9}$/;
		var pattern_idcard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		if (username == '') {
			layer.alert('请输入姓名', {icon: 2});
			return false;
		}
		if (mobile == '' || !pattern.test(mobile)) {
			layer.alert('请填写正确的电话号码', {icon: 2});
			return false;
		}
		if (idcard == '' || !pattern_idcard.test(idcard)) {
			layer.alert('请填写正确的身份证号', {icon: 2});
			return false;
		}

		if ((img1=="" || img2=="")) {
			layer.alert('请上传身份证信息', {icon: 2});
			return false;
		}

		$.ajax({
			url:"<?php echo U('Checklogin/add_userinfo');?>",
			data:{'username':username,'mobile':mobile,'idcard':idcard,'nature':nature,'bank_name':bank_name,'bank_num':bank_num,'img1':img1,'img2':img2},
			dataType:'json',
			type:'post',
			success:function(a){
				if(a.code==1){
					layer.alert(a.mess, {icon: 6});
					$('#show2').modal('hide');
					var html='';
					html+='<li class="g_box all_friend" user_id="'+a.id+'" username="'+username+'" onclick="check_li(this,'+ a.id+')">';
					html+='<div><span>'+username+'</span><br><span>'+idcard+'</span><i class="glyphicon glyphicon-ok" aria-hidden="true"></i></div></li>';
					$("#btn2").before(html);
                    $('#show2').modal('hide');
				}else{
					layer.alert(a.mess, {icon: 2});
				}
			},
			error:function(e){
				layer.alert('服务器内部错误', {icon: 2});
			}
		})

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
      //计算社保。公积金基数
	function to_shebao_jishu(){
	    var is_lock=$("#is_lock").attr("is_lock");
	       if(is_lock==1){
               layer.alert("请先完善个人信息", {icon: 2});
               setInterval(function(){window.location.href="<?php echo U('Home/Order/edit_info');?>";}, 2000);
               return false;
		   }
			var city=$("#to_city").val();
		     if(city>0){
				 $.ajax({
					 url:"<?php echo U('Checklogin/get_jishu');?>",
					 type:'post',
					 data:{'city':city},
					 dataType:'json',
					 success:function(e){
                         if(e.code==1){

							   $(".g_sbjs").attr('placeholder', e.data.sb_min+'元~元'+e.data.sb_max);//社保
							 $(".g_gjjjs").attr('placeholder', e.data.gjj_minbase+'元~元'+e.data.gjj_maxbase);//公积金
						 }else{
							 layer.alert(e.mess, {icon: 2});
						 }
				       },
					 error:function(e){
						 layer.alert("服务器内部错误", {icon: 2});
					 }
				 })
			 }else{
				 layer.alert("请选择办理城市", {icon: 2});
			 }

		}

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
		 // function add(){
   //          $(".g_zuidi").each(function () {
   //              alert($(this).text());
			// 	 return false;
   //          })
   //        } 
	 function add(obj){
		 var city=$("#to_city").val();
		 if(city>0){
			 $.ajax({
				 url:"<?php echo U('Checklogin/get_jishu');?>",
				 type:'post',
				 data:{'city':city},
				 dataType:'json',
				 success:function(e){
					 if(e.code==1){
						$(obj).prev().val(e.data.gjj_minbase);
						$(obj).prev().prev().val(e.data.sb_min);
					 }else{
						 layer.alert(e.mess, {icon: 2});
					 }
				 },
				 error:function(e){
					 layer.alert("服务器内部错误", {icon: 2});
				 }
			 })
		 }else{
			 layer.alert("请选择办理城市", {icon: 2});
		 }
	} ;

    //点击下一步时候，计算出费用
	function to_jisuanfee(){

		var is_shebao=$("#my_sb_Switch").is(":checked");//是否缴纳社保
		var is_gjj=$("#my_gjj_Switch").is(":checked");//是否缴纳公积金
		var city=$("#to_city").val();
		var date1=$("#date1").val();
		var date2=$("#date2").val();
		var date3=$("#date3").val();
		var date4=$("#date4").val();

		if(city==0){
			layer.alert("请选择要办理社保的城市", {icon: 2});
			return false;
		}

		var is_null=0;
		var is_null_is_gjj=0;
		var shebao_user_id='';
		var gjj_user_id='';
		var shebao_base_str='';
		var gjj_base_str='';
		// alert(is_shebao);
		//循环查看社保有没有都填写完
		$(".g_sbjs").each(function(i){
			if(!$(this).val() && is_shebao){
				is_null=1;
			}else{
				var user_id=$(this).attr("user_id");
				var shebao_base=$(this).val();
				// alert(shebao_base);
				shebao_user_id+=user_id+"-";
				shebao_base_str+=shebao_base+"-";
			}
		});
		$(".g_gjjjs").each(function(i){
			if(!$(this).val() && is_gjj){
                is_null_is_gjj=1;
			}else{
				var user_id=$(this).attr("user_id");
				var gjj_base=$(this).val();
				gjj_user_id+=user_id+"-";
				gjj_base_str+=gjj_base+"-";
			}
		});
		if(is_null){
			layer.alert("请填写社保办理基数", {icon: 2});
			return false;
		}
		if(is_null_is_gjj){
			layer.alert("请填写公积金办理基数", {icon: 2});
			return false;
		}
         //如果缴纳社保。时间必须填写
		if(is_shebao && (date1>=date2)){
			layer.alert("请选择正确的社保办理日期", {icon: 2});
			return false;
		}
		//如果缴纳社保。时间必须填写
		if(is_gjj && (date3>=date4)){
			layer.alert("请选择正确的公积金办理日期", {icon: 2});
			return false;
		}

		if(gjj_user_id || shebao_user_id){
			$.ajax({
				url:"<?php echo U('Checklogin/calculate');?>",
				type:'post',
				data:{'shebao_user_id':shebao_user_id,'date1':date1,'date2':date2,'date3':date3,'date4':date4,'is_shebao':is_shebao,'is_gjj':is_gjj,'city':city,'shebao_base_str':shebao_base_str,'gjj_base_str':gjj_base_str,'is_bujiao':0},

				success:function(data){
                       $("#table_area").html(data);
                    var h = $(document).height()-$(window).height();
                    $(document).scrollTop(h);
                    // $(window).scrollTop(0);//返回底部
                    // $("html,body").animate({scrollTop:0},500);//返回顶部
				},
				error:function(e){
					layer.alert("服务器内部错误", {icon: 2});
					return false;
				}

			})
		}

//		alert(is_shebao);
//		$("html,body").animate({scrollTop:0},500);//返回顶部
//		$(window).scrollTop(0);//返回底部
	}

	//点击去支付，提交表单，验证字段
	function check_field(){

		var is_shebao=$("#my_sb_Switch").is(":checked");//是否缴纳社保
		var is_gjj=$("#my_gjj_Switch").is(":checked");//是否缴纳公积金
		var city=$("#to_city").val();
		var date1=$("#date1").val();
		var date2=$("#date2").val();
		var date3=$("#date3").val();
		var date4=$("#date4").val();

		if(city==0){
			layer.alert("请选择要办理社保的城市", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}

		var is_null=0;
		var is_null_is_gjj=0;
		var shebao_user_id='';
		var gjj_user_id='';
		var shebao_base_str='';
		var gjj_base_str='';
		//循环查看社保有没有都填写完
		$(".g_sbjs").each(function(i){
			if(!$(this).val() && is_shebao){
				is_null=1;
			}
		});
		$(".g_gjjjs").each(function(i){
			if(!$(this).val() && is_gjj){
                is_null_is_gjj=1;
			}
		});
		if(is_null){
			layer.alert("请填写社保办理基数", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}
		if(is_null_is_gjj){
			layer.alert("请填写公积金办理基数", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}
         //如果缴纳社保。时间必须填写
		if(is_shebao && (date1>=date2)){
			layer.alert("请选择正确的社保办理日期", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}
		//如果缴纳社保。时间必须填写
		if(is_gjj && (date3>=date4)){
			layer.alert("请选择正确的公积金办理日期", {icon: 2});
            $("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}
		return true;
	}

		 //执行一个laydate实例
		 laydate.render({
			 elem: '#date1' //指定元素
			 ,type: 'month'
             ,min: 3
             ,max: 2000
			 ,change: function(value, date, endDate){
				 $('#date1').val(value);
				 $('#layui-laydate1').css('display','none');
				 var date2=$("#date2").val();
				 if(date2 != ""){
					 var m1 = value.split('-');
					 var m2 = date2.split('-');
					 var m1t = parseInt(m1[0]) * 12 + parseInt(m1[1]);
					 var m2t = parseInt(m2[0]) * 12 + parseInt(m2[1]);
					 var m = Math.abs(m2t - m1t);
					 layer.alert("您选择的社保办理日期为:<br>"+value+"-01到"+date2+"-01共:"+m+"个月", {icon: 1});
				 }
			 }
		 });
		 laydate.render({
			 elem: '#date2' //指定元素
			 ,type: 'month'
             ,min:  3
             ,max: 2000
			 ,change: function(value, date, endDate){
				 $('#date2').val(value);
				 $('#layui-laydate2').css('display','none');
				 var date1=$("#date1").val();
				 if(date1 != ""){
					 var m1 = date1.split('-');
					 var m2 = value.split('-');
					 var m1t = parseInt(m1[0]) * 12 + parseInt(m1[1]);
					 var m2t = parseInt(m2[0]) * 12 + parseInt(m2[1]);
					 var m = Math.abs(m2t - m1t);
					 layer.alert("您选择的社保办理日期为:<br>"+date1+"-01到"+value+"-01 共:"+m+"个月", {icon: 1});
				 }
			 }
		 });
		 laydate.render({
			 elem: '#date3' //指定元素
			 ,type: 'month'
             ,min:  3
             ,max: 2000
			 ,change: function(value, date, endDate){
				 $('#date3').val(value);
				 $('#layui-laydate3').css('display','none');
				 var date4=$("#date4").val();
				 if(date4 != ""){
					 var m1 = value.split('-');
					 var m2 = date4.split('-');
					 var m1t = parseInt(m1[0]) * 12 + parseInt(m1[1]);
					 var m2t = parseInt(m2[0]) * 12 + parseInt(m2[1]);
					 var m = Math.abs(m2t - m1t);
					 layer.alert("您选择的公积金办理日期为:<br>"+value+"-01到"+date4+"-01 共:"+m+"个月", {icon: 1});
				 }
			 }
		 });
		 laydate.render({
			 elem: '#date4' //指定元素
			 ,type: 'month'
             ,min:  3
             ,max: 2000
			 ,change: function(value, date, endDate){
				 $('#date4').val(value);
				 $('#layui-laydate4').css('display','none');
				 var date3=$("#date3").val();
				 if(date3 != ""){
					 var m1 = date3.split('-');
					 var m2 = value.split('-');
					 var m1t = parseInt(m1[0]) * 12 + parseInt(m1[1]);
					 var m2t = parseInt(m2[0]) * 12 + parseInt(m2[1]);
					 var m = Math.abs(m2t - m1t);
					 layer.alert("您选择的公积金办理日期为:<br>"+date3+"-01到"+value+"-01 共:"+m+"个月", {icon: 1});
				 }
			 }
		 });

		 $("#to_top").click(function(){
             $("html,body").animate({scrollTop:0},500);//返回顶部
		 })
	</script>
</html>