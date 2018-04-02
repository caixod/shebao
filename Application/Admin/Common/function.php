<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 北京易启东方网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.shop.yiqidongfang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 当燃
 * Date: 2015-09-09
 */

/**
 * 管理员操作记录
 * @param $log_url 操作URL
 * @param $log_info 记录信息
 */
function adminLog($log_info){
    $add['log_time'] = time();
    $add['admin_id'] = session('admin_id');
    $add['log_info'] = $log_info;
    $add['log_ip'] = getIP();
    $add['log_url'] = __ACTION__;
    M('admin_log')->add($add);
}

function today_order(){
	$d=date("Y-m-d");
	$where=['is_del'=>0,'add_time'=>['gt',strtotime($d)]];
	$total=0;

	$sb_company_order=D("sb_company_order")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_company_order;

	$gongjijin_bujiao=D("gjj_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$gongjijin_bujiao;

	$shebao_zhuanyi=D("sb_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_zhuanyi;

	$gjj_zhuanyi=D("gjj_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_zhuanyi;

	$gjj_tiqu=D("gjj_tiqu")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_tiqu;

	$yl_sgz=D("yl_sgz")->where($where)->getField("count(distinct order_sn)");
	$total+=$yl_sgz;

	$sy_shenqing=D("sy_shenqing")->where($where)->getField("count(distinct order_sn)");

	$total+=$sy_shenqing;
	$yd_bajy=D("yd_bajy")->where($where)->getField("count(distinct order_sn)");
	$total+=$yd_bajy;

	$sb_editinfo=D("sb_editinfo")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_editinfo;

	$own_money=D("own_money")->where($where)->getField("count(distinct order_sn)");
	$total+=$own_money;

	$tx_yanglao=D("tx_yanglao")->where($where)->getField("count(distinct order_sn)");
	$total+=$tx_yanglao;

	$school_info=D("school_info")->where($where)->getField("count(distinct order_sn)");
	$total+=$school_info;

	$rc_yingjin=D("rc_yingjin")->where($where)->getField("count(distinct order_sn)");
	$total+=$rc_yingjin;
	 return $total;

}

function get_service_name(){

	$data=[
		'sb_company_order'=>"企业社保补缴",
		'sb_bujiao'=>"个人社保补缴",
		'gjj_bujiao'=>"公积金补缴",
		'sb_zhuanyi'=>"社保转移",
		'gjj_zhuanyi'=>"公积金转移",
		'gjj_tiqu'=>"公积金提取",
		'yl_sgz'=>"医疗手工帐",
		'sy_shenqing'=>"生育申请",
		'yd_bajy'=>"异地备案就医",
		'sb_editinfo'=>"社保信息修改",
		'own_money'=>"个税缴纳",
		'tx_yanglao'=>"退休养老",
		'school_info'=>"上学材料",
		'rc_yingjin'=>"人才引进",
	];

	return $data;

}

function get_all_order(){
	$where=['is_del'=>0,'status'=>0];
	$total=0;
	$shebao_bujiao=D("sb_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_bujiao;
	$gongjijin_bujiao=D("gjj_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$gongjijin_bujiao;

	$shebao_zhuanyi=D("sb_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_zhuanyi;

	$gjj_zhuanyi=D("gjj_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_zhuanyi;

	$gjj_tiqu=D("gjj_tiqu")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_tiqu;

	$yl_sgz=D("yl_sgz")->where($where)->getField("count(distinct order_sn)");
	$total+=$yl_sgz;

	$sy_shenqing=D("sy_shenqing")->where($where)->getField("count(distinct order_sn)");

	$total+=$sy_shenqing;
	$yd_bajy=D("yd_bajy")->where($where)->getField("count(distinct order_sn)");
	$total+=$yd_bajy;

	$sb_editinfo=D("sb_editinfo")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_editinfo;

	$own_money=D("own_money")->where($where)->getField("count(distinct order_sn)");
	$total+=$own_money;

	$tx_yanglao=D("tx_yanglao")->where($where)->getField("count(distinct order_sn)");
	$total+=$tx_yanglao;

	$school_info=D("school_info")->where($where)->getField("count(distinct order_sn)");
	$total+=$school_info;

	$rc_yingjin=D("rc_yingjin")->where($where)->getField("count(distinct order_sn)");
	$total+=$rc_yingjin;
	 return $total;

}

function all_order(){
	$where=['is_del'=>0];
	$total=0;
	$sb_company_order=D("sb_company_order")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_company_order;

	$shebao_bujiao=D("sb_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_bujiao;
	$gongjijin_bujiao=D("gjj_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$gongjijin_bujiao;

	$shebao_zhuanyi=D("sb_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_zhuanyi;

	$gjj_zhuanyi=D("gjj_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_zhuanyi;

	$gjj_tiqu=D("gjj_tiqu")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_tiqu;

	$yl_sgz=D("yl_sgz")->where($where)->getField("count(distinct order_sn)");
	$total+=$yl_sgz;

	$sy_shenqing=D("sy_shenqing")->where($where)->getField("count(distinct order_sn)");

	$total+=$sy_shenqing;
	$yd_bajy=D("yd_bajy")->where($where)->getField("count(distinct order_sn)");
	$total+=$yd_bajy;

	$sb_editinfo=D("sb_editinfo")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_editinfo;

	$own_money=D("own_money")->where($where)->getField("count(distinct order_sn)");
	$total+=$own_money;

	$tx_yanglao=D("tx_yanglao")->where($where)->getField("count(distinct order_sn)");
	$total+=$tx_yanglao;

	$school_info=D("school_info")->where($where)->getField("count(distinct order_sn)");
	$total+=$school_info;

	$rc_yingjin=D("rc_yingjin")->where($where)->getField("count(distinct order_sn)");
	$total+=$rc_yingjin;
	 return $total;

}

function had_handle_order(){
	$where=['status'=>1];
	$total=0;
	$shebao_bujiao=D("sb_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_bujiao;
	$gongjijin_bujiao=D("gjj_bujiao")->where($where)->getField("count(distinct order_sn)");
	$total+=$gongjijin_bujiao;

	$shebao_zhuanyi=D("sb_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$shebao_zhuanyi;

	$gjj_zhuanyi=D("gjj_zhuanyi")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_zhuanyi;

	$gjj_tiqu=D("gjj_tiqu")->where($where)->getField("count(distinct order_sn)");
	$total+=$gjj_tiqu;

	$yl_sgz=D("yl_sgz")->where($where)->getField("count(distinct order_sn)");
	$total+=$yl_sgz;

	$sy_shenqing=D("sy_shenqing")->where($where)->getField("count(distinct order_sn)");

	$total+=$sy_shenqing;
	$yd_bajy=D("yd_bajy")->where($where)->getField("count(distinct order_sn)");
	$total+=$yd_bajy;

	$sb_editinfo=D("sb_editinfo")->where($where)->getField("count(distinct order_sn)");
	$total+=$sb_editinfo;

	$own_money=D("own_money")->where($where)->getField("count(distinct order_sn)");
	$total+=$own_money;

	$tx_yanglao=D("tx_yanglao")->where($where)->getField("count(distinct order_sn)");
	$total+=$tx_yanglao;

	$school_info=D("school_info")->where($where)->getField("count(distinct order_sn)");
	$total+=$school_info;

	$rc_yingjin=D("rc_yingjin")->where($where)->getField("count(distinct order_sn)");
	$total+=$rc_yingjin;
	 return $total;

}


function get_members(){

	$d=D("users")->where(['is_lock'=>0])->count();

     return $d;
}
function tree($province){

	$data=[];
	foreach($province as $k=>$v){
		$where=['flag'=>1,'parent_id'=>$v['id'],'level'=> 2,];
		$citys=D("region")->where($where)->select();
		if(count($citys)){
			$data[$v['name']]=$citys;
		}
	}
	return $data;
}

function getAdminInfo($admin_id){
	return D('admin')->where("admin_id=$admin_id")->find();
}

function tpversion()
{     
    if(!empty($_SESSION['isset_push']))
        return false;    
    $_SESSION['isset_push'] = 1;    
    error_reporting(0);//关闭所有错误报告
    $app_path = dirname($_SERVER['SCRIPT_FILENAME']).'/';
    $version_txt_path = $app_path.'/Application/Admin/Conf/version.txt';
    $curent_version = file_get_contents($version_txt_path);
    
    $vaules = array(            
            'domain'=>$_SERVER['HTTP_HOST'], 
            'last_domain'=>$_SERVER['HTTP_HOST'], 
            'key_num'=>$curent_version, 
            'install_time'=>INSTALL_DATE, 
            'cpu'=>'0001',
            'mac'=>'0002',
            'serial_number'=>SERIALNUMBER,
            );     
     $url = "http://service.shop.yiqidongfang.com/index.php?m=Home&c=Index&a=user_push&".http_build_query($vaules);
     stream_context_set_default(array('http' => array('timeout' => 3)));
     file_get_contents($url);       
}
 
/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function navigate_admin()
{        
    $navigate = include APP_PATH.'Common/Conf/navigate.php';    
    $location = strtolower('Admin/'.CONTROLLER_NAME);
    $arr = array(
        '后台首页'=>'javascript:void();',
        $navigate[$location]['name']=>'javascript:void();',
        $navigate[$location]['action'][ACTION_NAME]=>'javascript:void();',
    );
    return $arr;
}

/**
 * 导出excel
 * @param $strTable	表格内容
 * @param $filename 文件名
 */
function downloadExcel($strTable,$filename)
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
	header('Expires:0');
	header('Pragma:public');
	echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 根据id获取地区名字
 * @param $regionId id
 */
function getRegionName($regionId){
    $data = M('region')->where(array('id'=>$regionId))->field('name')->find();
    return $data['name'];
}

function getMenuList($act_list){
	//根据角色权限过滤菜单
	$menu_list = getAllMenu();
	if($act_list != 'all'){
		$right = M('system_menu')->where("id in ($act_list)")->cache(true)->getField('right',true);
		
		foreach ($right as $val){
			$role_right .= $val.',';
		}
		$role_right = explode(',', $role_right);		
		foreach($menu_list as $k=>$mrr){
			foreach ($mrr['sub_menu'] as $j=>$v){
				if(!in_array($v['control'].'Controller@'.$v['act'], $role_right)){
					unset($menu_list[$k]['sub_menu'][$j]);//过滤菜单
				}
			}
		}
	}
	return $menu_list;
}

function getAllMenu(){
	return array(
			'system' => array('name'=>'系统设置','icon'=>'fa-cog','sub_menu'=>array(
//					array('name'=>'网站设置','act'=>'index','control'=>'System'),
//					array('name'=>'友情链接','act'=>'linkList','control'=>'Article'),
//					array('name'=>'自定义导航','act'=>'navigationList','control'=>'System'),
					array('name'=>'区域管理','act'=>'region','control'=>'Tools'),
					array('name'=>'权限资源列表','act'=>'right_list','control'=>'System'),
			)),
			'access' => array('name' => '权限管理', 'icon'=>'fa-gears', 'sub_menu' => array(
					array('name' => '管理员列表', 'act'=>'index', 'control'=>'Admin'),
					array('name' => '角色管理', 'act'=>'role', 'control'=>'Admin'),
//					array('name' => '供应商管理', 'act'=>'supplier', 'control'=>'Admin'),
					array('name' => '管理员日志', 'act'=>'log', 'control'=>'Admin'),
			)),

//			'content' => array('name' => '内容管理', 'icon'=>'fa-comments', 'sub_menu' => array(
//					array('name' => '文章列表', 'act'=>'articleList', 'control'=>'Article'),
//					array('name' => '文章分类', 'act'=>'categoryList', 'control'=>'Article'),
//					//array('name' => '帮助管理', 'act'=>'help_list', 'control'=>'Article'),
//					//array('name' => '公告管理', 'act'=>'notice_list', 'control'=>'Article'),
//					array('name' => '专题列表', 'act'=>'topicList', 'control'=>'Topic'),
//			)),
			'wechat' => array('name' => '微信管理', 'icon'=>'fa-weixin', 'sub_menu' => array(
					array('name' => '公众号管理', 'act'=>'index', 'control'=>'Wechat'),
					array('name' => '微信菜单管理', 'act'=>'menu', 'control'=>'Wechat'),
					array('name' => '文本回复', 'act'=>'text', 'control'=>'Wechat'),
					array('name' => '图文回复', 'act'=>'img', 'control'=>'Wechat'),
					/*array('name' => '组合回复', 'act'=>'nes', 'control'=>'Wechat'),*/
					array('name' => '消息推送', 'act'=>'news', 'control'=>'Wechat'),
			)),
//			'theme' => array('name' => '模板管理', 'icon'=>'fa-adjust', 'sub_menu' => array(
//					array('name' => 'PC端模板', 'act'=>'templateList?t=pc', 'control'=>'Template'),
//					array('name' => '手机端模板', 'act'=>'templateList?t=mobile', 'control'=>'Template'),
//			)),
/*
			'distribut' => array('name' => '分销管理', 'icon'=>'fa-cubes', 'sub_menu' => array(
					array('name' => '分销商品列表', 'act'=>'goods_list', 'control'=>'Distribut'),
					array('name' => '分销商列表', 'act'=>'distributor_list', 'control'=>'Distribut'),
					array('name' => '分销关系', 'act'=>'tree', 'control'=>'Distribut'),
					array('name' => '分销设置', 'act'=>'set', 'control'=>'Distribut'),
					array('name' => '分成日志', 'act'=>'rebate_log', 'control'=>'Distribut'),
			)),
*/
//			'tools' => array('name' => '插件工具', 'icon'=>'fa-plug', 'sub_menu' => array(
//					array('name' => '插件列表', 'act'=>'index', 'control'=>'Plugin'),
////					array('name' => '数据备份', 'act'=>'index', 'control'=>'Tools'),
////					array('name' => '数据还原', 'act'=>'restore', 'control'=>'Tools'),
//			)),
			'member' => array('name'=>'用户管理','icon'=>'fa-user','sub_menu'=>array(
				array('name'=>'会员列表','act'=>'index','control'=>'User'),
//				array('name'=>'会员等级','act'=>'levelList','control'=>'User'),
//				array('name'=>'充值记录','act'=>'recharge','control'=>'User'),
//				array('name' => '提现申请', 'act'=>'withdrawals', 'control'=>'User'),
//				array('name' => '汇款记录', 'act'=>'remittance', 'control'=>'User'),
				//array('name'=>'会员整合','act'=>'integrate','control'=>'User'),
			)),
//			'goods' => array('name' => '商品管理', 'icon'=>'fa-book', 'sub_menu' => array(
//				array('name' => '商品分类', 'act'=>'categoryList', 'control'=>'Goods'),
//				array('name' => '商品列表', 'act'=>'goodsList', 'control'=>'Goods'),
//				array('name' => '商品类型', 'act'=>'goodsTypeList', 'control'=>'Goods'),
//				array('name' => '商品规格', 'act' =>'specList', 'control' => 'Goods'),
//				array('name' => '商品属性', 'act'=>'goodsAttributeList', 'control'=>'Goods'),
//				array('name' => '品牌列表', 'act'=>'brandList', 'control'=>'Goods'),
//				array('name' => '商品评论','act'=>'index','control'=>'Comment'),
//				array('name' => '商品咨询','act'=>'ask_list','control'=>'Comment'),
//			)),
			'order' => array('name' => '订单管理', 'icon'=>'fa-money', 'sub_menu' => array(
				array('name' => '企业订单列表', 'act'=>'sb_company_order_list', 'control'=>'Order'),
				array('name' => '社保代缴订单列表', 'act'=>'sb_daijiao_list', 'control'=>'Order'),
//				array('name' => '公积金代缴订单列表', 'act'=>'gjj_daijiao_list', 'control'=>'Order'),
				array('name' => '社保补缴订单列表', 'act'=>'sb_list', 'control'=>'Order'),
//				array('name' => '公积金补缴订单列表', 'act'=>'gjj_list', 'control'=>'Order'),
				array('name' => '社保转移订单列表', 'act'=>'sb_zhuanyi_list', 'control'=>'Order'),
				array('name' => '公积金转移订单列表', 'act'=>'gjj_zhuanyi_list', 'control'=>'Order'),
				array('name' => '住房公积金提取订单列表', 'act'=>'gjj_tiqu_list', 'control'=>'Order'),
				array('name' => '医疗手工报销订单列表', 'act'=>'yl_sgz_list', 'control'=>'Order'),
				array('name' => '生育待遇申领订单列表', 'act'=>'sy_shenqing_list', 'control'=>'Order'),
				array('name' => '异地就医备案订单列表', 'act'=>'yd_bajy_list', 'control'=>'Order'),
				array('name' => '社保信息修改订单列表', 'act'=>'sb_editinfo_list', 'control'=>'Order'),
				array('name' => '个人所得税申报订单列表', 'act'=>'own_money_list', 'control'=>'Order'),
				array('name' => '退休养老办理订单列表', 'act'=>'tx_yanglao_list', 'control'=>'Order'),
				array('name' => '孩子上学材料订单列表', 'act'=>'school_info_list', 'control'=>'Order'),
				array('name' => '天津人才引进订单列表', 'act'=>'rc_yingjin_list', 'control'=>'Order'),
				array('name' => '增值服务订单列表', 'act'=>'added_services', 'control'=>'Order'),

//				array('name' => '退货单', 'act'=>'return_list', 'control'=>'Order'),
//				array('name' => '退货单', 'act'=>'return_list', 'control'=>'Order'),
//				array('name' => '退货单', 'act'=>'return_list', 'control'=>'Order'),
//				array('name' => '添加订单', 'act'=>'add_order', 'control'=>'Order'),
//				array('name' => '订单日志', 'act'=>'order_log', 'control'=>'Order'),
			)),
//				'promotion' => array('name' => '促销管理', 'icon'=>'fa-bell', 'sub_menu' => array(
//						array('name' => '抢购管理', 'act'=>'flash_sale', 'control'=>'Promotion'),
//						array('name' => '团购管理', 'act'=>'group_buy_list', 'control'=>'Promotion'),
//						array('name' => '商品促销', 'act'=>'prom_goods_list', 'control'=>'Promotion'),
//						array('name' => '订单促销', 'act'=>'prom_order_list', 'control'=>'Promotion'),
//						array('name' => '代金券管理','act'=>'index', 'control'=>'Coupon'),
//				)),
//			'Ad' => array('name' => '广告管理', 'icon'=>'fa-flag', 'sub_menu' => array(
//				array('name' => '广告列表', 'act'=>'adList', 'control'=>'Ad'),
//				array('name' => '广告位置', 'act'=>'positionList', 'control'=>'Ad'),
//			)),

//			'pickup' => array('name' => '自提点管理', 'icon'=>'fa-anchor', 'sub_menu' => array(
//					array('name' => '自提点列表', 'act'=>'index', 'control'=>'Pickup'),
//					array('name' => '添加自提点', 'act'=>'add', 'control'=>'Pickup'),
//			)),
//			'store' => array('name' => '店铺管理', 'icon'=>'fa-cubes', 'sub_menu' => array(
//			array('name' => '店铺列表', 'act'=>'storeList', 'control'=>'Store'),
//
//				)),
//		'dish' => array('name' => '餐厅管理', 'icon'=>'fa-money', 'sub_menu' => array(
//			array('name' => '餐厅管理', 'act'=>'restaurantList', 'control'=>'Dish'),
//			array('name' => '菜品分类', 'act'=>'sortList', 'control'=>'Dish'),
//			array('name' => '基础菜品库', 'act'=>'base', 'control'=>'Dish'),
//			array('name' => '菜品管理', 'act'=>'manageList', 'control'=>'Dish'),
//			array('name' => '订单管理', 'act'=>'orders', 'control'=>'Dish'),
//			array('name' => '菜品统计', 'act'=>'statistics', 'control'=>'Dish'),
//		)),
		'manage' => array('name' => '基础设置', 'icon'=>'fa-signal', 'sub_menu' => array(
			array('name' => '哆啦宝支付配置', 'act'=>'pay_config', 'control'=>'manage'),
			array('name' => '服务地区开通', 'act'=>'area_list', 'control'=>'manage'),
			array('name' => '社保信息设置', 'act'=>'sb_list', 'control'=>'manage'),
			array('name' => '公积金信息设置', 'act'=>'gjj_list', 'control'=>'manage'),
			array('name' => '代金券发放', 'act'=>'coupon_list', 'control'=>'manage'),
			array('name' => '问题反馈列表', 'act'=>'up_question', 'control'=>'manage'),
			array('name' => '消息列表', 'act'=>'news_list', 'control'=>'manage'),
			array('name' => '短信消息列表', 'act'=>'sms_send_list', 'control'=>'manage'),
//			array('name' => '菜品管理', 'act'=>'manageList', 'control'=>'Base_manage'),
//			array('name' => '订单管理', 'act'=>'orders', 'control'=>'Base_manage'),
//			array('name' => '菜品统计', 'act'=>'statistics', 'control'=>'Base_manage'),
		)),
//		'boss' => array('name'=>'老板信息','icon'=>'fa-user','sub_menu'=>array(
//			array('name'=>'老板列表','act'=>'businessUserList','control'=>'BusinessUser'),
//			array('name'=>'角色管理','act'=>'businessUserRoleList','control'=>'BusinessUser'),
			/*array('name'=>'会员等级','act'=>'levelList','control'=>'User'),
            array('name'=>'充值记录','act'=>'recharge','control'=>'User'),
            array('name' => '提现申请', 'act'=>'withdrawals', 'control'=>'User'),
            array('name' => '汇款记录', 'act'=>'remittance', 'control'=>'User'),
        array('name'=>'会员整合','act'=>'integrate','control'=>'User'),*/
//		)),
		'count' => array('name' => '统计报表', 'icon'=>'fa-money', 'sub_menu' => array(
			array('name' => '销售概况', 'act'=>'index', 'control'=>'Report'),
//			array('name' => '销售排行', 'act'=>'saleTop', 'control'=>'Report'),
//			array('name' => '会员排行', 'act'=>'userTop', 'control'=>'Report'),
//			array('name' => '销售明细', 'act'=>'saleList', 'control'=>'Report'),
//			array('name' => '会员统计', 'act'=>'user', 'control'=>'Report'),
			array('name' => '财务统计', 'act'=>'finance', 'control'=>'Report'),
		)),
	);
}

	//后台系统菜单
function systemMenu(){
	return	array(
			'system' => array('name'=>'系统设置','icon'=>'fa-cog','sub_menu'=>array(
					array('name'=>'网站设置','act'=>'index','control'=>'System'),
					array('name'=>'友情链接','act'=>'linkList','control'=>'Article'),
					array('name'=>'自定义导航','act'=>'navigationList','control'=>'System'),
					array('name'=>'区域管理','act'=>'region','control'=>'Tools'),
					array('name'=>'权限资源列表','act'=>'right_list','control'=>'System'),
			)),
			'access' => array('name' => '权限管理', 'icon'=>'fa-gears', 'sub_menu' => array(
					array('name' => '管理员列表', 'act'=>'index', 'control'=>'Admin'),
					array('name' => '角色管理', 'act'=>'role', 'control'=>'Admin'),
					array('name' => '供应商管理', 'act'=>'supplier', 'control'=>'Admin'),
					array('name' => '管理员日志', 'act'=>'log', 'control'=>'Admin'),
			)),
//			'member' => array('name'=>'会员管理','icon'=>'fa-user','sub_menu'=>array(
//					array('name'=>'会员列表','act'=>'index','control'=>'User'),
//					array('name'=>'会员等级','act'=>'levelList','control'=>'User'),
//					array('name'=>'充值记录','act'=>'recharge','control'=>'User'),
//					array('name' => '提现申请', 'act'=>'withdrawals', 'control'=>'User'),
//					array('name' => '汇款记录', 'act'=>'remittance', 'control'=>'User'),
//				//array('name'=>'会员整合','act'=>'integrate','control'=>'User'),
//			)),
			'weixin' => array('name' => '微信管理', 'icon'=>'fa-weixin', 'sub_menu' => array(
					array('name' => '公众号管理', 'act'=>'index', 'control'=>'Wechat'),
					array('name' => '微信菜单管理', 'act'=>'menu', 'control'=>'Wechat'),
					array('name' => '微信分组管理', 'act'=>'tagList', 'control'=>'Wechat'),
					array('name' => '文本回复', 'act'=>'text', 'control'=>'Wechat'),
					array('name' => '图文回复', 'act'=>'img', 'control'=>'Wechat'),
				/*array('name' => '组合回复', 'act'=>'nes', 'control'=>'Wechat'),*/
					array('name' => '消息推送', 'act'=>'news', 'control'=>'Wechat'),
			)),
//			'theme' => array('name' => '模板管理', 'icon'=>'fa-adjust', 'sub_menu' => array(
//				array('name' => 'PC端模板', 'act'=>'templateList?t=pc', 'control'=>'Template'),
//                array('name' => '手机端模板', 'act'=>'templateList?t=mobile', 'control'=>'Template'),
//			)),

			'tools' => array('name' => '插件工具', 'icon'=>'fa-plug', 'sub_menu' => array(
					array('name' => '插件列表', 'act'=>'index', 'control'=>'Plugin'),
					array('name' => '数据备份', 'act'=>'index', 'control'=>'Tools'),
					array('name' => '数据还原', 'act'=>'restore', 'control'=>'Tools'),
			)),
//			'count' => array('name' => '统计报表', 'icon'=>'fa-signal', 'sub_menu' => array(
//					/*array('name' => '销售概况', 'act'=>'index', 'control'=>'Report'),
//					array('name' => '销售排行', 'act'=>'saleTop', 'control'=>'Report'),
//					array('name' => '会员排行', 'act'=>'userTop', 'control'=>'Report'),
//					array('name' => '销售明细', 'act'=>'saleList', 'control'=>'Report'),*/
//					array('name' => '会员统计', 'act'=>'user', 'control'=>'Report'),
//					/*array('name' => '财务统计', 'act'=>'finance', 'control'=>'Report'),*/
//			)),

	);
}

	//商城系统菜单
function shopMenu(){
	return	array(

			'access' => array('name' => '附加管理', 'icon'=>'fa-gears', 'sub_menu' => array(
					/*array('name' => '管理员列表', 'act'=>'index', 'control'=>'Admin'),
					array('name' => '角色管理', 'act'=>'role', 'control'=>'Admin'),*/
					array('name' => '供应商管理', 'act'=>'supplier', 'control'=>'Admin'),
					/*array('name' => '管理员日志', 'act'=>'log', 'control'=>'Admin'),*/
			)),
			'member' => array('name'=>'会员管理','icon'=>'fa-user','sub_menu'=>array(
					array('name'=>'会员列表','act'=>'index','control'=>'User'),
					array('name'=>'会员等级','act'=>'levelList','control'=>'User'),
					array('name'=>'充值记录','act'=>'recharge','control'=>'User'),
					array('name' => '提现申请', 'act'=>'withdrawals', 'control'=>'User'),
					array('name' => '汇款记录', 'act'=>'remittance', 'control'=>'User'),
				//array('name'=>'会员整合','act'=>'integrate','control'=>'User'),
			)),
			'goods' => array('name' => '商品管理', 'icon'=>'fa-book', 'sub_menu' => array(
					array('name' => '商品分类', 'act'=>'categoryList', 'control'=>'Goods'),
					array('name' => '商品列表', 'act'=>'goodsList', 'control'=>'Goods'),
					array('name' => '商品类型', 'act'=>'goodsTypeList', 'control'=>'Goods'),
					array('name' => '商品规格', 'act' =>'specList', 'control' => 'Goods'),
					array('name' => '商品属性', 'act'=>'goodsAttributeList', 'control'=>'Goods'),
					array('name' => '品牌列表', 'act'=>'brandList', 'control'=>'Goods'),
					array('name' => '商品评论','act'=>'index','control'=>'Comment'),
					array('name' => '商品咨询','act'=>'ask_list','control'=>'Comment'),
			)),
			'order' => array('name' => '订单管理', 'icon'=>'fa-money', 'sub_menu' => array(
					array('name' => '订单列表', 'act'=>'index', 'control'=>'Order'),
					array('name' => '发货单', 'act'=>'delivery_list', 'control'=>'Order'),
				//array('name' => '快递单', 'act'=>'express_list', 'control'=>'Order'),
					array('name' => '退货单', 'act'=>'return_list', 'control'=>'Order'),
					array('name' => '添加订单', 'act'=>'add_order', 'control'=>'Order'),
					array('name' => '订单日志', 'act'=>'order_log', 'control'=>'Order'),
			)),
			'promotion' => array('name' => '促销管理', 'icon'=>'fa-bell', 'sub_menu' => array(
					array('name' => '抢购管理', 'act'=>'flash_sale', 'control'=>'Promotion'),
					array('name' => '团购管理', 'act'=>'group_buy_list', 'control'=>'Promotion'),
					array('name' => '商品促销', 'act'=>'prom_goods_list', 'control'=>'Promotion'),
					array('name' => '订单促销', 'act'=>'prom_order_list', 'control'=>'Promotion'),
					array('name' => '代金券管理','act'=>'index', 'control'=>'Coupon'),
			)),
			'Ad' => array('name' => '广告管理', 'icon'=>'fa-flag', 'sub_menu' => array(
					array('name' => '广告列表', 'act'=>'adList', 'control'=>'Ad'),
					array('name' => '广告位置', 'act'=>'positionList', 'control'=>'Ad'),
			)),
			'content' => array('name' => '内容管理', 'icon'=>'fa-comments', 'sub_menu' => array(
					array('name' => '文章列表', 'act'=>'articleList', 'control'=>'Article'),
					array('name' => '文章分类', 'act'=>'categoryList', 'control'=>'Article'),
				//array('name' => '帮助管理', 'act'=>'help_list', 'control'=>'Article'),
				//array('name' => '公告管理', 'act'=>'notice_list', 'control'=>'Article'),
					array('name' => '专题列表', 'act'=>'topicList', 'control'=>'Topic'),
			)),



	);
}

	//点餐系统菜单
	function getDishMenu(){

		return array(
				'store' => array('name' => '店铺管理', 'icon'=>'fa-cubes', 'sub_menu' => array(
						array('name' => '店铺列表', 'act'=>'storeList', 'control'=>'Store'),
				)),
				'dish' => array('name' => '餐厅管理', 'icon'=>'fa-money', 'sub_menu' => array(
						array('name' => '餐厅管理', 'act'=>'restaurantList', 'control'=>'Dish'),
						array('name' => '菜品分类', 'act'=>'sortList', 'control'=>'Dish'),
						array('name' => '基础菜品库', 'act'=>'base', 'control'=>'Dish'),
						array('name' => '菜品管理', 'act'=>'manageList', 'control'=>'Dish'),
						array('name' => '订单管理', 'act'=>'orders', 'control'=>'Dish'),
						array('name' => '菜品统计', 'act'=>'statistics', 'control'=>'Dish'),
				)),
//				'count' => array('name' => '统计报表', 'icon'=>'fa-signal', 'sub_menu' => array(
//						array('name' => '销售概况', 'act'=>'index', 'control'=>'Report'),
//						array('name' => '销售排行', 'act'=>'saleTop', 'control'=>'Report'),
//						array('name' => '会员排行', 'act'=>'userTop', 'control'=>'Report'),
//						array('name' => '销售明细', 'act'=>'saleList', 'control'=>'Report'),
//						array('name' => '会员统计', 'act'=>'user', 'control'=>'Report'),
//						array('name' => '财务统计', 'act'=>'finance', 'control'=>'Report'),
//				)),
				/*'goods' => array('name' => '商品管理', 'icon'=>'fa-book', 'sub_menu' => array(
						array('name' => '商品分类', 'act'=>'categoryList', 'control'=>'Goods'),
						array('name' => '商品列表', 'act'=>'goodsList', 'control'=>'Goods'),
						array('name' => '商品类型', 'act'=>'goodsTypeList', 'control'=>'Goods'),
						array('name' => '商品规格', 'act' =>'specList', 'control' => 'Goods'),
						array('name' => '商品属性', 'act'=>'goodsAttributeList', 'control'=>'Goods'),
						array('name' => '品牌列表', 'act'=>'brandList', 'control'=>'Goods'),
						array('name' => '商品评论','act'=>'index','control'=>'Comment'),
						array('name' => '商品咨询','act'=>'ask_list','control'=>'Comment'),
				)),
				'order' => array('name' => '订单管理', 'icon'=>'fa-money', 'sub_menu' => array(
						array('name' => '订单列表', 'act'=>'index', 'control'=>'Order'),
						array('name' => '发货单', 'act'=>'delivery_list', 'control'=>'Order'),
					//array('name' => '快递单', 'act'=>'express_list', 'control'=>'Order'),
						array('name' => '退货单', 'act'=>'return_list', 'control'=>'Order'),
						array('name' => '添加订单', 'act'=>'add_order', 'control'=>'Order'),
						array('name' => '订单日志', 'act'=>'order_log', 'control'=>'Order'),
				)),*/
		);
	}


	//结算系统菜单
	function settlementMenu(){
		return array(


				'count' => array('name' => '统计报表', 'icon'=>'fa-signal', 'sub_menu' => array(
						array('name' => '销售概况', 'act'=>'index', 'control'=>'Report'),
						array('name' => '销售排行', 'act'=>'saleTop', 'control'=>'Report'),
						array('name' => '会员排行', 'act'=>'userTop', 'control'=>'Report'),
						array('name' => '销售明细', 'act'=>'saleList', 'control'=>'Report'),
						array('name' => '会员统计', 'act'=>'user', 'control'=>'Report'),
						array('name' => '财务统计', 'act'=>'finance', 'control'=>'Report'),
				)),
		);
	}

	//商业用户系统菜单
	function accountsMenu(){
		return array(
				'member' => array('name'=>'会员管理','icon'=>'fa-user','sub_menu'=>array(
						array('name'=>'用户列表','act'=>'businessUserList','control'=>'BusinessUser'),
						array('name'=>'角色管理','act'=>'businessUserRoleList','control'=>'BusinessUser'),
						/*array('name'=>'会员等级','act'=>'levelList','control'=>'User'),
						array('name'=>'充值记录','act'=>'recharge','control'=>'User'),
						array('name' => '提现申请', 'act'=>'withdrawals', 'control'=>'User'),
						array('name' => '汇款记录', 'act'=>'remittance', 'control'=>'User'),
					array('name'=>'会员整合','act'=>'integrate','control'=>'User'),*/
				)),
		);
	}

	function respose($res){
		exit(json_encode($res));
	}
    /*
     * 获取登录账户角色用于的店铺id信息
     * */
   function getCidArr(){
	   $cid_str=$_SESSION['cid'];//该店员所属的店铺
	   $cid_arr='';
	   if(strpos($cid_str,',')){  //取出该用户所属的store_id  //多个店铺
		   $cid_arr=$cid_str;
	   }else{   //一个店铺
		   if($cid_str==0){
			   return $cid_arr;  //系统人员直接返回空
		   }else{
			   $cid_arr=$cid_str; 
		   }
	   }
	   return $cid_arr;
   }

	//价格出库 点餐类价最小单位为分，数据存储类型为整型，实际显示时做除去100
	function getNormalPrice($price){
		echo $price/100;
	}

	//价格入库乘100
	function formatPrice($price){
		return $price*100;
	}


	//后台通过openid获取会员信息
	function getUserInfoThoughOpenid($openid){
		$re = M("users")->where(array('openid'=>$openid))->find();
		return $re;
	}