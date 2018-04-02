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

class MobileOrderController extends BaseController {

    public $user_id = 0;
    public $user = array();

    public function _initialize() {
        parent::_initialize();
        if(!session('account_name'))
        {

                $this->error("请先登录……",U('Home/Mobile/login'));
                exit;

        }
        $this->assign('act',ACTION_NAME);
        if($_SESSION['account_name']){
            $this->assign('username',$_SESSION['account_name']);
        }else{
            $this->assign('username','游客');
        }

        $this->assign('user_type',$_SESSION['user_type']);
    }

    //个人中心首页
    public function index(){
        $this->display();
    }

    /*
     * 我的订单->个人用户订单
     */
    public function my_index(){
        /****/
        if($_SESSION['user_type']==1){//企业用户去企业订单处
            header("location:".U('Order/company_index'));die;
        }

//        $_SESSION['user_id']=2627;
        $where=['c.user_id'=>$_SESSION['user_id'],'c.is_del'=>0];

        $shebao_bujiao=D("sb_bujiao")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
         $this->assign('shebao_bujiao',$shebao_bujiao);


//         $sb_daijiao=D("sb_daijiao")->where($where)->select();
        $sb_daijiao=D("sb_daijiao")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
        $this->assign('sb_daijiao',$sb_daijiao);

//        $gongjijin_bujiao=D("gjj_bujiao")->where($where)->select();
//        $this->assign('gongjijin_bujiao',$gongjijin_bujiao);
//
//        $gjj_daijiao=D("gjj_daijiao")->where($where)->select();
//        $this->assign('gjj_daijiao',$gjj_daijiao);
        $shebao_zhuanyi=D("sb_zhuanyi")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $shebao_zhuanyi=D("sb_zhuanyi")->where($where)->select();
        $this->assign('shebao_zhuanyi',$shebao_zhuanyi);


        $gjj_zhuanyi=D("gjj_zhuanyi")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $gjj_zhuanyi=D("gjj_zhuanyi")->where($where)->select();
        $this->assign('gjj_zhuanyi',$gjj_zhuanyi);

        $gjj_tiqu=D("gjj_tiqu")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $gjj_tiqu=D("gjj_tiqu")->where($where)->select();
        $this->assign('gjj_tiqu',$gjj_tiqu);

        $yl_sgz=D("yl_sgz")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $yl_sgz=D("yl_sgz")->where($where)->select();
        $this->assign('yl_sgz',$yl_sgz);

        $sy_shenqing=D("sy_shenqing")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $sy_shenqing=D("sy_shenqing")->where($where)->select();
        $this->assign('sy_shenqing',$sy_shenqing);

        $yd_bajy=D("yd_bajy")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $yd_bajy=D("yd_bajy")->where($where)->select();
        $this->assign('yd_bajy',$yd_bajy);

        $sb_editinfo=D("sb_editinfo")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $sb_editinfo=D("sb_editinfo")->where($where)->select();
        $this->assign('sb_editinfo',$sb_editinfo);

        $own_money=D("own_money")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $own_money=D("own_money")->where($where)->select();
        $this->assign('own_money',$own_money);

        $tx_yanglao=D("tx_yanglao")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $tx_yanglao=D("tx_yanglao")->where($where)->select();
        $this->assign('tx_yanglao',$tx_yanglao);

        $school_info=D("school_info")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $school_info=D("school_info")->where($where)->select();
        $this->assign('school_info',$school_info);

        $rc_yingjin=D("rc_yingjin")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        $rc_yingjin=D("rc_yingjin")->where($where)->select();
        $this->assign('rc_yingjin',$rc_yingjin);
//        dump($shebao_bujiao);
//        dump($gongjijin_bujiao);
       $this->display();
    }

    /*
     *
     * 未支付的订单。点击去支付，统一跳转到这里，带好参数再去支付
     */
    public function get_parameter(){
        $table_name=I('table','');
        $order_sn=I('order_sn','');
        if($table_name && $order_sn){
           $info=D("{$table_name}")->where(['order_sn'=>"$order_sn"])->getField('id',true);
            $pay_info=D("order_info")->where(['order_sn'=>"$order_sn"])->find();
           if(count($info) && $pay_info){

                if($info['is_pay']==0){
                    $_SESSION['order_data']['order_id_arr']=$info;//订单id
                    $_SESSION['order_data']['table_name']=$table_name;//表名
                    $_SESSION['order_data']['total']=$pay_info['total'];//订单的总金额
                    $_SESSION['order_data']['coupon_id']=$pay_info['coupon_id'];//代金券
                    $_SESSION['order_data']['order_info_id']=$pay_info['id'];//订单支付汇总表
                    header("location:".U('MobileDopay/createDLBPay'));
                }else{
                    $this->success("此订单已支付,请勿重复支付");
                }
           }else{
               $this->error("错误,订单不存在");
           }
        }else{
           $this->error("错误,请规范操作");
        }
    }

    //ajax删除用户
    public function ajax_del(){
            $user_id=I("post.user_id");

           if($user_id){
               $info=D("users")->where(['user_id'=>$user_id])->setField("is_lock",1);
               if($info){
                   echo json_encode(['code'=>1,'mess'=>"删除成功"]);die;
               }else{
                   echo json_encode(['code'=>0,'mess'=>'错误,请重试']);die;
               }
           }else{
               echo json_encode(['code'=>0,'mess'=>'错误,请重试']);die;
           }
    }
    /**
      企业订单列表.汇总列表
     */
    public function company_index(){

        $where=['c.user_id'=>$_SESSION['user_id'],'c.is_del'=>0];
        $sb_company_order=D("sb_company_order")->alias('c')
            ->field("c.order_sn,c.is_pay,c.add_time,o.front_total,o.total,u.username,o.coupon_fee,o.pay_money")
            ->join(" tp_order_info o on o.order_sn=c.order_sn","inner")
            ->join(" tp_users u on u.user_id=c.user_id","inner")
            ->where($where)->group("c.order_sn")->select();
//        dump($sb_company_order);
        $this->assign('sb_company_order',$sb_company_order);
        $this->assign('service_name','企业订单');
        $this->display();
    }


    /**
      企业详细列表。er级列表。每个人的详细信息
     */
    public function company_info(){
        $order_sn=I('get.order_sn');
        if($order_sn){
            $mess=D("sb_company_order")->alias('a')
                ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.order_sn'=>"$order_sn"])->select();
//            dump($mess);
//            $mess=get_every_info($info);//获取社保和公积金各项费用。
            foreach($mess as $ok=>$vo){
                $company_total=$vo['xian_one_company']+$vo['xian_two_company']+$vo['xian_three_company']+$vo['xian_four_company']+$vo['xian_five_company']+$vo['gjj_company'];
                $own_total=$vo['xian_one_own']+$vo['xian_two_own']+$vo['xian_three_own']+$vo['xian_four_own']+$vo['xian_five_own']+$vo['gjj_own'];

                $mess[$ok]['company_total']=$company_total;
                $mess[$ok]['own_total']=$own_total;

            }

            //取出订单支付金额明细；
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();


            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);
            $this->assign('service_name',"社保订单明细表");
            $this->assign('mess',$mess);
        }

//        dump($data);

        $this->display();
    }


    /**
    修改个人信息
     */
    public function edit_info(){
        $model=D("users");
        if(IS_POST){
            $id=I("post.id",0);
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
            $upload->exts  =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = './Public/upload/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $image_info   =   $upload->upload();
//           dump($_POST);die;
            $info=$model->where(['user_id'=>$id])->find();
            if($model->create()){
                $model->image="{$image_info['image']['urlpath']}";
                $model->image_t="{$image_info['image_t']['urlpath']}";
                unset($model->id);
                if($id){
                    if($model->image==""){
                        $model->image=$info['image'];
                    }
                    if($model->image_t==""){
                        $model->image_t=$info['image_t'];
                    }
                    $ret=$model->where(['user_id'=>$_SESSION['user_id']])->save();
                }else{
                    $ret=$model->add();
                }
                if($ret !== false){
                    $this->success('成功');
                }else{
                    $this->error("错误，请重试");
                }

            }else{
                $this->error("错误，请重试");
            }
            die;
        }
        $info=$model->where(['user_id'=>$_SESSION['user_id']])->find();
        $this->assign('info',$info);
        $this->display();
    }

    /**
    朋友信息列表
     */
   public function friend_info(){
       $model=D("users");
       $info=$model->where(['parent_id'=>$_SESSION['user_id'],'is_lock'=>0,'is_staff'=>0])->select();
       $this->assign('info',$info);
//       dump($info);
       $this->display();
   }
    /**
    添加修改朋友信息
     */
   public function add_friend_info(){
       $model=D("users");
       if(IS_POST){
           $user_id=I("post.user_id",0);
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize   = 1024*1024;// 设置附件上传大小
           $upload->exts  =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath  = './Public/upload/'; // 设置附件上传根目录
           // 上传单个文件
           $upload->savePath  =     ''; // 设置附件上传（子）目录
           $image_info   =   $upload->upload();
           $info=$model->where(['user_id'=>$user_id])->find();
           if($model->create()){
               $model->image="{$image_info['image']['urlpath']}";
               $model->image_t="{$image_info['image_t']['urlpath']}";
               unset($model->user_id);

               if($user_id){
//                   dump(empty("adasd"));
                   if($model->image==""){
//                       dump( $model->image);
                       $model->image=$info['image'];
                   }
                   if($model->image_t==""){
                       $model->image_t=$info['image_t'];
                   }

                   $model->where(['user_id'=>$user_id])->save();
               }else{

                   $model->parent_id=$_SESSION['user_id'];
                   $model->add();
               }
//               dump($_POST);die;
               $this->success("操作成功",U("Home/MobileOrder/friend_info"));
           }else{
//               dump(222);die;
               $this->error("错误,请重试",U("Home/MobileOrder/friend_info"));
           }

           exit;
       }
       $user_id=I("get.user_id",0);
//         dump($user_id);
       $info=$model->where(['user_id'=>$user_id])->find();
       $this->assign('info',$info);
       $this->assign('user_id',$user_id);
       $this->display();
   }



    public function ajax_edit_info(){
            $model=D("users");
            $username=I('post.username');
            $mobile=I('post.mobile');
        if($username && $mobile){
            $ret=$model->where(['user_id'=>$_SESSION['user_id']])->save(['username'=>$username,'mobile'=>$mobile]);
            if($ret){
                $_SESSION['username']=$username;
                echo 1;die;
            }else{
                echo 0;die;
            }
        }else{
            echo 0;die;
        }
         
   }
    /**
    账号信息修改
     */
   public function account(){
       $model=D("users");
       $info=$model->where(['user_id'=>$_SESSION['user_id']])->find();
       $this->assign('info',$info);
       $this->display();
   }
   public function ajax_account(){
       $model=D("users");
       $password=I('post.password');
       $new_password=I('post.new_password');
       $password=md5(C("AUTH_CODE").$password);
       $new_password=md5(C("AUTH_CODE").$new_password);
       if($password && $new_password){
          $is_sure= $model->where(['password'=>$password,'user_id'=>$_SESSION['user_id']])->find();
           if($is_sure){
               $ret=$model->where(['user_id'=>$_SESSION['user_id']])->save(['password'=>$new_password]);
               if($ret !== false){
                   echo json_encode(['code'=>1,'mess'=>'修改成功']);die;
               }else{
                   echo json_encode(['code'=>0,'mess'=>'错误请重试']);die;
               }
           }else{
               echo json_encode(['code'=>0,'mess'=>'原密码不正确']);die;
           }

       }else{
          echo json_encode(['code'=>0,'mess'=>'错误请重试']);die;
       }
   }


    public function sb_bujiao(){
       $table_name=I('get.table_name');
       $order_sn=I('get.order_sn');
        if($order_sn){
            $mess=D("{$table_name}")->alias('a')
                ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.order_sn'=>"$order_sn"])->select();
//            $mess=get_every_info($info);//获取社保和公积金各项费用。
            foreach($mess as $ok=>$vo){
                $company_total=$vo['xian_one_company']+$vo['xian_two_company']+$vo['xian_three_company']+$vo['xian_four_company']+$vo['xian_five_company']+$vo['gjj_company'];
                $own_total=$vo['xian_one_own']+$vo['xian_two_own']+$vo['xian_three_own']+$vo['xian_four_own']+$vo['xian_five_own']+$vo['gjj_own'];

                $mess[$ok]['company_total']=$company_total;
                $mess[$ok]['own_total']=$own_total;
                $zhina=$vo['gjj_zhina_fee']+$vo['sb_zhina_fee'];
                $mess[$ok]['zhina']=$zhina;

            }
//            dump($mess);
            //取出订单支付金额明细；
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
//             dump($pay_data);
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name','社保补缴');
       $this->display();
   }
    //社保代缴
   public function sb_daijiao(){
       $table_name=I('get.table_name');
       $order_sn=I('get.order_sn');
       if($order_sn) {
           $mess = D("{$table_name}")->alias('a')
               ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
               ->join("tp_users as u ON u.user_id=a.user_id", 'inner')
               ->join("tp_region as g ON g.id=a.to_province", 'left')
               ->join("tp_region as i ON i.id=a.to_city", 'left')
               ->where(['a.order_sn' =>"$order_sn"])->select();
//            $mess=get_every_info($info);//获取社保和公积金各项费用。
           foreach ($mess as $ok => $vo) {
               $company_total = $vo['xian_one_company'] + $vo['xian_two_company'] + $vo['xian_three_company'] + $vo['xian_four_company'] + $vo['xian_five_company'] + $vo['gjj_company'];
               $own_total = $vo['xian_one_own'] + $vo['xian_two_own'] + $vo['xian_three_own'] + $vo['xian_four_own'] + $vo['xian_five_own'] + $vo['gjj_own'];

               $mess[$ok]['company_total'] = $company_total;
               $mess[$ok]['own_total'] = $own_total;

           }
           $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
           $this->assign('pay_data',$pay_data);
           $this->assign('order_sn',$order_sn);

           $this->assign('mess',$mess);
       }

//        dump($data);
       $this->assign('service_name','社保代缴');
       $this->display();
   }

    /*
     * 社保转移
     * */
    public function sb_zhuanyi(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
       if($order_sn){

           $mess=D("$table_name")->alias('a')->field("a.*,u.username uname,u.mobile umobile,r.name op_name,e.name oc_name,g.name top_name,i.name tc_name")
               ->join("tp_users as u ON u.user_id=a.user_id",'left')
               ->join("tp_region as r ON r.id=a.out_province",'left')
               ->join("tp_region as e ON e.id=a.out_city",'left')
               ->join("tp_region as g ON g.id=a.to_province",'left')
               ->join("tp_region as i ON i.id=a.to_city",'left')
               ->where(['a.order_sn' => "$order_sn"])
               ->select();
           $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
           $this->assign('pay_data',$pay_data);
           $this->assign('order_sn',$order_sn);

           $this->assign('mess',$mess);
       }

        $this->assign('service_name','社保转移');
       $this->display();
   }
    public function gjj_zhuanyi(){
        $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.username uname,u.mobile umobile,r.name op_name,e.name oc_name,g.name top_name,i.name tc_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'left')
                ->join("tp_region as r ON r.id=a.out_province",'left')
                ->join("tp_region as e ON e.id=a.out_city",'left')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }

        $this->assign('service_name','公积金转移');
        $this->display();
   }
    public function gjj_tiqu(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
       if($order_sn){
           $mess=D("$table_name")->alias('a')->field("a.*,u.username uname,u.mobile umobile,g.name pname,i.name cname")
               ->join("tp_users as u ON u.user_id=a.user_id")
               ->join("tp_region as g ON g.id=a.to_province",'left')
               ->join("tp_region as i ON i.id=a.to_city",'left')
               ->where(['a.order_sn' => "$order_sn"])
               ->select();
           $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
           $this->assign('pay_data',$pay_data);
           $this->assign('order_sn',$order_sn);

           $this->assign('mess',$mess);
       }
        $this->assign('service_name','公积金提取');
       $this->display();
   }

    public function yl_sgz(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
       if($order_sn){

           $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
               ->join("tp_region as g ON g.id=a.to_province",'left')
               ->join("tp_region as i ON i.id=a.to_city",'left')
               ->join("tp_users as u ON u.user_id=a.user_id")
               ->where(['a.order_sn' => "$order_sn"])
               ->select();
           $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
           $this->assign('pay_data',$pay_data);
           $this->assign('order_sn',$order_sn);

           $this->assign('mess',$mess);
       }

        $this->assign('service_name','医疗手工报销');
       $this->display();
   }
    public function sy_shenqing(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
       if($order_sn){

           $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
               ->join("tp_region as g ON g.id=a.to_province",'left')
               ->join("tp_region as i ON i.id=a.to_city",'left')
               ->join("tp_users as u ON u.user_id=a.user_id")
               ->where(['a.order_sn' => "$order_sn"])
               ->select();
           $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
           $this->assign('pay_data',$pay_data);
           $this->assign('order_sn',$order_sn);

           $this->assign('mess',$mess);
       }
        $this->assign('service_name','生育待遇申领');
       $this->display();
   }
    public function yd_bajy(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name','异地就医备案');
//       dump($data);
       $this->display();
   }
    public function sb_editinfo(){
        $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name',' 社保信息修改');
        $this->display();
   }

    public function own_money(){
        $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name','个人所得税申报');
        $this->display();
   }

    public function tx_yanglao(){
        $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name',' 退休养老办理');
        $this->display();
   }
    public function school_info(){
        $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name',' 孩子上学材料');
        $this->display();
   }
    public function rc_yingjin(){
       $table_name=I('get.table_name');
        $order_sn=I('get.order_sn');
        if($order_sn){

            $mess=D("$table_name")->alias('a')->field("a.*,u.mobile umobile,g.name pname,i.name cname")
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->join("tp_users as u ON u.user_id=a.user_id")
                ->where(['a.order_sn' => "$order_sn"])
                ->select();
            $pay_data=D("order_info")->where(['order_sn'=>$order_sn])->find();
            $this->assign('pay_data',$pay_data);
            $this->assign('order_sn',$order_sn);

            $this->assign('mess',$mess);
        }
        $this->assign('service_name',' 天津人才引进');
       $this->display();
   }

   //提报建议
   public function up_question(){
       $model=D("question");
       if(IS_POST){
            if($model->create()){
                $model->user_id=$_SESSION['user_id'];
                $model->time=time();
               $ret= $model->add();
               if($ret){
                   $this->success("反馈成功,谢谢您的反馈",U("MobileOrder/index"));
               }else{
                   $this->error("出错啦……");
               }
            }else{
                $this->error("出错啦……");
            }
           die;
       }
            $this->display();
   }

    //增值服务。
    public function added_service(){
        $model=D("added_services");
        if(IS_POST){
            if($model->create()){
                $model->user_id=$_SESSION['user_id'];
                $model->time=time();
                $model->order_sn=get_order_sn();//生成同意的订单号
                $ret= $model->add();
                if($ret){
                    $this->success("提交成功,我们工作人员将会和您联系",U("MobileOrder/index"));
                }else{
                    $this->error("出错啦……");
                }
            }else{
                $this->error("出错啦……");
            }
            die;
        }
        $this->display();
    }

   public function news(){
       $model=D("news");
      $info=
          $model->where(['user_id'=>$_SESSION['user_id']])->where(['is_del'=>0])->select();

      $this->assign('info',$info);
            $this->display();
   }
   public function company(){
       $model=D("company");
       if(IS_POST){
           $id=I('post.id',0);
           if($model->create()){
               if($id){
                   $ret=$model->where(['user_id'=>$_SESSION['user_id']])->save();

               }else{
                   $model->user_id=$_SESSION['user_id'];
                   $ret=$model->add();
               }
               if($ret !== false){
                   $this->success("成功");
               }else{
                   $this->error('错误,请重试');
               }
           }else{
               $this->error('错误,请重试');
           }
           die;
       }
       $info=$model->where(['user_id'=>$_SESSION['user_id']])->find();
       $this->assign('info',$info);
       $this->display();
   }

/*
 * 员工信息
 * */
    public function company_staff(){
        $model=D("users");
        $info=$model->where(['parent_id'=>$_SESSION['user_id'],'is_lock'=>0,'is_staff'=>1])->select();
        $this->assign('info',$info);
//       dump($info);
        $this->display();
    }
    /**
    添加修改修改员工信息
     */
    public function company_staff_add(){
        $model=D("users");
        if(IS_POST){
            $user_id=I("post.user_id",0);
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
            $upload->exts  =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = './Public/upload/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $image_info   =   $upload->upload();
            $info=$model->where(['user_id'=>$user_id])->find();
//            dump($image_info);
            if($model->create()){
                $model->image="{$image_info['image']['urlpath']}";
                $model->image_t="{$image_info['image_t']['urlpath']}";
                unset($model->user_id);
//                dump( $model->image);
//                dump($model->image_t);
//                die;
                if($user_id){
//                   dump(empty("adasd"));
                    if($model->image==""){
//                       dump( $model->image);
                        $model->image=$info['image'];
                    }
                    if($model->image_t==""){
                        $model->image_t=$info['image_t'];
                    }
                    $model->where(['user_id'=>$user_id])->save();
                }else{
                    $model->parent_id=$_SESSION['user_id'];
                    $model->is_staff=1;
                    $model->add();
                }
                $this->success("操作成功",U("Home/MobileOrder/company_staff"));
            }else{
                $this->error("错误,请重试",U("Home/MobileOrder/company_staff"));
            }

            exit;
        }
        $user_id=I("get.user_id",0);
//         dump($user_id);
        $info=$model->where(['user_id'=>$user_id])->find();
        $this->assign('info',$info);
        $this->assign('user_id',$user_id);
        $this->display();
    }
}