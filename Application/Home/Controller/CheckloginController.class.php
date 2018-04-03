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
 * 2015-11-21
 */
namespace Home\Controller;
use Home\Logic\UsersLogic;
use Think\Page;
use Think\Verify;

class CheckloginController extends BaseController {

    public $user_id = 0;
    public $user = array();

    public function _initialize() {
        parent::_initialize();

        $nologin = array('shebao_bujiao','gongjijin_bujiao','shebao_zhuanyi','gjj_zhuanyi','gjj_tiqu','yl_sgz','sy_shenqing','yd_bajy','sb_editinfo','own_money','tx_yanglao','school_info','rc_yingjin','company_order','shebao_dj','gjj_daijiao');

        if(!session('account_name'))
       {
            if(in_array(ACTION_NAME,$nologin)){

               $this->error("请先登录……",U('Home/Checklogin/login'));
                exit;
            }
        }

        $is_lock=0;
        $this->assign('act',ACTION_NAME);
        if($_SESSION['account_name'] && ACTION_NAME != "logout"){
            $is_ok=check_mess_isok();//检查字段是否填写全
            if(!$is_ok && in_array(ACTION_NAME,$nologin)){
                $is_lock=1;
//                $this->error("请先完善个人资料",U('Home/Order/edit_info'));
//                exit;
            }
            //如果办理企业服务。需要填写企业信息
            if('company_order'==ACTION_NAME){
                $ok=check_company_isok();
//                dump($ok);die;
                if(!$ok){
                    $is_lock=2;
//                    $this->assign('is_lock',1);
//                    $this->error("请先完善单位信息",U('Home/Order/company'));
//                    exit;
                }
            }
            $this->assign('username',$_SESSION['account_name']);
        }else{
            $this->assign('username','游客');
        }
        $this->assign('is_lock',$is_lock);
        $this->assign('user_type',$_SESSION['user_type']);
    }
    /*
     * 统一支付下单页面，订单详情确认页面
     * 订单保存完成之后，跳转到这个页面  $service_name sure_order_info
     * */
    public function sure_order_info(){
        $total_fee=$_SESSION['order_data']['total'];
        $table_name=$_SESSION['order_data']['table_name'];
        if(IS_POST){
            $coupon_id=I("post.coupon_id",0);
            //将订单汇总信息写入表里
            if($coupon_id){
                $sql=" user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."' and max_fee<='{$total_fee}' and id={$coupon_id}";
                $coupon=D("coupon")->where($sql)->find();
                if($coupon){
                    $end_total_fee=($total_fee-$coupon['money']);//订单优惠金额
                    //保存信息到汇总列表，
                    $data=[
                        'user_id'=>$_SESSION['user_id'],
                        'front_total'=>$total_fee,
                        'total'=>$end_total_fee,
                        'table_name'=>$table_name,
                        'coupon_id'=>$coupon_id,
                        'coupon_fee'=>$coupon['money'],
                        'add_time'=>time()
                     ];
                    $r=D("order_info")->add($data);//支付完成之后，补全订单号
                    $id=D("order_info")->getLastInsID();
                     $_SESSION['order_data']['order_info_id']=$id;
                     $_SESSION['order_data']['total']=$end_total_fee;
                     $_SESSION['order_data']['coupon_id']=$coupon_id;
                     if($r){
                         $data=['table_name'=>"$table_name",'user_id'=>$_SESSION['user_id']];
                         D("coupon")->where(['coupon_id'=>$coupon_id])->save($data);//标记代金券
                         header("location:".U('Dopay/createDLBPay'));//去支付
                     }else{
                         $this->error("错误……");die;
                     }
                }else{
                    $this->error("代金券信息有误");die;
                }

            }else{//未使用代金券
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'front_total'=>$total_fee,
                    'total'=>$total_fee,
                    'table_name'=>$table_name,
                    'coupon_id'=>0,
                    'coupon_fee'=>0.00,
                    'add_time'=>time()
                ];
                $r=D("order_info")->add($data);//支付完成之后，补全订单号
                $id=D("order_info")->getLastInsID();
                $_SESSION['order_data']['order_info_id']=$id;
                $_SESSION['order_data']['total']=$total_fee;
                $_SESSION['order_data']['coupon_id']=0;
                if($r){
                    header("location:".U('Dopay/createDLBPay'));//去支付
                }else{
                    $this->error("错误……");die;
                }
            }
//           dump($_POST);
            die;
        }
        $service_name=I("get.service_name");

//        $total_fee=400;
        if($total_fee){
            $sql=" user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."' and max_fee<='{$total_fee}'";
            $coupon=D("coupon")->where($sql)->select();

            $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
            $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($coupon);
            $this->assign('area_list',$area_list);//开通地区列表

            $this->assign('coupon',$coupon);
            $this->assign('total_fee',$total_fee);
            $this->assign('service_name',$service_name);
            $this->display();
        }else{
            $this->error("无效的订单,请重新下单");
        }

    }


    public function aa(){
        $this->display('mobile_center');
    }
    //微信公众号更多服务
    public function mobile_center(){
        $this->display();
    }

    //手机端的个人社保代办
    public function mobile_own_sb_daijiao(){
        $model=D("sb_daijiao");
        if(IS_POST){
            dump($_POST);die;
            $shebao_start_time=I('post.shebao_start_time','');
            $shebao_end_time=I('post.shebao_end_time','');
            $gjj_start_time=I('post.gjj_start_time','');
            $gjj_end_time=I('post.gjj_end_time','');

            $to_province=I('post.to_province');
            $to_city=I('post.to_city');

            $is_gjj=I('post.is_gjj',0);
            $is_shebao=I('post.is_shebao',0);
            if($is_gjj && $is_shebao){
                $sb_type=1;
            }elseif($is_gjj){
                $sb_type=3;
            }elseif($is_shebao){
                $sb_type=2;
            }
            $shebao_jishu_arr=I('post.shebao_jishu');
            $gjj_jishu_arr=I('post.gjj_jishu');

            $user=[];
            foreach($shebao_jishu_arr as $k=>$v){
                $user[$k]['shebao_base']=$v;
                $user[$k]['gjj_base']=$gjj_jishu_arr[$k];
            }
            $shebao_date=[$shebao_start_time,$shebao_end_time];
            $gjj_date=[$gjj_start_time,$gjj_end_time];

            $fee_data=shebao_daijiao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$to_city);

//            dump($fee_data);


            $sb_base_info=D("region")->where(['id'=>intval($to_city)])->find();
            $order_id_arr=[];//订单id
            foreach($fee_data['data_fee'] as $ok=>$ov){
//                $order_sn=get_order_sn();
                $actual_info= D("users")->where(['user_id'=>$ok])->find();
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'add_time'=>time(),
                    'sb_base'=>$shebao_jishu_arr[$ok],
                    'gjj_base'=>$gjj_jishu_arr[$ok],
                    'is_gjj'=>$sb_type,
                    'start_time'=>"$shebao_start_time",
                    'end_time'=>"$shebao_end_time",
                    'gjj_start_time'=>"$gjj_start_time",
                    'gjj_end_time'=>"$gjj_end_time",
                    'to_province'=>$to_province,
                    'to_city'=>$to_city,

                    "actual_user_id"=>$ok,
                    'image'=>"{$actual_info['image']}",
                    'image_t'=>"{$actual_info['image_t']}",

                    "username"=>"{$actual_info['username']}",
                    "idcard"=>"{$actual_info['idcard']}",
                    "mobile"=>"{$actual_info['mobile']}",
                    "sex"=>$actual_info['sex'],
                    "nature"=>$actual_info['nature'],
                    "bank_num"=>"{$actual_info['bank_num']}",
                    "bank_name"=>"{$actual_info['bank_name']}",
                    "money"=>$ov['total_fee'],
                    "gjj_unit_fee"=>$ov['gjj_unit_fee'],
                    "sb_unit_fee"=>$ov['sb_unit_fee'],
                    "gjj_fee"=>$ov['gjj_fee'],
                    "sb_fee"=>$ov['sb_fee'],
                    "service_fee"=>$ov['service_fee'],
                    "xian_one_base"=>$ov['xian_one_base'],
                    "c_xian_one"=>$sb_base_info['c_xian_one'],
                    "xian_one"=>$sb_base_info['xian_one'],
                    "xian_two_base"=>$ov['xian_two_base'],
                    "c_xian_two"=>$sb_base_info['c_xian_two'],
                    "xian_two"=>$sb_base_info['xian_two'],
                    "xian_three_base"=>$ov['xian_three_base'],
                    "c_xian_three"=>$sb_base_info['c_xian_three'],
                    "xian_three"=>$sb_base_info['xian_three'],
                    "xian_four_base"=>$ov['xian_four_base'],
                    "xian_four"=>$sb_base_info['xian_four'],
                    "c_xian_four"=>$sb_base_info['c_xian_four'],
                    "xian_five_base"=>$ov['xian_five_base'],
                    "c_xian_five"=>$sb_base_info['c_xian_five'],
                    "xian_five"=>$sb_base_info['xian_five'],
                    "c_gjj_bilie"=>$sb_base_info['c_gjj_bilie'],
                    "gjj_bilie"=>$sb_base_info['gjj_bilie'],
                    "c_gjj_base"=>$ov['gjj_js_base'],

                    "xian_one_company"=>$ov['xian_one_company'],
                    "xian_one_own"=>$ov['xian_one_own'],
                    "xian_two_company"=>$ov['xian_two_company'],
                    "xian_two_own"=>$ov['xian_two_own'],
                    "xian_three_company"=>$ov['xian_three_company'],
                    "xian_three_own"=>$ov['xian_three_own'],
                    "xian_four_company"=>$ov['xian_four_company'],
                    "xian_four_own"=>$ov['xian_four_own'],
                    "xian_five_company"=>$ov['xian_five_company'],
                    "xian_five_own"=>$ov['xian_five_own'],
                    "gjj_own"=>$ov['gjj_own'],
                    "gjj_company"=>$ov['gjj_company'],


                ];
                $model->add($data);
                $id=$model->getLastInsID();
                $order_id_arr[]=$id;
            }

//            die;
            $_SESSION['order_data']=[
                'order_id_arr'=>$order_id_arr,
                'table_name'=>'sb_daijiao',
                'total'=>$fee_data['all_total'],
            ];
            header("location:".U('Checklogin/sure_order_info',array('service_name'=>"个人社保代缴")));//订单确认页面

            exit;
        }

        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
//        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($p);

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display();
    }

    /*
     * 用户中心首页
     */
    public function index(){

        header("location:".U('Home/Order/index'));
    }
    /*
     * 关于我们
     * */
    public function about(){

        $this->display();
    }


    public function to_order(){
        $this->display();
    }


    /*
     *所有的 非企业订单 点击支付费用跳转到此页面。
     * 去支付页面。先把数据结算清楚再去跳转到支付页面
     * 1.代金券扣除
     * 2、代金券金额写入
     *   'order_data' =>
                array (size=4)
                  'order_id' => string '4' (length=1)
                  'table_name' => string 'sy_shenqing' (length=11)
                  'total_fee' => string '33.00' (length=5)
                  'end_fee' => float 28
     */
    public function to_pay_order(){
//        dump($_SESSION);
        $coupon_id=I('post.coupon');
        $order_id=$_SESSION['order_data']['order_id'];
        $table_name=$_SESSION['order_data']['table_name'];
        $total_fee=$_SESSION['order_data']['total_fee'];
       if($coupon_id){//如果有代金券扣除，，就先去扣除代金券，再去支付码页面。
          //先检查代金券
           $sql="user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and id=".intval($coupon_id);
           $coupon=D("coupon")->where($sql)->find();
           if($coupon){
               $end_fee=round(($total_fee-$coupon['money']),2);
               //将属于写入订单
               $data=['money'=>$end_fee,'coupon_fee'=>$coupon['money'],'coupon_id'=>$coupon['id']];

               $ret=D("{$table_name}")->where(['id'=>$order_id])->save($data);

               if($ret){
                  D("coupon")->where($sql)->save(['is_use'=>2,'table_name'=>$table_name,'order_id'=>$order_id]);
                   $_SESSION['order_data']['end_fee']=$end_fee;
                   header("location:".U('Dopay/createDLBPay'));
               }else{
                   $this->error("出错了……");
               }

           }else{
               $this->error("出错了……");
           }
       }else{//直接去支付码页面
           $_SESSION['order_data']['end_fee']=$total_fee;
           header("location:".U('Dopay/createDLBPay'));

       }
    }

    /**
    代金券选择使用时候，计算费用
     */
    public function check_coupon(){
        $id=I("post.id");

        if($id){
            $sql="id={$id} and user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."'";
            $coupon=D("coupon")->where($sql)->find();
            $total_fee=$_SESSION['order_data']['total_fee'];
            if($coupon && $total_fee){
                $end_fee=round(($total_fee-$coupon['money']),2);
                echo json_encode(array('code'=>1,'end_fee'=>$end_fee));die;
            }else{
                echo json_encode(array('code'=>0));die;
            }
        }
    }
    /*
     * 只是社保代缴、补缴的订单到这里
     * */
    public function sb_daijiao_to_order(){

        $id=$_SESSION['order_data']['order_id'];
//dump($_SESSION);
        if($id){
            $order_info=D("{$_SESSION['order_data']['table_name']}")->where(['id'=>$id])->find();

            if($order_info){
                $result=shebao_daijiao_getBase($id);//计算费用bing保存到表里
//                if($result){
                    $order_data=D("{$_SESSION['order_data']['table_name']}")
                        ->alias("a")
                        ->field("a.*,b.name pname,c.name cname")
                        ->join("tp_region b on b.id=a.to_province ",'left')
                        ->join("tp_region c on c.id=a.to_city ",'left')
                        ->where(['a.id'=>$id])->find();

                        //取出该账户下面的代金券
                    $sql="user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."' and max_fee<={$order_data['money']}";
                    $coupon=D("coupon")->where($sql)->select();
//                    dump($coupon);
                    $this->assign('coupon',$coupon);
                    $this->assign('order_data',$order_data);
                    $this->display('sb_to_order');
//                }else{
//                    $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
//
//                }

            }else{
                $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
            }
        }else{
            $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
        }

    }



    /*
     * 订单明细列表页
       公积金转移、社保转移、
     * 订单支付完吧订单$_session['order_data']的订单信息删掉
     */
    public function other_to_order_list(){
        $id=$_SESSION['order_data']['order_id'];
        $table_name=$_SESSION['order_data']['table_name'];
        if($id){
            $order_info=D("{$table_name}")->where(['id'=>$id])->find();
            if($order_info){
                $is_true=other_service_order($id);
//                if($is_true){
//                    dump($_SESSION['order_data']['table_name']);
                    $order_data=D("{$_SESSION['order_data']['table_name']}")
                        ->alias("a")
                        ->field("a.*,b.name pname,c.name cname,d.name dname,op. name province,oc.name city,od.name district")
                        ->join("tp_region b on b.id=a.to_province ",'left')
                        ->join("tp_region c on c.id=a.to_city ",'left')
                        ->join("tp_region d on d.id=a.to_district ",'left')
                        ->join("tp_region op on op.id=a.out_province ",'left')
                        ->join("tp_region oc on oc.id=a.out_city ",'left')
                        ->join("tp_region od on od.id=a.out_district ",'left')
                        ->where(['a.id'=>$id])->find();
                    //取出代金券
                    $sql="user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."' and max_fee<={$order_data['money']}";
                    $coupon=D("coupon")->where($sql)->select();
                    $this->assign('coupon',$coupon);
//                    dump($coupon);
                    $this->assign('order_data',$order_data);
                    $this->display();
//                }else{
//                    $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
//                }

            }else{
                $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
            }

        }else{
            $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
        }
    }


    /*
     * 没有其他费用，只有办理地区的在这个里面
     * 公积金提取
     * */
    public function order_only_servicefee(){
        $id=$_SESSION['order_data']['order_id'];
        $table_name=$_SESSION['order_data']['table_name'];

        if($id){

            $order_info=D("{$table_name}")->where(['id'=>$id])->find();

            if($order_info){
//                dump($order_info);

                $is_true=other_service_order($id);//计算费用
//                dump($_SESSION);
//                dump($is_true);die;
//                if($is_true){

                    $order_data=D("{$_SESSION['order_data']['table_name']}")
                        ->alias("a")
                        ->field("a.*,b.name pname,c.name cname,d.name dname")
                        ->join("tp_region b on b.id=a.to_province ",'left')
                        ->join("tp_region c on c.id=a.to_city ",'left')
                        ->join("tp_region d on d.id=a.to_district ",'left')
                        ->where(['a.id'=>$id])->find();
                    //取出代金券

                    $sql="user_id={$_SESSION['user_id']} and is_use=1 and is_del=0 and start_time<='".date("Y-m-d")."' and end_time>='".date("Y-m-d")."' and max_fee<={$order_data['money']}";
                    $coupon=D("coupon")->where($sql)->select();
                    $this->assign('coupon',$coupon);
                    $this->assign('order_data',$order_data);
                    $this->assign('table_name',$_SESSION['order_data']['table_name']);
                    $this->display();
//                }else{
//                    $this->error('错误,请重新下单',U('Home/Checklogin/index'));
//                }

            }else{
                $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
            }

        }else{
            $this->error('订单失效,请重新下单',U('Home/Checklogin/index'));
        }
    }

    /**
    社保补缴
     */
    public function shebao_bujiao(){
        $model=D("sb_bujiao");
        if(IS_POST){
//            dump($_POST);
            $shebao_start_time=I('post.shebao_start_time','');
            $shebao_end_time=I('post.shebao_end_time','');
            $gjj_start_time=I('post.gjj_start_time','');
            $gjj_end_time=I('post.gjj_end_time','');

            $to_province=I('post.to_province');
            $to_city=I('post.to_city');

            $is_gjj=I('post.is_gjj',0);
            $is_shebao=I('post.is_shebao',0);
            if($is_gjj && $is_shebao){
                $sb_type=1;
            }elseif($is_gjj){
                $sb_type=3;
            }elseif($is_shebao){
                $sb_type=2;
            }
            $shebao_jishu_arr=I('post.shebao_jishu');
            $gjj_jishu_arr=I('post.gjj_jishu');

            $user=[];
            foreach($shebao_jishu_arr as $k=>$v){
                $user[$k]['shebao_base']=$v;
                $user[$k]['gjj_base']=$gjj_jishu_arr[$k];
            }
            $shebao_date=[$shebao_start_time,$shebao_end_time];
            $gjj_date=[$gjj_start_time,$gjj_end_time];

            $fee_data=shebao_daijiao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$to_city,1);


            $sb_base_info=D("region")->where(['id'=>intval($to_city)])->find();
            $order_id_arr=[];//订单id
            foreach($fee_data['data_fee'] as $ok=>$ov){
//                $order_sn=get_order_sn();
                $actual_info= D("users")->where(['user_id'=>$ok])->find();
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'add_time'=>time(),
                    'sb_base'=>$shebao_jishu_arr[$ok],
                    'gjj_base'=>$gjj_jishu_arr[$ok],
                    'is_gjj'=>$sb_type,
                    'start_time'=>"$shebao_start_time",
                    'end_time'=>"$shebao_end_time",
                    'gjj_start_time'=>"$gjj_start_time",
                    'gjj_end_time'=>"$gjj_end_time",
                    'to_province'=>$to_province,
                    'to_city'=>$to_city,
                    'image'=>"{$actual_info['image']}",
                    'image_t'=>"{$actual_info['image_t']}",
                    "actual_user_id"=>$ok,
                    "username"=>"{$actual_info['username']}",
                    "idcard"=>"{$actual_info['idcard']}",
                    "mobile"=>"{$actual_info['mobile']}",
                    "sex"=>$actual_info['sex'],
                    "nature"=>$actual_info['nature'],
                    "bank_num"=>"{$actual_info['bank_num']}",
                    "bank_name"=>"{$actual_info['bank_name']}",
                    "money"=>$ov['total_fee'],
                    "gjj_zhina_fee"=>$ov['gjj_zhinafee'],
                    "sb_zhina_fee"=>$ov['sb_zhinafee'],
                    "gjj_unit_fee"=>$ov['gjj_unit_fee'],
                    "sb_unit_fee"=>$ov['sb_unit_fee'],
                    "gjj_fee"=>$ov['gjj_fee'],
                    "sb_fee"=>$ov['sb_fee'],
                    "service_fee"=>$ov['service_fee'],
                    "xian_one_base"=>$ov['xian_one_base'],
                    "c_xian_one"=>$sb_base_info['c_xian_one'],
                    "xian_one"=>$sb_base_info['xian_one'],
                    "xian_two_base"=>$ov['xian_two_base'],
                    "c_xian_two"=>$sb_base_info['c_xian_two'],
                    "xian_two"=>$sb_base_info['xian_two'],
                    "xian_three_base"=>$ov['xian_three_base'],
                    "c_xian_three"=>$sb_base_info['c_xian_three'],
                    "xian_three"=>$sb_base_info['xian_three'],
                    "xian_four_base"=>$ov['xian_four_base'],
                    "xian_four"=>$sb_base_info['xian_four'],
                    "c_xian_four"=>$sb_base_info['c_xian_four'],
                    "xian_five_base"=>$ov['xian_five_base'],
                    "c_xian_five"=>$sb_base_info['c_xian_five'],
                    "xian_five"=>$sb_base_info['xian_five'],
                    "c_gjj_bilie"=>$sb_base_info['c_gjj_bilie'],
                    "gjj_bilie"=>$sb_base_info['gjj_bilie'],
                    "c_gjj_base"=>$ov['gjj_js_base'],

                    "xian_one_company"=>$ov['xian_one_company'],
                    "xian_one_own"=>$ov['xian_one_own'],
                    "xian_two_company"=>$ov['xian_two_company'],
                    "xian_two_own"=>$ov['xian_two_own'],
                    "xian_three_company"=>$ov['xian_three_company'],
                    "xian_three_own"=>$ov['xian_three_own'],
                    "xian_four_company"=>$ov['xian_four_company'],
                    "xian_four_own"=>$ov['xian_four_own'],
                    "xian_five_company"=>$ov['xian_five_company'],
                    "xian_five_own"=>$ov['xian_five_own'],
                    "gjj_own"=>$ov['gjj_own'],
                    "gjj_company"=>$ov['gjj_company'],
                ];
                $model->add($data);
                $id=$model->getLastInsID();
                $order_id_arr[]=$id;
            }

//            die;
            $_SESSION['order_data']=[
                'order_id_arr'=>$order_id_arr,
                'table_name'=>'sb_bujiao',
                'total'=>$fee_data['all_total'],
            ];
//            $service_name sure_order_info
            header("location:".U('Checklogin/sure_order_info',array('service_name'=>"社保补缴")));
        exit;
        }

        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);

//        dump($friend);

        $this->display("shebao_new_bujiao");
    }

  /**
    社保代缴
     */
    public function shebao_dj(){
        $model=D("sb_daijiao");
        if(IS_POST){
//            dump($_POST);
            $shebao_start_time=I('post.shebao_start_time','');
            $shebao_end_time=I('post.shebao_end_time','');
            $gjj_start_time=I('post.gjj_start_time','');
            $gjj_end_time=I('post.gjj_end_time','');

            $to_province=I('post.to_province');
            $to_city=I('post.to_city');

            $is_gjj=I('post.is_gjj',0);
            $is_shebao=I('post.is_shebao',0);
            if($is_gjj && $is_shebao){
                $sb_type=1;
            }elseif($is_gjj){
                $sb_type=3;
            }elseif($is_shebao){
                $sb_type=2;
            }
            $shebao_jishu_arr=I('post.shebao_jishu');
            $gjj_jishu_arr=I('post.gjj_jishu');

            $user=[];
            foreach($shebao_jishu_arr as $k=>$v){
                $user[$k]['shebao_base']=$v;
                $user[$k]['gjj_base']=$gjj_jishu_arr[$k];
            }
//            dump($is_gjj);
//            dump($is_shebao);die;
            $shebao_date=[$shebao_start_time,$shebao_end_time];
            $gjj_date=[$gjj_start_time,$gjj_end_time];

            $fee_data=shebao_daijiao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$to_city);

//            dump($fee_data);


            $sb_base_info=D("region")->where(['id'=>intval($to_city)])->find();
            $order_id_arr=[];//订单id
            foreach($fee_data['data_fee'] as $ok=>$ov){
//                $order_sn=get_order_sn();
                $actual_info= D("users")->where(['user_id'=>$ok])->find();
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'add_time'=>time(),
                    'sb_base'=>$shebao_jishu_arr[$ok],
                    'gjj_base'=>$gjj_jishu_arr[$ok],
                    'is_gjj'=>$sb_type,
                    'start_time'=>"$shebao_start_time",
                    'end_time'=>"$shebao_end_time",
                    'gjj_start_time'=>"$gjj_start_time",
                    'gjj_end_time'=>"$gjj_end_time",
                    'to_province'=>$to_province,
                    'to_city'=>$to_city,

                    "actual_user_id"=>$ok,
                    'image'=>"{$actual_info['image']}",
                    'image_t'=>"{$actual_info['image_t']}",

                    "username"=>"{$actual_info['username']}",
                    "idcard"=>"{$actual_info['idcard']}",
                    "mobile"=>"{$actual_info['mobile']}",
                    "sex"=>$actual_info['sex'],
                    "nature"=>$actual_info['nature'],
                    "bank_num"=>"{$actual_info['bank_num']}",
                    "bank_name"=>"{$actual_info['bank_name']}",
                    "money"=>$ov['total_fee'],
                    "gjj_unit_fee"=>$ov['gjj_unit_fee'],
                    "sb_unit_fee"=>$ov['sb_unit_fee'],
                    "gjj_fee"=>$ov['gjj_fee'],
                    "sb_fee"=>$ov['sb_fee'],
                    "service_fee"=>$ov['service_fee'],
                    "xian_one_base"=>$ov['xian_one_base'],
                    "c_xian_one"=>$sb_base_info['c_xian_one'],
                    "xian_one"=>$sb_base_info['xian_one'],
                    "xian_two_base"=>$ov['xian_two_base'],
                    "c_xian_two"=>$sb_base_info['c_xian_two'],
                    "xian_two"=>$sb_base_info['xian_two'],
                    "xian_three_base"=>$ov['xian_three_base'],
                    "c_xian_three"=>$sb_base_info['c_xian_three'],
                    "xian_three"=>$sb_base_info['xian_three'],
                    "xian_four_base"=>$ov['xian_four_base'],
                    "xian_four"=>$sb_base_info['xian_four'],
                    "c_xian_four"=>$sb_base_info['c_xian_four'],
                    "xian_five_base"=>$ov['xian_five_base'],
                    "c_xian_five"=>$sb_base_info['c_xian_five'],
                    "xian_five"=>$sb_base_info['xian_five'],
                    "c_gjj_bilie"=>$sb_base_info['c_gjj_bilie'],
                    "gjj_bilie"=>$sb_base_info['gjj_bilie'],
                    "c_gjj_base"=>$ov['gjj_js_base'],

                    "xian_one_company"=>$ov['xian_one_company'],
                    "xian_one_own"=>$ov['xian_one_own'],
                    "xian_two_company"=>$ov['xian_two_company'],
                    "xian_two_own"=>$ov['xian_two_own'],
                    "xian_three_company"=>$ov['xian_three_company'],
                    "xian_three_own"=>$ov['xian_three_own'],
                    "xian_four_company"=>$ov['xian_four_company'],
                    "xian_four_own"=>$ov['xian_four_own'],
                    "xian_five_company"=>$ov['xian_five_company'],
                    "xian_five_own"=>$ov['xian_five_own'],
                    "gjj_own"=>$ov['gjj_own'],
                    "gjj_company"=>$ov['gjj_company'],


                ];
                 $model->add($data);
                $id=$model->getLastInsID();
                $order_id_arr[]=$id;
            }

//            die;
                    $_SESSION['order_data']=[
                        'order_id_arr'=>$order_id_arr,
                        'table_name'=>'sb_daijiao',
                        'total'=>$fee_data['all_total'],
                    ];
            header("location:".U('Checklogin/sure_order_info',array('service_name'=>"个人社保代缴")));//订单确认页面
//            header("location:".U('Dopay/createDLBPay'));
//                  header("Location:".U('Home/Checklogin/sb_daijiao_to_order')."");


            exit;
        }

        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);

//        dump($friend);

        $this->display("shebao_daijiao");
    }



    /*
     *
     * ajax 获取对应城市的基数（公积金基数或者社保基数）
     *
     * **/
    public function get_jishu(){
        $city=I("post.city");
        if($city){
            $info=D("region")->where(['id'=>intval($city)])->find();
            $info['sb_min']=min($info['xian_one_min'],$info['xian_two_min'],$info['xian_three_min'],$info['xian_four_min'],$info['xian_five_min']);
            $info['sb_max']=max($info['xian_one_max'],$info['xian_two_max'],$info['xian_three_max'],$info['xian_four_max'],$info['xian_five_max']);
            echo json_encode(array('code'=>1,'mess'=>'正确','data'=>$info));die;
        }else{
            echo json_encode(array('code'=>0,'mess'=>'参数错误,请重试'));die;
        }

    }

    /*
     * ajax 计算 shebao gjj 对应的费用
     * 目前请求该方法的有【shebao_daiban,社保补缴】
     * 	data:{'gjj_user_id':gjj_user_id,'shebao_user_id':shebao_user_id,'date1':date1,'date2':date2,'date3':date3,'date4':date4,'is_shebao':is_shebao,'is_gjj':is_gjj,'city':city},
     * */

    public function calculate(){

        $is_mobile=I("is_mobile",0);//如果是手机端下单计算，不输出表格，返回json数据

        $shebao_user_id=I("post.shebao_user_id");
        $is_bujiao=I("post.is_bujiao");//是否是补缴的，是补缴的得收取滞纳金

        $gjj_base_str=I("post.gjj_base_str");
        $shebao_base_str=I("post.shebao_base_str");

        $shebao_base_arr=explode('-',trim($shebao_base_str,'-'));
        $gjj_base_arr=explode('-',trim($gjj_base_str,'-'));
        $shebao_user_id_arr=explode('-',trim($shebao_user_id,'-'));

        $date1=I("post.date1");
        $date2=I("post.date2");
        $date3=I("post.date3");
        $date4=I("post.date4");
        $is_shebao=I("post.is_shebao");
        $is_gjj=I("post.is_gjj");
        $city=I("post.city");

   if($city){
       //公积金
       $is_shebao=$is_shebao=='true' ? 1 : 0;
       $is_gjj=$is_gjj=='true' ? 1 : 0;
        $user=[];
        foreach($shebao_user_id_arr as $k=>$v){
            $user[$v]['shebao_base']=$shebao_base_arr[$k];
            $user[$v]['gjj_base']=$gjj_base_arr[$k];
        }
        $shebao_date=[$date1,$date2];
        $gjj_date=[$date3,$date4];

          $fee_data=shebao_daijiao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$city,$is_bujiao);

//        dump($fee_data);
//        dump($shebao_date);

       //手机端下单时候直接返回json数据 ，不显示这个通用的表格
       if($is_mobile){
           $sb_fee=0;
           $gjj_fee=0;
           $service_fee=0;
//           dump($fee_data['data_fee']);
           foreach($fee_data['data_fee'] as $k=>$v){
               $sb_fee+=$v['sb_fee'];
               $gjj_fee+=$v['gjj_fee'];
               $service_fee+=$v['service_fee'];
           }
                   echo json_encode(array('code'=>1,'sb_fee'=>$sb_fee,"gjj_fee"=>$gjj_fee,"service_fee"=>$service_fee,'all_total'=>$fee_data['all_total']));die;
       }else{
           $info=D("region")->where(['id'=>intval($city)])->find();
           $this->assign('sb_bilie',$info);
           $this->assign('fee_data',$fee_data['data_fee']);
           $this->assign('all_total',$fee_data['all_total']);
           $this->display('table_part');
       }


        }
//        else{
//            echo json_encode(array('code'=>0,'fee_data'=>0));die;
//        }
    }




    /*
     * 社保转移
     * */
    public function shebao_zhuanyi(){
        $model=D("sb_zhuanyi");
        if(IS_POST){
//            dump($_POST);die;
            $province=I('post.province');
            $city=I('post.city');
            $mark=I('post.mark');

            $to_city=I('post.to_city');
            $to_province=I('post.to_province');

            $user_id=I('post.user_id');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'out_province'=>$province,
                    'out_city'=>$city,
                    'mark'=>"{$mark}",

                    'to_province'=>$to_province,
                    'to_city'=>$to_city,
                    'add_time'=>time(),
                    'money'=>$info['sb_zhuanyi'],
                    'service_fee'=>$info['sb_zhuanyi'],

                    'image'=>"{$actual_info['image']}",
                    'image_t'=>"{$actual_info['image_t']}",
                    "actual_user_id"=>$user_id,
                    "username"=>"{$actual_info['username']}",
                    "idcard"=>"{$actual_info['idcard']}",
                    "mobile"=>"{$actual_info['mobile']}",
                    "sex"=>$actual_info['sex'],
                    "nature"=>$actual_info['nature'],
                    "bank_num"=>"{$actual_info['bank_num']}",
                    "bank_name"=>"{$actual_info['bank_name']}",
                ];

                $ret=$model->add($data);
                $id=$model->getLastInsID();
                if($id){
                    $_SESSION['order_data']=[
                        'order_id_arr'=>array($id),
                        'table_name'=>'sb_zhuanyi',
                        'total'=>$info['sb_zhuanyi'],
                    ];
                    header("location:".U('Checklogin/sure_order_info',array('service_name'=>"社保转移")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
                }else{
                    $this->error('订单提交失败,请重新提交');
                }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);

        $this->assign('friend',$friend);

        $this->display("shebao_zhuanyi_new");

    }

    /*
     * 公积金转移
     * */
    public function gjj_zhuanyi(){
        $model=D("gjj_zhuanyi");
        if(IS_POST){
//            dump($_POST);die;
            $province=I('post.province');
            $city=I('post.city');
            $mark=I('post.mark');
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');

            $user_id=I('post.user_id');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'out_province'=>$province,
                'out_city'=>$city,
                'mark'=>"$mark",

                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'add_time'=>time(),
                'money'=>$info['gjj_zhuanyi'],
                'service_fee'=>$info['gjj_zhuanyi'],

                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'gjj_zhuanyi',
                    'total'=>$info['gjj_zhuanyi'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"公积金转移")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);

        $this->display("gjj_zhuanyi_new");
    }
    /*
     * 公积金提取
     * */
    public function gjj_tiqu(){
          $model=D("gjj_tiqu");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
            $tq_type=I('post.tq_type');
            $mark=I('post.mark');
            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],

                'tq_type'=>$tq_type,
                'mark'=>"$mark",
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'add_time'=>time(),
                'money'=>$info['gjj_tiqu'],
                'service_fee'=>$info['gjj_tiqu'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'gjj_tiqu',
                    'total'=>$info['gjj_tiqu'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"住房公积金提取")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("gjj_tiqu_new");
//        $this->display();
    }

    /*
     * 医疗手工帐报销
     * */
    public function yl_sgz(){
          $model=D("yl_sgz");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
            $mark=I('post.mark');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],

                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"$mark",
                'add_time'=>time(),
                'money'=>$info['yl_sgz'],
                'service_fee'=>$info['yl_sgz'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'yl_sgz',
                    'total'=>$info['yl_sgz'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"医疗手工帐报销")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("yl_sgz_new");
//        $this->display();
    }

    /*
     * 生育待遇申领
     * */
    public function sy_shenqing(){
        $model=D("sy_shenqing");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
//            $tq_type=I('post.tq_type');
            $mark=I('post.mark');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],

                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"$mark",
                'add_time'=>time(),
                'money'=>$info['sy_shenqing'],
                'service_fee'=>$info['sy_shenqing'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'sy_shenqing',
                    'total'=>$info['sy_shenqing'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"生育待遇申领")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("sy_shenqing_new");
    }

    /*
     * 异地备案就医
     * */
    public function yd_bajy(){
        $model=D("yd_bajy");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
//            $tq_type=I('post.tq_type');
            $mark=I('post.mark');
            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"$mark",
                'add_time'=>time(),
                'money'=>$info['yd_bajy'],
                'service_fee'=>$info['yd_bajy'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'yd_bajy',
                    'total'=>$info['yd_bajy'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"异地就医备案")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("yd_bajy_new");
    }

    /*
     * 社保信息修改
     * */
    public function sb_editinfo(){
        $model=D("sb_editinfo");
        if(IS_POST){
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');

            $mark=I('post.mark');
            $user_id=I('post.user_id');
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
            $upload->exts  =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = './Public/upload/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $image_info   =   $upload->upload();

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"{$mark}",
                'add_time'=>time(),
                'money'=>$info['sb_editinfo'],
                'service_fee'=>$info['sb_editinfo'],
                'image'=>"{$image_info['image']['urlpath']}",
                'image_t'=>"{$image_info['image_t']['urlpath']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'sb_editinfo',
                    'total'=>$info['sb_editinfo'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"社保信息修改")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }

        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("sb_editinfo_new");
//        $this->display();
    }

    /*
     * 个人所得税
     * */
    public function own_money(){
        $model=D("own_money");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
            $mark=I('post.mark');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"{$mark}",
                'add_time'=>time(),
                'money'=>$info['own_money'],
                'service_fee'=>$info['own_money'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'own_money',
                    'total'=>$info['own_money'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"个人所得税申报")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("own_money_new");
    }

    /*
     * 退休养老办理
     * */
    public function tx_yanglao(){
        $model=D("tx_yanglao");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
            $mark=I('post.mark');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"{$mark}",
                'add_time'=>time(),
                'money'=>$info['tx_yanglao'],
                'service_fee'=>$info['tx_yanglao'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'tx_yanglao',
                    'total'=>$info['tx_yanglao'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"退休养老办理")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("tx_yanglao_new");
    }
    /*
        * 孩子上学材料
        * */
    public function school_info(){
        $model=D("school_info");
        if(IS_POST){
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');

            $mark=I('post.mark');
            $user_id=I('post.user_id');
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
            $upload->exts  =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = './Public/upload/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $image_info   =   $upload->upload();

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"{$mark}",
                'add_time'=>time(),
                'money'=>$info['school_info'],
                'service_fee'=>$info['school_info'],
                'image'=>"{$image_info['image']['urlpath']}",
                'image_t'=>"{$image_info['image_t']['urlpath']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'school_info',
                    'total'=>$info['school_info'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"孩子上学材料")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }

        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);

        $this->display();
    }

    /*
     * 天津人才引进
     * */
    public function rc_yingjin(){
        $model=D("rc_yingjin");
        if(IS_POST){
//            dump($_POST);die;
            $to_city=I('post.to_city');
            $to_province=I('post.to_province');
            $user_id=I('post.user_id');
            $mark=I('post.mark');

            $info=D("region")->where(['id'=>intval($to_city)])->find();
            $actual_info= D("users")->where(['user_id'=>$user_id])->find();
            $data=[
                'user_id'=>$_SESSION['user_id'],
                'to_province'=>$to_province,
                'to_city'=>$to_city,
                'mark'=>"{$mark}",
                'add_time'=>time(),
                'money'=>$info['rc_yingjin'],
                'service_fee'=>$info['rc_yingjin'],
                'image'=>"{$actual_info['image']}",
                'image_t'=>"{$actual_info['image_t']}",
                "actual_user_id"=>$user_id,
                "username"=>"{$actual_info['username']}",
                "idcard"=>"{$actual_info['idcard']}",
                "mobile"=>"{$actual_info['mobile']}",
                "sex"=>$actual_info['sex'],
                "nature"=>$actual_info['nature'],
                "bank_num"=>"{$actual_info['bank_num']}",
                "bank_name"=>"{$actual_info['bank_name']}",
            ];

            $ret=$model->add($data);
            $id=$model->getLastInsID();
            if($id){
                $_SESSION['order_data']=[
                    'order_id_arr'=>array($id),
                    'table_name'=>'rc_yingjin',
                    'total'=>$info['rc_yingjin'],
                ];
                header("location:".U('Checklogin/sure_order_info',array('service_name'=>"天津人才引进")));//订单确认页面
//                    header("location:".U('Dopay/createDLBPay'));
            }else{
                $this->error('订单提交失败,请重新提交');
            }

            exit;
        }
        $friend=D('users')
            ->where("(parent_id={$_SESSION['user_id']} or user_id={$_SESSION['user_id']}) and is_lock=0 and is_staff=0 ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);
        $this->display("rc_yingjin_new");
    }

    public function logout(){
        setcookie('username','',time()-3600,'/');
        setcookie('account_name','',time()-3600,'/');
        setcookie('cn','',time()-3600,'/');
        setcookie('user_id','',time()-3600,'/');
        setcookie('user_type','',time()-3600,'/');
        session_unset();
        session_destroy();
        $this->success("退出成功",U('Home/Checklogin/login'));

        exit;
    }

    /**
     *  个人用户登录
     */
    public function login(){
        $this->display("login_new");
    }

    /**
     *  企业用户登录
     */
    public function company_login(){
        $this->display();
    }

    public function forget_login(){
        if(IS_POST){
            $account_name = I('post.account_name');
            $password = I('post.pwd');
            $code= I('post.code');
            $account_name = trim($account_name);
            $password = trim($password);
//            $_SESSION['sms_code']=888;
            if(!isset($_SESSION['sms_code']) || $code != $_SESSION['sms_code']){
                $this->error('手机短信验证码不正确');die;
            }
//            dump($code);
//            dump($_SESSION['sms_code']);die;
            $r=D("users")->where(['account_name'=>$account_name])->find();
            if($r){
                $password=md5(C("AUTH_CODE").$password);
                $data=array('password'=>$password);

                $res=D("users")->where(['account_name'=>$account_name])->save($data);

                if($res){
                    session('account_name',$account_name);
                    session('username',$account_name);
                    session('user_id',$r['user_id']);
                    session('user_type',$r['user_type']);

                    if($r['user_type']==1){
                        $this->success('密码找回成功',U('Home/Order/company'));
                    }else{
                        $this->success('密码找回成功',U('Home/Order/edit_info'));
                    }

                }else{
                    $this->error('找回失败,请重试');
                }
            }else{
                $this->error("此账户不存在");
            }

            exit;
        }
        $where=['flag'=>1,'parent_id'=>0,'level'=> 1,];
        $data=D("region")->field('id,name')->where($where)->select();
        $area_list=tree_city($data);//查找开通的省下面的市区

        $this->assign('area_list',$area_list);
        $this->display();
    }

   //个人用户登陆
    public function do_login(){
//        dump($_POST);

        $account_name = I('post.account_name');
        $password = I('post.pwd');
        $r_pwd = I('post.r_pwd');
        $user_type = I('post.user_type');
        $account_name = trim($account_name);//个人还是企业
        $password = trim($password);
        $verify_code = I('post.check_f');

        $verify = new Verify();
        if (!$verify->check($verify_code,'user_login'))
        {
//            $res = array('status'=>0,'msg'=>'验证码错误');
          $this->error('验证码错误');
        }

        $password=md5(C("AUTH_CODE").$password);


          $data=D("users")->where(['account_name'=>"$account_name",'password'=>"$password",'is_lock'=>0,'user_type'=>$user_type])->find();

//        $where="account_name='{$account_name}' and password='{$password}' and is_lock=0 and user_type={$user_type}";
//            dump($account_name);
//            dump($data);
//        die;
        if($data){
//echo 3333;die;
            session('account_name',$account_name);
            session('username',$data['username']);
            session('user_id',$data['user_id']);
            session('user_type',$user_type);


            if($user_type==1){
                $this->success('登录成功',U('Home/Order/company'));
            }else{
                $this->success('登录成功',U('Home/Order/edit_info'));
            }
        }else{
//echo 4444;die;
            $this->error('账号或密码错误');
        }
        exit;
    }

    //公司登陆
    public function do_company_login(){
//        dump($_POST);die;
        $account_name = I('post.account_name');
        $password = I('post.pwd');
        $r_pwd = I('post.r_pwd');
        $user_type = I('post.user_type');
        $account_name = trim($account_name);//个人还是企业
        $password = trim($password);
        $verify_code = I('post.check_f');

        $verify = new Verify();
        if (!$verify->check($verify_code,'user_login'))
        {
//            $res = array('status'=>0,'msg'=>'验证码错误');
          $this->error('验证码错误');
        }

        $password=md5(C("AUTH_CODE").$password);
//        dump($password);
//die;
          $data=D("users")->where(['account_name'=>"$account_name",'password'=>"$password",'is_lock'=>0,'user_type'=>$user_type])->find();
//        dump($data);

        if($data){

            session('account_name',$account_name);
            session('username',$data['username']);
            session('user_id',$data['user_id']);
            session('user_type',$user_type);

            if($user_type==1){
                $this->success('登录成功',U('Home/Order/company'));
            }else{
                $this->success('登录成功',U('Home/Order/edit_info'));
            }
        }else{

            $this->error('账号或密码错误');
        }
        exit;
    }
    /**
     *  注册
     */
    public function register(){
        if(IS_POST){
//            dump($_POST);die;
            $account_name = I('post.account_name');
            $password = I('post.pwd');
            $phone = $account_name;
            $code= I('post.code');
            $user_type= I('post.user_type');
            $account_name = trim($account_name);
            $password = trim($password);
            $phone = trim($phone);
            $verify_code = I('post.check_f');
            $verify = new Verify();
            if (!$verify->check($verify_code,'user_login'))
            {
                $this->error('验证码错误');die;
            }
//            dump($_POST);die;
            if(!isset($_SESSION['sms_code']) || $code != $_SESSION['sms_code']){
                $this->error('手机短信验证码不正确');die;
            }
            $r=D("users")->where(['account_name'=>$account_name])->find();

            if(!$r){
                $password=md5(C("AUTH_CODE").$password);
            $data=array('account_name'=>"$account_name",'password'=>"$password",'mobile'=>"$phone",'user_type'=>$user_type);

                $res=D("users")->add($data);
                $id=D("users")->getLastInsID();
                if($res){
                    session('account_name',$account_name);
                    session('username',$account_name);
                    session('user_id',$id);
                    session('user_type',$user_type);
                    if($user_type==1){
                        $this->success('注册成功',U('Home/Order/company'));
                    }else{
                        $this->success('注册成功',U('Home/Order/edit_info'));
                    }


                }else{
                    $this->error('注册失败,请重新注册');
                }
            }else{
                $this->error('此手机号已经注册');
            }

            exit;
        }
        $where=['flag'=>1,'parent_id'=>0,'level'=> 1,];
        $data=D("region")->field('id,name')->where($where)->select();
        $area_list=tree_city($data);//查找开通的省下面的市区

        $this->assign('area_list',$area_list);

        $this->display("register_new");
    }

   /*
    * ajax 发送验证码
    *
    *  	name 	必填参数。用户账号
2 	pwd 	必填参数。（登陆web平台：基本资料中的接口密码）
3 	content 	必填参数。发送内容（1-500 个汉字，建议300字符内）UTF-8编码
4 	mobile 	必填参数。手机号码。多个以英文逗号隔开
5 	stime 	可选参数。（发送时间，填写时已填写的时间发送，不填时为当前时间发送，秒到）
6 	sign 	必填参数。用户签名。（建议联系销售进行后台绑定）
7 	type 	必填参数。固定值 pt
8 	extno 	可选参数，（扩展码，用户定义扩展码，只能为数字，如需要扩展不同签名，需要帮扩展的号码和对应的签名报给客服）
    * **/
      public function send_sms(){
          $code=mt_rand(1000,9999);
          $url="http://web.cr6868.com/asmx/smsservice.aspx?";
          $_SESSION['sms_code']=$code;
          $mobile=I("post.mobile");
          $data=[
              'name'=>'18210418995',
              'pwd'=>'741592C128BA3DE65F204DB96448',
              'content'=>'验证码:'.$code.'请勿将验证码提供给他人',
              'mobile'=>$mobile,
              'sign'=>'【慧智博思社保代理】',
              'type'=>'pt',
          ];
         $code= httpRequest_array($url,'post',$data);
//          dump($code);die;
          echo 1;die;
      }

    public function info(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        if(IS_POST){
            I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
            I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
            I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
            I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
            I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
            I('post.province') ? $post['province'] = I('post.province') : false;  //省份
            I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
            I('post.district') ? $post['district'] = I('post.district') : false;  //地区
            if(!$userLogic->update_info($this->user_id,$post))
                $this->error("保存失败");
            $this->success("操作成功");
            exit;
        }
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取订单城市
        $city =  M('region')->where(array('parent_id'=>$user_info['province'],'level'=>2))->select();
        //获取订单地区
        $area =  M('region')->where(array('parent_id'=>$user_info['city'],'level'=>3))->select();

        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);
        $this->assign('user',$user_info);
        $this->assign('sex',C('SEX'));
        $this->assign('active','info');
        $this->display();
    }

    /*
     * 邮箱验证
     */
    public function email_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step',1);
        if(IS_POST){
            $email = I('post.email');
            $old_email = I('post.old_email',''); //旧邮箱
            $code = I('post.code');
            $info = session('validate_code');
            if(!$info)
                $this->error('非法操作');
            if($info['time']<time()){
                session('validate_code',null);
                $this->error('验证超时，请重新验证');
            }
            //检查原邮箱是否正确
            if($user_info['email_validated'] == 1 && $old_email != $user_info['email'])
                $this->error('原邮箱匹配错误');
            //验证邮箱和验证码
            if($info['sender'] == $email && $info['code'] == $code){
                session('validate_code',null);
                if(!$userLogic->update_email_mobile($email,$this->user_id))
                    $this->error('邮箱已存在');
                $this->success('绑定成功',U('Home/User/index'));
                exit;
            }
            $this->error('邮箱验证码不匹配');
        }
        $this->assign('user_info',$user_info);
        $this->assign('step',$step);
        $this->display();
    }


    /*
    * 手机验证
    */
    public function mobile_validate(){
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); //获取用户信息
        $user_info = $user_info['result'];
        $config = F('sms','',TEMP_PATH);
        $sms_time_out = $config['sms_time_out'];
        $step = I('get.step',1);
        if(IS_POST){
            $mobile = I('post.mobile');
            $old_mobile = I('post.old_mobile','');
            $code = I('post.code');
            $info = session('validate_code');
            if(!$info)
                $this->error('非法操作');
            if($info['time']<time()){
                session('validate_code',null);
                $this->error('验证超时，请重新验证');
            }
            //检查原手机是否正确
            if($user_info['mobile_validated'] == 1 && $old_mobile != $user_info['mobile'])
                $this->error('原手机号码错误');
            //验证手机和验证码
            if($info['sender'] == $mobile && $info['code'] == $code){
                session('validate_code',null);
                //验证有效期
                if($info['time'] < time())
                    $this->error('验证码已失效');
                if(!$userLogic->update_email_mobile($mobile,$this->user_id,2))
                    $this->error('手机已存在');
                $this->success('绑定成功',U('Home/User/index'));
                exit;
            }
            $this->error('手机验证码不匹配');
        }
        $this->assign('user_info',$user_info);
        $this->assign('time',$sms_time_out);
        $this->assign('step',$step);
        $this->display();
    }

    /**
     * 发送手机注册验证码
     */
    public function send_sms_reg_code(){
        $mobile = I('mobile');
        $userLogic = new UsersLogic();
        if(!check_mobile($mobile))
            exit(json_encode(array('status'=>-1,'msg'=>'手机号码格式有误')));
        $code =  rand(1000,9999);
        $send = $userLogic->sms_log($mobile,$code,$this->session_id);
        if($send['status'] != 1)
            exit(json_encode(array('status'=>-1,'msg'=>$send['msg'])));
        exit(json_encode(array('status'=>1,'msg'=>'验证码已发送，请注意查收')));
    }
    /*
     *商品收藏
     */
    public function goods_collect(){
        $userLogic = new UsersLogic();
        $data = $userLogic->get_goods_collect($this->user_id);
        $this->assign('page',$data['show']);// 赋值分页输出
        $this->assign('lists',$data['result']);
        $this->assign('active','goods_collect');
        $this->display();
    }





    public function check_captcha(){
        $verify = new Verify();
        $type = I('post.type','user_login');
        if (!$verify->check(I('post.verify_code'), $type)) {
            exit(json_encode(0));
        }else{
            exit(json_encode(1));
        }
    }

    public function check_username(){
        $username = I('post.username');
        if(!empty($username)){
            $count = M('users')->where("email='$username' or mobile='$username'")->count();
            exit(json_encode(intval($count)));
        }else{
            exit(json_encode(0));
        }
    }

    public function identity(){
        if($this->user_id > 0){
            header("Location: ".U('Home/User/Index'));
        }
        $username = I('post.username');
        $userinfo = array();
        if($username){
            $userinfo = M('users')->where("email='$username' or mobile='$username'")->find();
            $userinfo['username'] = $username;
            session('userinfo',$userinfo);
        }else{
            $this->error('参数有误！！！');
        }
        if(empty($userinfo)){
            $this->error('非法请求！！！');
        }
        unset($user_info['password']);
        $this->assign('userinfo',$userinfo);
        $this->display();
    }

    //发送验证码
    public function send_validate_code(){
        $type = I('type');
        $send = I('send');
        $logic = new UsersLogic();
        $res = $logic->send_validate_code($send, $type);
        $this->ajaxReturn($res);
    }

    public function check_validate_code(){
        $code = I('post.code');
        $send = I('send');
        $logic = new UsersLogic();
        $res = $logic->check_validate_code($code, $send);
        $this->ajaxReturn($res);
    }

    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        if (!$verify->check(I('post.verify_code'), $id ? $id : 'user_login')) {
            $this->error("验证码错误");
        }
    }

    /**
     * 验证码获取
     */
    public function verify()
    {

        //验证码类型
        $type = I('get.type') ? I('get.type') : 'user_login';
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
    }

    public function order_confirm(){
        $id = I('get.id',0);

        $data = confirm_order($id,$this->user_id);
        if(!$data['status'])
            $this->error($data['msg']);
        else
            $this->success($data['msg']);
    }
    /*
     *ajax   计算器
     * */
    public function search_calculate(){
        $gjj_base=I("post.gjj_base");
        $shebao_base=I("post.shebao_base");
        $city=I("post.city");

        if($city){

            $fee_data=search_shebao_ajax_jisuan($city,$shebao_base,$gjj_base);
//        dump($fee_data);die;

//        dump($shebao_date);
            $info=D("region")->where(['id'=>intval($city)])->find();
            $this->assign('info',$info);
            $this->assign('fee_data',$fee_data);
            $this->display('search_table');
//        echo json_encode(array('code'=>1,'sb_bilie'=>$info,'fee_data'=>$fee_data['data_fee'],'all_total'=>$fee_data['all_total']));die;
        }
//        else{
//            echo json_encode(array('code'=>0,'fee_data'=>0));die;
//        }
    }

    /**
       社保计算器
     */
   public function search(){
       $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
       $area_list=tree_city($p);//查找开通的省下面的市区
//       dump($area_list);
       $this->assign('area_list',$area_list);//开通地区列表
       $info=D("region")->where(['id'=>intval(2)])->find();
       $this->assign('info',$info);
       $this->assign('province',$p);






        $this->display();



//        $this->display("jisuanqi");
    }
    /*
     * ajax 计算社保
     * **/
    public function ajax_jisuanqi(){

            $to_city=I('post.to_city');//地区id
            $sb_base=I('post.sb_base');//补缴基数
            $gjj_base=I('post.gjj_base');//补缴基数

            if($to_city){
                $city=D("region")->where(['id'=>$to_city])->find();
                if($city) {
                    $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
                    $xian_one=((($xian_one_base*$city['xian_one']))/100);//险一缴纳的金额
                    $c_xian_one=((($xian_one_base*$city['c_xian_one']))/100);//险一缴纳的金额

                    $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
                    $xian_two=((($xian_two_base*$city['xian_two']))/100);//险2缴纳的金额
                    $c_xian_two=((($xian_two_base*$city['c_xian_two']))/100);//险2缴纳的金额

                    $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
                    $xian_three=((($xian_three_base*$city['xian_three']))/100);//险3缴纳的金额
                    $c_xian_three=((($xian_three_base*$city['c_xian_three']))/100);//险3缴纳的金额

                    $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
                    $xian_four=((($xian_four_base*$city['xian_four']))/100);//险3缴纳的金额
                    $c_xian_four=((($xian_four_base*$city['c_xian_four']))/100);//险3缴纳的金额

                    $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);

                    $xian_five=((($xian_five_base*$city['xian_five']))/100);//险3缴纳的金额
                    $c_xian_five=((($xian_five_base*$city['xian_five']))/100);//险3缴纳的金额

                    //自己缴纳社保总费用
                   $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);
                    //单位社保总费用
                   $c_sb_fee=round(($c_xian_one+$c_xian_two+$c_xian_three+$c_xian_four+$c_xian_five),2);

                    $gjj_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                    $fee=(($gjj_base*($city['gjj_bilie']))/100);//缴的公积金钱数
                    $company_fee=(($gjj_base*($city['c_gjj_bilie']))/100);//单位补缴的公积金钱数

                    $total_fee = round(($fee + $sb_fee + $c_sb_fee + $company_fee), 2);//总共缴纳的
                    $data_all = ['sb_fee' => $sb_fee, 'gjj_fee' => $fee, 'total_fee' => $total_fee, 'c_sb_fee' => $c_sb_fee, 'company_gjj_fee' => $company_fee];
                    echo json_encode(['code' => 1, 'mess' => $data_all, 'city' => $city]);
                    die;

                }
            }

    }

    /**
        养老计算器
     */
    public function pension(){
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $this->assign('province',$p);
        $this->display();
    }

    /**
        联系我们
     */
    public function  contact_us(){
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $this->assign('province',$p);
        $this->display();
    }

   /**
        滞纳金
     */
    public function late_fees(){
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $this->assign('province',$p);
        $this->display();
    }
    public function ajax_late_fees(){
        $to_city=I('post.to_city');//地区id
        $sb_base=I('post.sb_base');//补缴基数
        $gjj_base=I('post.gjj_base');//补缴基数
            $end_time=I('post.end_time');//补缴时间
        $start_time=I('post.start_time');//补缴时间
            $d=strtotime($end_time)-strtotime($start_time);
        $day_d=$d/(3600*24);//差额天数
        $mouth_d=getMonthNum($start_time,$end_time);//差额月
        $mouth_d=$mouth_d==0 ? 1 : $mouth_d;

            if($to_city){
                $city=D("region")->where(['id'=>$to_city])->find();
                if($city){
                    $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
                    $xian_one=((($xian_one_base*$city['xian_one']))/100);//险一缴纳的金额
                    $c_xian_one=((($xian_one_base*$city['c_xian_one']))/100);//险一缴纳的金额

                    $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
                    $xian_two=((($xian_two_base*$city['xian_two']))/100);//险2缴纳的金额
                    $c_xian_two=((($xian_two_base*$city['c_xian_two']))/100);//险2缴纳的金额

                    $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
                    $xian_three=((($xian_three_base*$city['xian_three']))/100);//险3缴纳的金额
                    $c_xian_three=((($xian_three_base*$city['c_xian_three']))/100);//险3缴纳的金额

                    $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
                    $xian_four=((($xian_four_base*$city['xian_four']))/100);//险3缴纳的金额
                    $c_xian_four=((($xian_four_base*$city['c_xian_four']))/100);//险3缴纳的金额

                    $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);

                    $xian_five=((($xian_five_base*$city['xian_five']))/100);//险3缴纳的金额
                    $c_xian_five=((($xian_five_base*$city['xian_five']))/100);//险3缴纳的金额

                    //自己缴纳社保总费用
                    $sb_fee=round((($xian_five+$xian_four+$xian_three+$xian_two+$xian_one)*$mouth_d),2);
                    //单位社保总费用
                    $c_sb_fee=round((($c_xian_one+$c_xian_two+$c_xian_three+$c_xian_four+$c_xian_five)*$mouth_d),2);

                    $sb_fee_total=($sb_fee+$c_sb_fee);
                    $sb_fee_zhina=round(($day_d*$sb_fee_total*$city['stop_money'])/10000,2);
                    $gjj_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                    $fee=(($gjj_base*($city['gjj_bilie']))/100);//缴的公积金钱数
                    $company_fee=(($gjj_base*($city['c_gjj_bilie']))/100);//单位补缴的公积金钱数
                    $gjj_fee_total=round((($company_fee+$fee)*$mouth_d),2);
                    $gjj_fee_zhina=round(($day_d*$gjj_fee_total*$city['stop_money'])/10000,2);
                    $zhina_fee=$gjj_fee_zhina+$sb_fee_zhina;
                        $data_all=['sb_fee'=>$sb_fee_total,'gjj_fee'=>$gjj_fee_total,'zhina_fee'=>$zhina_fee];
                        echo json_encode(['code'=>1,'mess'=>$data_all]);
                        die;



                }

            }

    }



    /**
     * 安全设置
     */
    public function safety_settings()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $this->assign('user',$user_info);
        $this->display();
    }



    public  function recharge(){
        if(IS_POST){
            $user = session('user');
            $data['user_id'] = $this->user_id;
            $data['nickname'] = $user['nickname'];
            $data['account'] = I('account');
            $data['order_sn'] = 'recharge'.get_rand_str(10,0,1);
            $data['ctime'] = time();
            $order_id = M('recharge')->add($data);
            if($order_id){
                $url = U('Payment/getPay',array('pay_radio'=>$_REQUEST['pay_radio'],'order_id'=>$order_id));
                redirect($url);
            }else{
                $this->error('提交失败,参数有误!');
            }
        }

        $paymentList = M('Plugin')->where("`type`='payment' and code!='cod' and status = 1 and  scene in(0,2)")->select();
        $paymentList = convert_arr_key($paymentList, 'code');
        foreach($paymentList as $key => $val)
        {
            $val['config_value'] = unserialize($val['config_value']);
            if($val['config_value']['is_bank'] == 2)
            {
                $bankCodeList[$val['code']] = unserialize($val['bank_code']);
            }
        }
        $bank_img = include 'Application/Home/Conf/bank.php'; // 银行对应图片
        $this->assign('paymentList',$paymentList);
        $this->assign('bank_img',$bank_img);
        $this->assign('bankCodeList',$bankCodeList);

        $count = M('recharge')->where(array('user_id'=>$this->user_id))->count();
        $Page = new Page($count,10);
        $show = $Page->show();
        $recharge_list = M('recharge')->where(array('user_id'=>$this->user_id))->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('recharge_list',$recharge_list);//充值记录

        $count2 = M('account_log')->where(array('user_id'=>$this->user_id,'user_money'=>array('gt',0)))->count();
        $Page2 = new Page($count2,10);
        $consume_list = M('account_log')->where(array('user_id'=>$this->user_id,'user_money'=>array('gt',0)))->limit($Page2->firstRow.','.$Page2->listRows)->select();
        $this->assign('consume_list',$consume_list);//消费记录
        $this->assign('page2',$Page2->show());
        $this->display();
    }

    /**

     */
    public function index_index()
    {
        $this->display();
    }
    /**
     *   企业订单下单提交过来company_order
     */
    public function company_order()
    {

        $model=D("sb_company_order");
        if(IS_POST){
//            dump($_POST);
            $shebao_start_time=I('post.shebao_start_time','');
            $shebao_end_time=I('post.shebao_end_time','');
            $gjj_start_time=I('post.gjj_start_time','');
            $gjj_end_time=I('post.gjj_end_time','');
            $is_guakao=I("post.is_guakao");//$is_guakao  1 挂靠，2代理
            $to_province=I('post.to_province');
            $to_city=I('post.to_city');

            $is_gjj=I('post.is_gjj',0);
            $is_shebao=I('post.is_shebao',0);
            $sb_type=0;
            if($is_gjj && $is_shebao){
                $sb_type=1;
            }elseif($is_gjj){
                $sb_type=3;
            }elseif($is_shebao){
                $sb_type=2;
            }
            $shebao_jishu_arr=I('post.shebao_jishu');
            $gjj_jishu_arr=I('post.gjj_jishu');

            $user=[];
            foreach($shebao_jishu_arr as $k=>$v){
                $user[$k]['shebao_base']=$v;
                $user[$k]['gjj_base']=$gjj_jishu_arr[$k];
            }
            $shebao_date=[$shebao_start_time,$shebao_end_time];
            $gjj_date=[$gjj_start_time,$gjj_end_time];
            $people=count($user);
//            dump($people);
            $fee_data=company_shebao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$to_city,0,$is_guakao,$people);


//            dump($fee_data);die;
//

            $sb_base_info=D("region")->where(['id'=>intval($to_city)])->find();
            $order_id_arr=[];//订单id
            foreach($fee_data['data_fee'] as $ok=>$ov){
//                $order_sn=get_order_sn();
                $actual_info= D("users")->where(['user_id'=>$ok])->find();
                $data=[
                    'user_id'=>$_SESSION['user_id'],
                    'add_time'=>time(),
                    'ways'=>$is_guakao,
                    'sb_base'=>$shebao_jishu_arr[$ok],
                    'gjj_base'=>$gjj_jishu_arr[$ok],
                    'is_gjj'=>$sb_type,
                    'start_time'=>$shebao_start_time,
                    'end_time'=>$shebao_end_time,
                    'gjj_start_time'=>$gjj_start_time,
                    'gjj_end_time'=>$gjj_end_time,
                    'to_province'=>$to_province,
                    'to_city'=>$to_city,
                    'image'=>$actual_info['image'],
                    'image_t'=>$actual_info['image_t'],
                    "actual_user_id"=>$ok,
                    "username"=>$actual_info['username'],
                    "idcard"=>$actual_info['idcard'],
                    "mobile"=>$actual_info['mobile'],
                    "sex"=>$actual_info['sex'],
                    "nature"=>$actual_info['nature'],
                    "bank_num"=>$actual_info['bank_num'],
                    "bank_name"=>$actual_info['bank_name'],
                    "money"=>$ov['total_fee'],
                    "gjj_unit_fee"=>$ov['gjj_unit_fee'],
                    "sb_unit_fee"=>$ov['sb_unit_fee'],
                    "gjj_fee"=>$ov['gjj_fee'],
                    "sb_fee"=>$ov['sb_fee'],
                    "service_fee"=>$ov['service_fee'],
                    "xian_one_base"=>$ov['xian_one_base'],
                    "c_xian_one"=>$sb_base_info['c_xian_one'],
                    "xian_one"=>$sb_base_info['xian_one'],
                    "xian_two_base"=>$ov['xian_two_base'],
                    "c_xian_two"=>$sb_base_info['c_xian_two'],
                    "xian_two"=>$sb_base_info['xian_two'],
                    "xian_three_base"=>$ov['xian_three_base'],
                    "c_xian_three"=>$sb_base_info['c_xian_three'],
                    "xian_three"=>$sb_base_info['xian_three'],
                    "xian_four_base"=>$ov['xian_four_base'],
                    "xian_four"=>$sb_base_info['xian_four'],
                    "c_xian_four"=>$sb_base_info['c_xian_four'],
                    "xian_five_base"=>$ov['xian_five_base'],
                    "c_xian_five"=>$sb_base_info['c_xian_five'],
                    "xian_five"=>$sb_base_info['xian_five'],
                    "c_gjj_bilie"=>$sb_base_info['c_gjj_bilie'],
                    "gjj_bilie"=>$sb_base_info['gjj_bilie'],
                    "c_gjj_base"=>$ov['gjj_js_base'],

                    "xian_one_company"=>$ov['xian_one_company'],
                    "xian_one_own"=>$ov['xian_one_own'],
                    "xian_two_company"=>$ov['xian_two_company'],
                    "xian_two_own"=>$ov['xian_two_own'],
                    "xian_three_company"=>$ov['xian_three_company'],
                    "xian_three_own"=>$ov['xian_three_own'],
                    "xian_four_company"=>$ov['xian_four_company'],
                    "xian_four_own"=>$ov['xian_four_own'],
                    "xian_five_company"=>$ov['xian_five_company'],
                    "xian_five_own"=>$ov['xian_five_own'],
                    "gjj_own"=>$ov['gjj_own'],
                    "gjj_company"=>$ov['gjj_company'],
                ];
                $model->add($data);
                $id=$model->getLastInsID();
                $order_id_arr[]=$id;
            }
//            dump($fee_data);
//            die;
            $_SESSION['order_data']=[
                'order_id_arr'=>$order_id_arr,
                'table_name'=>'sb_company_order',
                'total'=>$fee_data['all_total'],
            ];
            header("location:".U('Checklogin/sure_order_info',array('service_name'=>"企业社保办理")));//订单确认页面
//            header("location:".U('Dopay/createDLBPay'));
//                  header("Location:".U('Home/Checklogin/sb_daijiao_to_order')."");


            exit;
        }

        $friend=D('users')
            ->where("((parent_id={$_SESSION['user_id']} and is_staff=1 ) or user_id={$_SESSION['user_id']}) and is_lock=0  ")
            ->order('parent_id ASC')->select();//用户的朋友信息

        $p = M('region')->where(array('parent_id'=>0,'level'=> 1,'flag'=>1))->select();
        $area_list=tree_city($p);//查找开通的省下面的市区

        $this->assign('area_list',$area_list);//开通地区列表

        $this->assign('province',$p);
        $this->assign('friend',$friend);

//        dump($friend);

        $this->display("company_new_order");
    }
    /*
   * ajax 计算 企业办理对应的费用.
   *
   * 	data:{'gjj_user_id':gjj_user_id,'shebao_user_id':shebao_user_id,'date1':date1,'date2':date2,'date3':date3,'date4':date4,'is_shebao':is_shebao,'is_gjj':is_gjj,'city':city},
   * */

    public function company_calculate(){
        $shebao_user_id=I("post.shebao_user_id");
        $is_bujiao=I("post.is_bujiao");//是否是补缴的，是补缴的得收取滞纳金
        $is_guakao=I("post.is_guakao");//$is_guakao  1 挂靠，2代理
        $is_mobile=I("is_mobile",0);//如果是手机端下单计算，不输出表格，返回json数据
        $gjj_base_str=I("post.gjj_base_str");
        $shebao_base_str=I("post.shebao_base_str");

        $shebao_base_arr=explode('-',trim($shebao_base_str,'-'));
        $gjj_base_arr=explode('-',trim($gjj_base_str,'-'));
        $shebao_user_id_arr=explode('-',trim($shebao_user_id,'-'));

        $date1=I("post.date1");
        $date2=I("post.date2");
        $date3=I("post.date3");
        $date4=I("post.date4");
        $is_shebao=I("post.is_shebao");
        $is_gjj=I("post.is_gjj");
        $city=I("post.city");

        if($city){
            //公积金
            $is_shebao=$is_shebao=='true' ? 1 : 0;
            $is_gjj=$is_gjj=='true' ? 1 : 0;
            $user=[];
            foreach($shebao_user_id_arr as $k=>$v){
                $user[$v]['shebao_base']=$shebao_base_arr[$k];
                $user[$v]['gjj_base']=$gjj_base_arr[$k];
            }
            $shebao_date=[$date1,$date2];
            $gjj_date=[$date3,$date4];
            $people=count($user);
            $fee_data=company_shebao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$city,0,$is_guakao,$people);
//        dump($fee_data);
//        dump($shebao_date);
            if($is_mobile){
                $sb_fee=0;
                $gjj_fee=0;
                $service_fee=0;
//           dump($fee_data['data_fee']);
                foreach($fee_data['data_fee'] as $k=>$v){
                    $sb_fee+=$v['sb_fee'];
                    $gjj_fee+=$v['gjj_fee'];
                    $service_fee+=$v['service_fee'];
                }
                echo json_encode(array('code'=>1,'sb_fee'=>$sb_fee,"gjj_fee"=>$gjj_fee,"service_fee"=>$service_fee,'all_total'=>$fee_data['all_total']));die;
            }else{
                $info=D("region")->where(['id'=>intval($city)])->find();
                $this->assign('sb_bilie',$info);
                $this->assign('fee_data',$fee_data['data_fee']);
                $this->assign('all_total',$fee_data['all_total']);
                $this->display('table_part');
            }
//        echo json_encode(array('code'=>1,'sb_bilie'=>$info,'fee_data'=>$fee_data['data_fee'],'all_total'=>$fee_data['all_total']));die;
        }
//        else{
//            echo json_encode(array('code'=>0,'fee_data'=>0));die;
//        }
    }
    /*
     * 企业订单支付详情页面
     * */
    public function order_company_list(){
        $id_arr=$_SESSION['order_data']['order_id_arr'];
//        dump($id_arr);
        if(count($id_arr)){
            $id_str=implode(',',$id_arr);
            $data=D("sb_company_order")->where("id in ($id_str)")->select();
            $total=0;
            foreach($data as $kk=>$vv){
                $total+=$vv['money'];
            }
            $_SESSION['order_data']['total']=$total;
            $this->assign('total',$total);
            $this->assign('data',$data);
            $this->display();
        }else{
            $this->error("订单失效,请重新下单",U("Checklogin/company_order"));
        }
    }

    /**
     * ajax用户消息通知请求
     * @author dyr
     * @time 2016/09/01
     */
    public function ajax_message_notice()
    {
        $type = I('type',0);
        $user_logic = new UsersLogic();
        if ($type == 1) {
            //系统消息
            $user_sys_message = D('Message')->getUserMessageNotice();
            $user_logic->setSysMessageForRead();
        } else if ($type == 2) {
            //活动消息：后续开发
            $user_sys_message = array();
        } else {
            //全部消息：后续完善
            $user_sys_message = D('Message')->getUserMessageNotice();
        }
        $this->assign('messages', $user_sys_message);
        $this->display();
    }

    //uploader 文件上传
    public function uploader_img(){

        foreach ($_FILES as $key => $file) {
            if ($file['error'] > 0) {
                echo json_encode(array('error'=>1, 'info' => $file['error']));
                die;
            }
            if (empty($file['name'])){
                echo json_encode(array('error'=>1, 'info' => "未知上传错误"));
                die;
            }
            if (!is_uploaded_file($file['tmp_name'])) {
                echo json_encode(array('error'=>1, 'info' => "非法上传文件"));
                die;

            }
            if($file['size'] > 2*1024*1024) {
                echo json_encode(array('error'=>1, 'info' => "上传文件太大"));
                die;
            }
            $file['name']  = strip_tags($file['name']);
            $file['ext']   = pathinfo($file['name'], PATHINFO_EXTENSION);
            $ext = strtolower($file['ext']);
            if(in_array($ext, array('gif','jpg','jpeg','bmp','png'))) {
                $imginfo = getimagesize($file['tmp_name']);
                if(empty($imginfo) || ($ext == 'gif' && empty($imginfo['bits']))){
                    echo json_encode(array('error'=>1, 'info' => "非法图像文件"));
                    die;

                }
            } else {
                echo json_encode(array('error'=>1, 'info' => "上传文件类型不允许"));
               die;
            }

            $uploads = './Public/upload/'.time().rand(1,10000).'.'.$ext;
            move_uploaded_file( $file['tmp_name'], $uploads );
//            returnAjax(0, $uploads);
        }

//        function returnAjax($status,$msg) {
//            echo json_encode(array('error'=>$status, 'info' => $msg));
//            exit;
//        }
         echo json_encode(array('error'=>0, 'info' =>trim($uploads,'.')));
    }

    public function add_userinfo(){
        $model=D("users");

        $is_company=I("post.is_company",0);
        $data['username']=I("post.username");
        $data['mobile']=I("post.mobile");
        $data['idcard']=I("post.idcard");
        $data['nature']=I("post.nature");
        $data['bank_name']=I("post.bank_name");
        $data['bank_num']=I("post.bank_num");
        $data['image']=I("post.img1");
        $data['image_t']=I("post.img2");
        $data['parent_id']=$_SESSION['user_id'];

        //企业订单新增人员时候，用户信息有变化。
        if($is_company){
            $data['is_staff']=1;
        }

        if( $data['idcard'] && $data['mobile']){
            $ret=$model->add($data);
            $id=$model->getLastInsID();
//            echo $id;die;
            if($ret){
                echo json_encode(['code'=>1,'mess'=>"添加成功",'id'=>$id]);die;
            }else{
                echo json_encode(['code'=>0,'mess'=>"添加失败"]);die;
            }
        }else{
//           echo  $model->getError();
//            echo 44;die;
            echo json_encode(['code'=>0,'mess'=>"添加失败"]);die;
        }

    }

}