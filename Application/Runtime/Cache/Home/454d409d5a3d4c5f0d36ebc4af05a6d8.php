<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<title>个人社保代缴</title>

	<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">


	<script src="/Template/pc/default/Static/js/mobile_js/jquery.min.js"></script>
	<script src="/Template/pc/default/Static/js/mobile_js/bootstrap.min.js"></script>
	<script src="/Template/pc/default/Static/js/other.js"></script>
	<script src="/Template/pc/default/Static/js/global_no.js"></script>
	<script src="/Template/pc/default/Static/js/new_js/laydate/laydate.js"></script>
	<script src="/Template/pc/default/Static/js/new_js/layer/layer.js"></script>
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/reset.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/bootstrap.min.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/mpicker.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/common.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/mobile_css/style.css">
	<link rel="stylesheet" href="/Template/pc/default/Static/css/uploader_css/uploader.css">
	<script src="/Template/pc/default/Static/js/uploader_js/uploader.1.2.js" ></script>
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
<div class="s_title">个人社保代缴</div>
<div class="s_city">参保城市</div>

<form action="" method="post"  id="form1">

	<div class="slide_out">
		<div class="slide1">请选择：</div>
		<div data-toggle="distpicker">
			<label class="sr-only" for="province7">省份</label>
			<select class="form-control"  name="to_province" id="to_province" onChange="get_city_t(this);" style="height: 40px;">
				<option  value="0">请选择</option>
				<?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<label class="sr-only" for="city7">市区</label>
			<select class="form-control" name="to_city" id="to_city" onchange="to_shebao_jishu();" style="height: 40px;">
				<option  value="0">请选择</option>

			</select>
		</div>
	</div>
	<div class="s_city">参保人员</div>
	<div class="slide_out">
		<ul class="slide_out_ul" id="g_put">
			<li>
				<ul class="user" style="">
					<li  class="li">姓名</li>
					<li class="li">社保基数</li>
					<li class="li">公积金基数</li>
				</ul>
			</li>
			<?php if(is_array($friend)): $k = 0; $__LIST__ = array_slice($friend,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="had_user" user_id="<?php echo ($vo["user_id"]); ?>">
					<ul class="user">
						<li class="li"><?php echo ($vo["username"]); ?></li>
						<li class="li">
							<input type="text" class="g_sbjs" name="shebao_jishu[<?php echo ($vo["user_id"]); ?>]" id="place1" placeholder="" value="" user_id="<?php echo ($vo["user_id"]); ?>" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}">
						</li>
						<li class="li">
							<input type="text"  class="g_gjjjs"  name="gjj_jishu[<?php echo ($vo["user_id"]); ?>]" placeholder="" id="place2" value="" user_id="<?php echo ($vo["user_id"]); ?>" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert('只能输入数字，小数点后只能保留两位', {icon: 6});this.value='';}">
						</li>
						<li class="close" onclick="del_user(this);">×</li>
					</ul>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="_add">
		<span>参保人员：</span>
		<a class="btn btn-md btn-success" data-toggle="modal" data-target="#myModal">添加参保人员</a>
	</div>

	<div class="s_city">参保月份</div>
	<div class="_date">
		<span>社保：</span>
		<input  id="date1"  name="shebao_start_time" value="" />
		<input id="date2" name="shebao_end_time" value=""/>
		<a class="b_on" id="is_shebao" style="color: #000;text-decoration:none;">办理</a>
	</div>
	<div class="_date">
		<span>公积金：</span>
		<input  id="date3" name="gjj_start_time" value=""/>
		<input id="date4" name="gjj_end_time" value=""/>
		<a  class="b_on" id="is_gjj" style="color: #000;text-decoration:none;">办理</a>
	</div>
	<div class="s_city">相关费用</div>
	<div class="tip" style="padding-left:15px;">

	</div>
	<div style="width:50%;margin: 2px auto;" id="add_input">
		<button type="button" class="btn btn-primary btn-sm btn-block" onclick="check_field();" style="background-color: #5cb85c;border: none;">提交订单</button>

	</div>



</form>

<!--<div class="s_city">相关费用</div>-->
<div class="tip" style="padding-left:15px;">
	<!--<p>-->
	<!--社保：<span><i class="tip-s-total"></i>3300元</span>-->
	<!--公积金：<span><i class="tip-r-total"></i>3400元</span>-->
	<!--服务费：<span><i class="t-ser-fee"></i>1200元</span>-->
	<!--</p>-->
	<!--<p>-->
	<!--参保月数：<span><i class="t-s-month"></i>6个月</span>-->
	<!--参保人数：<span><i class="t-s-person"></i>2个人</span>-->
	<!--</p>-->
	<!--<p>-->
	<!--费用总计：<span><b class="tip-allTotal"></b>7900元</span>-->
	<!--</p>-->
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
						<div  style="text-align: center;">

							<span><?php echo ($vo["username"]); ?></span><br>
							<span>&nbsp;<?php echo ($vo["mobile"]); ?></span>
							<i class="glyphicon glyphicon-ok" aria-hidden="true" style="top: -20px;"></i>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>

				<li class="g_box" data-toggle='modal' id="btn2">
					<a href="javascript:;" style="font-size: 14px;"><span>+</span> 新增参保人</a>
				</li>
			</ul>
		</div>
		<div class="alert_footer" style="margin: 5px auto;width: 100px;">
			<a type="button" class="btn  btn-success" onclick="each_all_checked();" >确定</a>&nbsp;&nbsp;
			<a type="button" class="btn  btn-success" data-dismiss="modal"  onclick="cacle_btn_float();">取消</a>
		</div>
	</div>
	<div class="modal fade g_alert2" id='show2'>
		<div class="modal-dialog g_rela g_rela2">
			<div class="g_title">
				<label>1. 新增参保人</label>
				<i class="e-closePop g_close">×</i>
			</div>
			<form id="new_person">
				<div class="pop-content">
					<div class="gg">
						<p>
							<input style="width:190px;;" type="text"  name="username" placeholder="姓名" id="username" value="">
							<!-- <label class="red error">* 请输入姓名</label> -->
						</p>
						<p>
							<input style="width:190px;;" type="text" name="mobile" placeholder="手机号码" id="mobile" value="">
							<!-- <label class="red error">* 请输入手机号</label> -->
						</p>
						<p>
							<input style="width:190px;;" type="text" name="idcard" placeholder="身份证号" id="idcard" value="">
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
							<span>开户行：</span>
							<input style="width:190px;" type="text" placeholder="首次参保用户必填" name="bank_name" value="" id="bank_name">
						</div>
						<div class="g_in">
                                     <span>卡 号：
                                    </span><input style="width:190px;" type="text" placeholder="首次参保用户必填"  name="bank_num" value="" id="bank_num">
						</div>
					</div>
					<div class="pop-content-left">
						<p class="upload">
							<label>上传<br>证件：</label>
							<label for="ID"  style="position: relative; z-index: 1;"  id="uploader">
								<span class="card-front-face selfile" id="s1">身份证正面</span>	<input type="hidden" name="img1" value="" id="img1">
							</label>
							<label for="ID"  style="position: relative; z-index: 1;" id="uploader2">
								<span class="card-front-back selfile" id="s2">身份证反面</span>	<input type="hidden" name="img2" value="" id="img2"></label>
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
				<div class=" alert_footer2"  style="margin: 5px auto;width: 100px;">
					<a type="button" class="btn btn-success" onclick="upload_info();">确定</a>&nbsp;&nbsp;
					<a type="button" class="btn btn-success g_quxiao" onclick="cancle_upload_info();">取消</a>
				</div>
			</form>
		</div>
	</div>
</div>

<span id="is_lock" is_lock="<?php echo ($is_lock); ?>"></span>
<div id="datePlugin"></div>
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
<script src="/Template/pc/default/Static/js/mobile_js/json.js"></script>
<script src="/Template/pc/default/Static/js/mobile_js/jsonExchange.js"></script>
<script src="/Template/pc/default/Static/js/mobile_js/mPicker.min.js"></script>
<script src="/Template/pc/default/Static/js/mobile_js/date.js"></script>
<script src="/Template/pc/default/Static/js/mobile_js/iscroll.js"></script>

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
<script>

	function del_user(obj){
		$(obj).parent().parent().remove();
	}
	//    $(".close").on("click",function() {
	//
	//    })

	/**点击选中参保人，选中参保人**/
	var user_info_arr=[];
	function check_li(obj,user_id){

		var ret=$.inArray(user_id,user_info_arr);

		if(ret<0){
			user_info_arr.push(user_id);
			$(obj).addClass('select_s');

		}else{
			user_info_arr.splice($.inArray(user_id, user_info_arr), 1);
			$(obj).removeClass('select_s');
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
//      alert(had_arr);
		console.log(had_arr);
		$(".all_friend").each(function(i){
			var user_id=$(this).attr("user_id");
			var username=$(this).attr('username');
//            console.log(user_id);

			//那边没有的拼接上去，有的就不在拼接
			if($(this).hasClass("select_s") && $.inArray(user_id,had_arr)<0){
//				alert(user_id);
              var place1= $("#place1").attr("placeholder");
              var place2= $("#place2").attr("placeholder");

				html+='<li class="had_user" user_id="'+user_id+'">';
				html+='<ul class="user"><li class="li">'+username+'</li><li class="li">';
				html+='<input type="text" class="g_sbjs" name="shebao_jishu['+user_id+']" placeholder="'+place1+'" value="" user_id="'+user_id+'" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert(\'只能输入数字，小数点后只能保留两位\', {icon: 6});this.value=\'\';}"></li>';
				html+='<li class="li"><input type="text"  class="g_gjjjs"  name="gjj_jishu['+user_id+']" placeholder="'+place2+'" value="" user_id="'+user_id+'" onkeyup= "if(!/^[0-9]+(.[0-9]{0,2})?$/.test(this.value)){layer.alert(\'只能输入数字，小数点后只能保留两位\', {icon: 6});this.value=\'\';}"></li>  <li class="close" onclick="del_user(this);">×</li></ul></li>';
			}

		});
//           alert(html);
//        console.log(html);
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
			data:{'username':username,'mobile':mobile,'idcard':idcard,'nature':nature,'bank_name':bank_name,'bank_num':bank_num,'img1':img1,'img2':img2,'is_company':0},
			dataType:'json',
			type:'post',
			success:function(a){
				if(a.code==1){
					layer.alert(a.mess, {icon: 6});
					$('#show2').modal('hide');
					var html='';
					html+='<li class="g_box all_friend" user_id="'+a.id+'" username="'+username+'" onclick="check_li(this,'+ a.id+')">';
					html+='<div style="text-align: center;"><span>'+username+'</span><br><span>&nbsp;'+mobile+'</span><i class="glyphicon glyphicon-ok" aria-hidden="true" ></i></div></li>';
					$("#btn2").before(html);
                    $('#show2').modal('hide');
				}else{
					layer.alert(a.mess, {icon: 2});
                    $('#show2').modal('hide');
				}
			},
			error:function(e){
				layer.alert('服务器内部错误', {icon: 2});
			}
		})

	}



	//计算社保。公积金基数
	function to_shebao_jishu(){
        var is_lock=$("#is_lock").attr("is_lock");
        if(is_lock==1){
            layer.alert("请先完善个人信息", {icon: 2});
            setInterval(function(){window.location.href="<?php echo U('Home/MobileOrder/edit_info');?>";}, 2000);
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

						$(".g_sbjs").attr('placeholder', e.data.sb_min+'~'+e.data.sb_max);//社保
						$(".g_gjjjs").attr('placeholder', e.data.gjj_minbase+'~'+e.data.gjj_maxbase);//公积金
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
	//点击去支付，提交表单，验证字段
	function check_field(){

		var is_shebao=false;//是否缴纳社保
		var is_gjj=false;//是否缴纳公积金
		if($("#is_shebao").text()=="办理"){
			is_shebao=true;
		}
		if($("#is_gjj").text()=="办理"){
			is_gjj=true;
		}

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
//			$("html,body").animate({scrollTop:0},500);//返回顶部
			return false;
		}


		//
		if(gjj_user_id || shebao_user_id){
			$.ajax({
				url:"<?php echo U('Checklogin/calculate');?>",
				type:'post',
				data:{'shebao_user_id':shebao_user_id,'date1':date1,'date2':date2,'date3':date3,'date4':date4,'is_shebao':is_shebao,'is_gjj':is_gjj,'city':city,'shebao_base_str':shebao_base_str,'gjj_base_str':gjj_base_str,'is_bujiao':0,'is_mobile':1},
				dataType:"json",
				success:function(data){

					if(data.code==1){
						var indexs=layer.confirm('订单费用详情:<br>社保费：'+data.sb_fee+" 元<br>公积金费："+data.gjj_fee+" 元<br>服务费："+data.service_fee+" 元<br> 总费用："+data.all_total+" 元", {
							btn: ['确认','取消'] //按钮
						}, function(indexs){
							$("#add_input").append("<input type='hidden' name='is_shebao' value='"+is_shebao+"'>");
							$("#add_input").append("<input type='hidden' name='is_gjj' value='"+is_gjj+"'>");
							layer.close(indexs);
							$("#form1").submit();
							// return true;
						}, function(indexs){
							layer.close(indexs);
						});
					}

				},
				error:function(e){
					layer.alert("服务器内部错误", {icon: 2});
					return false;
				}

			})
		}
		return false;
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
		// $(".b_on").on("click",function() {
		//     $(".b_on").removeClass("b_on2");
		//     $(this).addClass("b_on2");
		//     $(this).text("不办");
		//     $(this).siblings().filter("input").attr("disabled","true");
		// });
		$(".b_on").on("click",function() {
			if($(this).hasClass("b_on2")){
				$(this).removeClass("b_on2");
			}else{
				$(this).addClass("b_on2");
			}
			if($(this).text()=="不办"){
				$(this).text("办理")
				$(this).siblings().filter("input").removeAttr("disabled");
			}else{
				$(this).text("不办");
				$(this).siblings().filter("input").attr("disabled","true");
			}

		});
	})

	//执行一个laydate实例
	//执行一个laydate实例
	laydate.render({
		elem: '#date1' //指定元素
		,type: 'month'
		,min: 0
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
		,min: 0
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
		,min: 0
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
		,min: 0
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
</script>
</html>