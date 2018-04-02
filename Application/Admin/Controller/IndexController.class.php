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
namespace Admin\Controller;


class IndexController extends BaseController {

    public function index(){
        $act_list = session('act_list');
        $menu_list = getMenuList($act_list);
        /*by Nicolas 20170317 start*/
        $dish_menu_list = getDishMenu();
        $system_menu_list = systemMenu();//
        $shop_menu_list = shopMenu();
//        $shop_menu_list = $menu_list;  bai2017.5.21
        $settlement_menu_list = settlementMenu();
        $accounts_menu_list = accountsMenu();
        $num_kinds_order_uncheck = array();
        $num_kinds_order_uncheck['o_0'] = M('sb_company_order')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_1'] = M('sb_daijiao')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_2'] = M('sb_bujiao')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_3'] = M('sb_zhuanyi')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_4'] = M('gjj_zhuanyi')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_5'] = M('gjj_tiqu')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_6'] = M('yl_sgz')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_7'] = M('sy_shenqing')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_8'] = M('yd_bajy')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_9'] = M('sb_editinfo')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_10'] = M('own_money')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_11'] = M('tx_yanglao')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_12'] = M('school_info')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_13'] = M('rc_yingjin')->where(array('status'=>0,'is_del'=>0))->count();
        $num_kinds_order_uncheck['o_14'] = M('added_services')->where(array('status'=>0,'is_del'=>0))->count();
        $this->assign('kou',$num_kinds_order_uncheck);
        $this->assign('dish_menu_list',$dish_menu_list);
        $this->assign('system_menu_list',$system_menu_list);
        $this->assign('shop_menu_list',$shop_menu_list);
        $this->assign('settlement_menu_list',$settlement_menu_list);
        $this->assign('accounts_menu_list',$accounts_menu_list);
        /*by Nicolas 20170317 end*/
        $this->assign('menu_list',$menu_list);
        $admin_info = getAdminInfo(session('admin_id'));
		$order_amount = M('order')->where("order_status=0 and (pay_status=1 or pay_code='cod')")->count();
		$this->assign('order_amount',$order_amount);
		$this->assign('admin_info',$admin_info);
        $this->display();
    }
   
    public function welcome(){

//        $wait_handle_total=get_all_order();//待处理订单
        $wait_handle_total=get_all_order();//待处理订单
        $this->assign('wait_handle_total',$wait_handle_total);

        $all_total=all_order();//总订单
        $this->assign('all_total',$all_total);


        $had_handle_order=had_handle_order();//已处理订单
        $this->assign('had_handle_order',$had_handle_order);


            $get_members=get_members();//会员
        $this->assign('get_members',$get_members);

      $today_order=today_order();//新增订单
        $this->assign('today_order',$today_order);

        $today_member=D("users")->where(['add_time'=>['gt',date("Y-m-d")." 00:00:00"]])->count();//新增会员

        $this->assign('today_member',$today_member);


    	$this->assign('sys_info',$this->get_sys_info());



        $this->display();
    }
    
    public function get_sys_info(){
		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = Off		
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
		$sys_info['curl']			= function_exists('curl_init') ? 'YES' : 'NO';	
		$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();
		$sys_info['ip'] 			= GetHostByName($_SERVER['SERVER_NAME']);
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		$sys_info['max_ex_time'] 	= @ini_get("max_execution_time").'s'; //脚本最大执行时间
		$sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
		$sys_info['domain'] 		= $_SERVER['HTTP_HOST'];
		$sys_info['memory_limit']   = ini_get('memory_limit');		
        $sys_info['version']   	    = file_get_contents('./Application/Admin/Conf/version.txt');
		$mysqlinfo = M()->query("SELECT VERSION() as version");
		$sys_info['mysql_version']  = $mysqlinfo['version'];
		if(function_exists("gd_info")){
			$gd = gd_info();
			$sys_info['gdinfo'] 	= $gd['GD Version'];
		}else {
			$sys_info['gdinfo'] 	= "未知";
		}
		return $sys_info;
    }
    
    
    public function pushVersion()
    {
        if(!empty($_SESSION['isset_push']))
            return false;    
        $_SESSION['isset_push'] = 1;    
        error_reporting(0);//关闭所有错误报告
        $app_path = dirname($_SERVER['SCRIPT_FILENAME']).'/';
        $version_txt_path = $app_path.'/Application/Admin/Conf/version.txt';
        $curent_version = file_get_contents($version_txt_path);

        $vaules = array(            
                'domain'=>$_SERVER['SERVER_NAME'], 
                'last_domain'=>$_SERVER['SERVER_NAME'], 
                'key_num'=>$curent_version, 
                'install_time'=>INSTALL_DATE,
                'serial_number'=>SERIALNUMBER,
         );     
         $url = "http://service.shop.yiqidongfang.com/index.php?m=Home&c=Index&a=user_push&".http_build_query($vaules);
         stream_context_set_default(array('http' => array('timeout' => 3)));
         file_get_contents($url);         
    }
    
    /**
     * ajax 修改指定表数据字段  一般修改状态 比如 是否推荐 是否开启 等 图标切换的
     * table,id_name,id_value,field,value
     */
    public function changeTableVal(){  
            $table = I('table'); // 表名
            $id_name = I('id_name'); // 表主键id名
            $id_value = I('id_value'); // 表主键id值
            $field  = I('field'); // 修改哪个字段
            $value  = I('value'); // 修改字段值                        
            M($table)->where("$id_name = $id_value")->save(array($field=>$value)); // 根据条件保存修改的数据
    }	    

}