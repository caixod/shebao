<?php
namespace Home\Controller;
use Home\Logic\UsersLogic;
use Think\Page;
use Think\Verify;
/*
 * 非企业订单的支付页面
 * 企业订单支付在  CompanyorderController.class.php
 * */
class DopayController extends BaseController {
    public function _initialize() {
        parent::_initialize();


        $this->assign('act',ACTION_NAME);
        if($_SESSION['account_name']){
            $this->assign('username',$_SESSION['account_name']);
        }else{
            $this->assign('username','游客');
        }

        if($_SESSION['user_type']){
            $this->back_url="company_index";
        }else{
            $this->back_url="index";
        }

    }
    public function index(){
        
    }



    /*
     * 点击支付成功按钮。检查订单是否支付。
     * */
    public function success_pay(){
        $order_id_arr=$_SESSION['order_data']['order_id_arr'];
        $table_name=$_SESSION['order_data']['table_name'];
        $total=$_SESSION['order_data']['total'];
        $request_num= $_SESSION['order_data']['request_num'];

        $id_str=implode(',',$order_id_arr);

        if($table_name && $request_num){
            $timestamp=$this->getMillisecond();
            $pay_info=D("dlb_config")->find();
            $url="https://openapi.duolabao.com";
            $path="/v1/customer/order/payresult/{$pay_info['customernum']}/{$pay_info['shopnum']}/{$request_num}";

            $str = "secretKey={$pay_info['secretkey']}&timestamp=$timestamp&path=$path";
            $token = strtoupper(sha1($str));

            $headers= array(
                'Content-Type: application/json',
                'accesskey: ' . $pay_info['accesskey'],
                'timestamp: ' .$timestamp,
                'token: ' . $token);
            $ret=httpRequest_json($url.$path,'GET',null,$headers);
            $result=json_decode($ret,true);

            if($result['data']['status']=='SUCCESS'){
                $info=D("{$table_name}")->where("id in ({$id_str})")->save(['is_pay'=>1]);

                $_SESSION['order_data']='';
                $this->success("订单支付成功",U("Home/Order/{$this->back_url}"));
            }else{
                $this->error("订单支付失败",U("Home/Order/{$this->back_url}"));
            }
//            dump($result);
        }else{
            $this->error("订单不存在",U("Checklogin/shebao_dj"));
        }

    }

//    //支付页面出支付码
    public function callback(){
//        dump($_GET);die;

        $status=$_GET['status'];
        $order_sn=$_GET['order_sn'];
        $table=$_GET['table'];
        $coupon_id=$_GET['coupon_id'];
        $orderAmount=$_GET['orderAmount'];

        if($status=="SUCCESS"){
//            $this->_remark_coupon($order_sn);
           D("{$table}")->where(['order_sn'=>"{$order_sn}"])->save(['is_pay'=>1]);//修改订单状态。

            D("order_info")->where(['order_sn'=>"{$order_sn}"])
                ->save(['is_pay'=>1,'pay_money'=>$orderAmount]);//订单支付汇总表记录支付情况,和实际支付金额。

            D("coupon")->where(['coupon_id'=>$coupon_id])->save(['order_sn'=>$order_sn,'is_use'=>2,'use_time'=>time(),]);//扣除代金券

            $this->success("订单支付成功",U("Home/Order/shebao_dj"));
        }else{
             $this->error("订单支付失败,请重新下单",U("Home/Order/shebao_dj"));
        }

    }
    //支付等待页面。ajax一直循环调用查询是否支付完成。自动跳转。
    public function ajax_is_pay(){
//        data:{'table_name':table_name,'sn':sn},
        $table_name=I('post.table_name');
        $sn=I('post.sn');
        if($sn && $table_name){
            $info=D("{$table_name}")->where(['order_sn'=>"{$sn}"])->find();
            if($info['is_pay']==1){

                $_SESSION['order_data']='';
                echo json_encode(array('code'=>1,'mess'=>'订单支付成功'));die;
            }else{
                echo json_encode(array('code'=>0,'mess'=>'订单待支付'));die;

            }
        }else{
            echo json_encode(array('code'=>0,'mess'=>'订单待支付'));die;
        }
    }

    /**
     * 创建订单接口,所有支付都在这里
     *   $_SESSION['order_data']=[
    'order_id_arr'=>$order_id_arr,
    'table_name'=>'sb_daijiao',
    'total'=>$fee_data['all_total'],
    ];
     */
    public function createDLBPay(){
        $order_id_arr=$_SESSION['order_data']['order_id_arr'];//订单id
        $table_name=$_SESSION['order_data']['table_name'];//表名
        $total=$_SESSION['order_data']['total'];//订单的总金额
        $coupon_id=$_SESSION['order_data']['coupon_id'];//代金券
        $order_info_id=$_SESSION['order_data']['order_info_id'];//订单支付汇总表
        $id_str=implode(',',$order_id_arr);
//        dump($_SESSION);die;
//        com/index.php/Home/Dopay/createDLBPay.html
        if($order_id_arr && $table_name){
            $pay_info=D("dlb_config")->find();
            $order=D("{$table_name}")->where("id in ($id_str)")->find();//取出订单信息
          if($pay_info) {
              if ($order['is_pay'] == 0) {
                  $request_num=get_order_sn();//生成同意的订单号
                  D("{$table_name}")->where("id in ($id_str)")->save(['order_sn'=>$request_num]);
                  D("order_info")->where(['id'=>$order_info_id])->save(['order_sn'=>$request_num]);//订单支付汇总表记录支付情况
                  $_SESSION['order_data']['request_num']=$request_num;
                  $data['dlb_customer_num'] = $pay_info['customernum'];
                  $data['dlb_shop_num'] = $pay_info['shopnum'];
                  $data['request_num'] = $request_num; //注：必须为18-32位纯数字
                $data['amount'] =$total;
//                  $data['amount'] = "0.01";
//            $data['callback_url'] =urlencode('pc.zhongguoshebaodaili.cn/index.php/Home/Dopay/callback.html');
                  $data['callback_url'] = "pc.zhongguoshebaodaili.cn/index.php/Home/Dopay/callback/table/{$table_name}/order_sn/{$request_num}/coupon_id/{$coupon_id}/order_info_id/{$order_info_id}.html";
                  $req_bak = $this->request_createpay($data);
//              file_put_contents('/data/www/pc.zhongguoshebaodaili.cn/wwwroot/aaa.html',print_r($data,true),FILE_APPEND);
                  if ($req_bak['code'] == 200) {

                      //如果是微信访问直接去调起支付，如果是其他则显示支付二维码
                      if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                          header("location:" . $req_bak['url']['payurl']);
                      } else {
                          $this->assign('table_name',$table_name);
                          $this->assign('order_sn',$request_num);
                          $this->assign('code', $req_bak['url']['payurl']);
                          $this->display('payment');
                      }

                  } else {
                      $this->error("支付请求失败,请重新下单", U("Checklogin/shebao_dj"));
                  }
                  }else{
                  $this->success("订单已支付", U("Home/Order/{$this->back_url}"));
                  }

              } else {
                  $this->error("支付参数错误,请重新下单", U("Checklogin/shebao_dj"));
              }

        }else{
            $this->error("错误,请重新下单",U("Checklogin/shebao_dj"));
        }

    }

    /**
    * 创建哆啦宝微信支付
    */
    protected function request_createpay($data){
        $path='/v1/customer/order/payurl/create';
        $PayConfig =D("dlb_config")->find();
//        dump($PayConfig);
        if(is_array($PayConfig)){
            $pay_data['accesskey'] = $PayConfig['accesskey'];
            $pay_data['secretkey'] = $PayConfig['secretkey'];
            $pay_data['timestamp'] = $this->getMillisecond();
            $pay_data['path'] =$path; //;
            $sign_data = array(
//                'agentNum'=>"10001014472963095391100",            // 代理商编号
                'amount'=>$data['amount'],                          // 金额--请求传递
                'callbackUrl'=>$data['callback_url'],               // 回调服务器链接--请求传递
                'customerNum'=>$data['dlb_customer_num'],           // 哆啦宝商户号--请求传递
                'requestNum'=>$data['request_num'],                 // 订单号--请求传递  注：必须为18-32位纯数字
                'shopNum'=>$data['dlb_shop_num'],                   // 哆啦宝店铺号--请求传递
                'source'=>'API',
            );
            $pay_data['body'] = json_encode($sign_data);
            $infoArr = $this->creatTokenPost($pay_data);
//            dump($pay_data);
//            dump($infoArr);
            switch ($infoArr['result']) {
                case 'success'://成功
                    $payurl = $infoArr['data']['url'];
                    return  array('code'=>200,'msg'=>'订单支付创建成功','url'=>array('payurl'=>$payurl));
                    break;
                case 'fail'://失败
                    return array('code'=>502,'msg'=>'订单支付创建失败');
                    break;
                case 'error'://异常
                    return array('code'=>501,'msg'=>'服务器繁忙，支付调用失败');
                    break;
                default:
                    break;
            }
        }else{
            return array('code'=>502,'msg'=>'订单支付创建失败');
        }
    }


    /**
     * 退款接口
     */
    public function refundDLBPay(){
        $data['dlb_customer_num'] = $_POST['customer_num'];
        $data['dlb_shop_num'] = $_POST['shop_num'];
        $data['request_num'] = $_POST['request_num']; //注：必须为18-32位纯数字
        $req_bak = $this->request_refundpay($data);
        echo json_encode($req_bak);
    }


    /**
    * 申请哆啦宝微信退款
    */
    protected function request_refundpay($data){
        echo "**".$data['dlb_customer_num']."**".$data['dlb_shop_num']."**".$data['request_num']."**";
        $PayConfig = $this->config('dlbpay');
        if(is_array($PayConfig)){
            $pay_data['accesskey'] = $PayConfig['dlb_access_key'];
            $pay_data['secretkey'] = $PayConfig['dlb_secret_key'];
            $pay_data['timestamp'] = $this->getMillisecond();
            $pay_data['path'] = $PayConfig['dlb_path_refund'];      //'/v1/agent/order/payurl/create';
            $sign_data = array(
                'agentNum'=>$PayConfig['dlb_agent_num'],            // 代理商编号
                'customerNum'=>$data['dlb_customer_num'],           // 哆啦宝商户号--请求传递
                'requestNum'=>$data['request_num'],                 // 订单号--请求传递  注：必须为18-32位纯数字
                'shopNum'=>$data['dlb_shop_num'],                   // 哆啦宝店铺号--请求传递
            );
            $pay_data['body'] = json_encode($sign_data);
            $infoArr = $this->creatTokenPost($pay_data);
            switch ($infoArr['result']) {
                case 'success'://成功
                    $payurl = $infoArr['data']['url'];
                    return array('code'=>200,'msg'=>'订单退款成功','url'=>array('payurl'=>$payurl));
                    break;
                case 'fail'://失败
                    return array('code'=>502,'msg'=>'订单退款失败');
                    break;
                case 'error'://异常
                    return array('code'=>501,'msg'=>'服务器繁忙，退款失败，请稍后再试试');
                    break;
                default:
                    break;
            }
        }else{
            return array('code'=>502,'msg'=>'订单退款失败');
        }
    }
    
    //生成token并提交
    protected function creatTokenPost($data) {
        $str = "secretKey={$data['secretkey']}&timestamp={$data['timestamp']}&path={$data['path']}&body={$data['body']}";
        $token = strtoupper(sha1($str));
        $url = 'https://openapi.duolabao.cn'.$data['path'];
//dump($url);
        $post_data = $data['body'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'accesskey: ' . $data['accesskey'],
            'timestamp: ' . $data['timestamp'],
            'token: ' . $token)
        );
        $info = curl_exec($ch);
//        $requestinfo = curl_getinfo($ch);
        $infoArr = json_decode($info,true);
//        dump($requestinfo);
    //    put_contents('log/payurl_result',$infoArr,1);
        curl_close($ch);
        return $infoArr;
    }
    
    /**13位时间戳**/
    function getMillisecond() {
	list($t1, $t2) = explode(' ', microtime());
	return $t2.ceil( ($t1 * 1000) );
    }

}


