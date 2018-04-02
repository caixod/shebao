<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 北京易启东方网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.shop.yiqidongfang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace Mobile\Controller;
class PaymentController extends MobileBaseController {
    
    public $payment; //  具体的支付类
    public $pay_code; //  具体的支付code
 
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();                                                  
        // tpshop 订单支付提交
        $pay_radio = $_REQUEST['pay_radio'];

        if(!empty($pay_radio)) 
        {                         
            $pay_radio = parse_url_param($pay_radio);
            $this->pay_code = $pay_radio['pay_code']; // 支付 code
        }
        else // 第三方 支付商返回
        {            
            $_GET = I('get.');            
            //file_put_contents('./a.html',$_GET,FILE_APPEND);    
            $this->pay_code = I('get.pay_code');
            unset($_GET['pay_code']); // 用完之后删除, 以免进入签名判断里面去 导致错误
        }

        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];               
        // 导入具体的支付类文件                
        include_once  "plugins/payment/{$this->pay_code}/{$this->pay_code}.class.php"; // D:\wamp\www\svn_tpshop\www\plugins\payment\alipay\alipayPayment.class.php                       
        $code = '\\'.$this->pay_code; // \alipay
        $this->payment = new $code();
    }
   
    /**
     * tpshop 提交支付方式
     */
    public function getCode(){
        
        C('TOKEN_ON',false); // 关闭 TOKEN_ON
        header("Content-type:text/html;charset=utf-8");
        $order_id = I('order_id'); // 订单id  商城的？
        $system_order_id = I('post.system_order_id'); // 订餐订单id
//        $system_order_id = I('get.system_order_id'); // 订餐订单id
        // 修改订单的支付方式

        $payment_arr = M('Plugin')->where("`type` = 'payment'")->getField("code,name");
        if(!empty($system_order_id)){
        M('Dish_order')->where(array("system_order_id"=>$system_order_id))->save(array('pay_type'=>$this->pay_code,'pay_type_name'=>$payment_arr[$this->pay_code]));
        $order = M('Dish_order')->where(array('system_order_id'=> $system_order_id))->find();
        if($order['paid'] == 1){
            $this->error('此订单，已完成支付!');
            }
        }else{
        M('order')->where("order_id = $order_id")->save(array('pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));
        $order = M('order')->where("order_id = $order_id")->find();
        if($order['pay_status'] == 1){
            $this->error('此订单，已完成支付!');
        }
    }
        /*M('order')->where("order_id = $order_id")->save(array('pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));
        $order = M('order')->where("order_id = $order_id")->find(); */
        /*if($order['pay_status'] == 1){
            $this->error('此订单，已完成支付!');
        }*/
        //tpshop 订单支付提交
        $pay_radio = $_REQUEST['pay_radio'];

        $config_value = parse_url_param($pay_radio); // 类似于 pay_code=alipay&bank_code=CCB-DEBIT 参数
        //微信JS支付
       if($this->pay_code == 'weixin' && $_SESSION['openid'] && strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
           if(!empty($system_order_id)){
               $code_str = $this->payment->getDishJSAPI($order);
           }else{
               $code_str = $this->payment->getJSAPI($order);
           }
           exit($code_str);
       }else{
            $code_str = $this->payment->get_code($order,$config_value);
       }
        $this->assign('code_str', $code_str);
    if(!empty($system_order_id)){
        $this->assign('order_id', $system_order_id);
    }else{
        $this->assign('order_id', $order_id);
    }
        $this->display('payment');  // 分跳转 和不 跳转
    }

    public function getPay(){
    	//手机端在线充值
        C('TOKEN_ON',false); // 关闭 TOKEN_ON 
        header("Content-type:text/html;charset=utf-8");
        $order_id = I('order_id'); //订单id
        $user = session('user');
        $data['account'] = I('account');
        if($order_id>0){
        	M('recharge')->where(array('order_id'=>$order_id,'user_id'=>$user['user_id']))->save($data);
        }else{
        	$data['user_id'] = $user['user_id'];
        	$data['nickname'] = $user['nickname'];
        	$data['order_sn'] = 'recharge'.get_rand_str(10,0,1);
        	$data['ctime'] = time();
        	$order_id = M('recharge')->add($data);
        }
        if($order_id){
        	$order = M('recharge')->where("order_id = $order_id")->find();
        	if(is_array($order) && $order['pay_status']==0){
        		$order['order_amount'] = $order['account'];
        		$pay_radio = $_REQUEST['pay_radio'];
        		$config_value = parse_url_param($pay_radio); // 类似于 pay_code=alipay&bank_code=CCB-DEBIT 参数
        		$payment_arr = M('Plugin')->where("`type` = 'payment'")->getField("code,name");
        		M('recharge')->where("order_id = $order_id")->save(array('pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));       		
        		//微信JS支付
        		if($this->pay_code == 'weixin' && $_SESSION['openid'] && strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
        			$code_str = $this->payment->getJSAPI($order);
        			exit($code_str);
        		}else{
        			$code_str = $this->payment->get_code($order,$config_value);
        		}
        	}else{
        		$this->error('此充值订单，已完成支付!');
        	}
        }else{
        	$this->error('提交失败,参数有误!');
        }
        $this->assign('code_str', $code_str); 
        $this->assign('order_id', $order_id); 
    	$this->display('recharge'); //分跳转 和不 跳转
    }
        // 服务器点对点 // http://shop.yiqidongfang.com/index.php/Home/Payment/notifyUrl
        public function notifyUrl(){            
            $this->payment->response();            
            exit();
        }

        // 页面跳转 // http://shop.yiqidongfang.com/index.php/Home/Payment/returnUrl
        public function returnUrl(){
            $result = $this->payment->respond2(); // $result['order_sn'] = '201512241425288593';  
            if(stripos($result['order_sn'],'recharge') !== false)
            {
            	$order = M('recharge')->where("order_sn = '{$result['order_sn']}'")->find();
            	$this->assign('order', $order);
            	if($result['status'] == 1)
            		$this->display('recharge_success');
            	else
            		$this->display('recharge_error');
            	exit();
            }          
            $order = M('order')->where("order_sn = '{$result['order_sn']}'")->find();
            $this->assign('order', $order);
            if($result['status'] == 1)
                $this->display('success');   
            else
                $this->display('error');   
        }                
}
