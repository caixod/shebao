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
use Admin\Logic\OrderLogic;
use Think\AjaxPage;

class OrderController extends BaseController {
    public  $order_status;
    public  $pay_status;
    public  $shipping_status;
    /*
     * 初始化操作
     */
    public function _initialize() {
        parent::_initialize();
        C('TOKEN_ON',false); // 关闭表单令牌验证
        $this->order_status = C('ORDER_STATUS');
        $this->pay_status = C('PAY_STATUS');
        $this->shipping_status = C('SHIPPING_STATUS');
        // 订单 支付 发货状态
        $this->assign('order_status',$this->order_status);
        $this->assign('pay_status',$this->pay_status);
        $this->assign('shipping_status',$this->shipping_status);
    }
/**
   发送短信内容给该客户
 *      $content=I("get.content");
$mobile=I("get.mobile");
$table_name=I("get.table_name");
$id=I("get.id");
 */
   public function ajax_send_mess(){
       $content=I("get.content");
       $mobile=I("get.mobile");
       $table_name=I("get.table_name");
       $id=I("get.id");
       if($content && $mobile && $id && $table_name){
           send_mess_to_user($mobile,$content);
           D("{$table_name}")->where(['id'=>$id])->save(array('send_mess'=>$content,'send_date'=>date("Y-m-d H:i:s")));
           echo json_encode(array('code'=>1));
       }else{
           echo json_encode(array('code'=>0));
       }
   }

    /*
    * ajax 删除
    * */
    public function ajax_del(){
        $id=I('get.id');
        $table=I('get.table');
//        dump($table);
//        die;
        $ret= D("{$table}")->where(['id'=>$id])->setField('is_del',1);
        if($ret){
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));die;
        }else{
            echo json_encode(array('code'=>0,'msg'=>'删除失败，请重试'));die;
        }
    }

    /**
    增值服务订单列表
     */
     public function added_services(){
         $status=I('status',0);
         $account_name=I('account_name','');
         $starttime=I('start_time',0);
         $endtime=I('end_time',0);
         $start_time=$starttime > 0 ? strtotime($starttime) : '';
         $end_time=$endtime > 0 ? strtotime($endtime) : '';

         $where=['a.is_del'=>0];


         if($status){
             if($status==10){
                 $where['a.status']=0;
             }else{
                 $where['a.status']=$status;
             }
         }
         if($start_time && $end_time){
             $where['a.time']=['between',"$start_time,$end_time"];
         }
         if($account_name){
             $where['u.account_name']=['like',"%$account_name%"];
         }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
         $model=D("added_services");

         $count      = $model->alias('a')->field("a.*,u.account_name")
             ->join("tp_users as u ON u.user_id=a.user_id",'inner')                   ->where($where)->count();// 查询满足要求的总记录数
         $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
         $Page->parameter['status']   =  urlencode($status);

//        }
         if($start_time && $end_time){
             $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
             $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
         }
         if($account_name){
             $Page->parameter['account_name']=urlencode($account_name);
         }

//        dump($Page->parameter);
         $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
//        dump($where);
         $order_mess=$model->alias('a')
             ->field("a.*,u.account_name,u.username")
             ->join("tp_users as u ON u.user_id=a.user_id",'left')
             ->where($where)
             ->order('a.status asc,a.id asc')
             ->limit($Page->firstRow.','.$Page->listRows)->select();
         $no=$Page->firstRow;
//        dump($order_mess);
         foreach($order_mess as $k=>$v){
             $order_mess[$k]['no']=$no;
             switch($v['status']){
                 case 0: $order_mess[$k]['status']='未处理';
                     break;
                 case 1: $order_mess[$k]['status']='已完成';
                     break;
                 case 2: $order_mess[$k]['status']='无法办理';
                     break;
             }
             $no++;
         }
//        dump($order_mess);
         $this->assign('order_mess',$order_mess);// 赋值数据集
         $this->assign('page',$show);// 赋值分页输出

         $this->assign('status',$status);
         $this->assign('account_name',$account_name);
         $this->assign('start_time',date('Y-m-d',$start_time));
         $this->assign('end_time',date("Y-m-d",$end_time));

         $this->display(); // 输出模板
     }
     /*
      * 处理增值服务
      * **/
      public function added_services_edit(){
          $model=D("added_services");
          if(IS_POST){
              $id=I("post.id");
              $status=I("post.status");
              $ret=$model->where(['id'=>$id])->save(['status'=>$status]);
              if($ret !== false){
                  $this->success("成功",U("Order/added_services"));
              }else{
                  $this->error("失败",U("Order/added_services"));
              }
              die;
          }
          $id=I("get.id");
          $info= $model->alias('a')
              ->field("a.*,u.account_name,u.username")
              ->join("tp_users as u ON u.user_id=a.user_id",'left')
              ->where(['id'=>$id])
              ->order('a.status asc,a.id asc')
              ->find();
          $this->assign('info',$info);
          $this->display();
      }
    /*
     *企业社保订单
     */
    public function sb_company_order_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];


        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sb_company_order");

        $count      = $model->alias('a')->field("a.*,u.account_name")
                 ->join("tp_users as u ON u.user_id=a.user_id",'inner')                   ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
//        }
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
//        dump($where);
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name sname,i.name cname,c.company_name,c.linkman,c.mobile company_mobile ")
            ->join("tp_users as u ON u.user_id=a.user_id",'left')
            ->join("tp_company as c ON c.user_id=a.user_id",'left')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
//        dump($order_mess);
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                 case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }

            switch($v['deal_status']){
                case 0: $order_mess[$k]['deal_status']='正常';
                    break;
                case 1: $order_mess[$k]['deal_status']='到期';
                    break;
                case 2: $order_mess[$k]['deal_status']='续费成功';
                    break;
                case 3:$order_mess[$k]['deal_status']='减员完成';
                    break;

            }
            if(date("Y-m")>=$v['end_time']){
                $order_mess[$k]['deal_status']='到期';
            }

            $no++;
        }
//        dump($order_mess);
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
        处理企业订单
     */
    public function company_order(){
        $model=D("sb_company_order");
        if(IS_POST){
            $id=I('post.id');
            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sb_company_order_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sb_company_order_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        $info=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name,c.company_name,c.linkman,c.mobile company_mobile,c.tel ")
            ->join("tp_users as u ON u.user_id=a.user_id",'left')
            ->join("tp_company as c ON c.user_id=a.user_id",'left')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where(['a.id'=>$id])
            ->find();
//        dump($info);
        $this->assign('info',$info);
        $this->display("_company_order");
    }


    /*
     *社保代缴订单列表
     */
    public function sb_daijiao_list(){
        $status=I('get.status',0);
        $is_pay=I('get.is_pay',0);

        $account_name=I('get.account_name','');
        $starttime=I('get.start_time',0);
        $endtime=I('get.end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sb_daijiao");

        $count      = $model->alias('a')
                        ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
//        foreach($where as $key=>$val) {
            $Page->parameter['status']   =  urlencode($status);
            $Page->parameter['is_pay']   =  urlencode($is_pay);
//        }
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            switch($v['deal_status']){
                case 0: $order_mess[$k]['deal_status']='正常';
                    break;
                case 1: $order_mess[$k]['deal_status']='到期';
                    break;
                case 2: $order_mess[$k]['deal_status']='续费成功';
                    break;
                case 3:$order_mess[$k]['deal_status']='减员完成';
                    break;

            }
            if(date("Y-m")>=$v['end_time']){
                $order_mess[$k]['deal_status']='到期';
            }


            $no++;
        }
//        dump($order_mess);
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));
        $this->display(); // 输出模板

    }

    /**
    修改社保代缴信息
     */
    public function sb_daijiao_edit(){
        $model=D("sb_daijiao");
        if(IS_POST){
            $id=I('post.id');
            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sb_daijiao_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sb_daijiao_list'));
                }
            }else{
                $this->error("错误……");
            }



            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $mouth_d=getMonthNum($info['start_time'],$info['end_time']);//差额月
            $mouth_d=$mouth_d==0 ? 1 : $mouth_d;
            $info['sb_unit_fee']=round(($info['sb_fee']/$mouth_d),2);
            $info['gjj_unit_fee']=round(($info['gjj_fee']/$mouth_d),2);
            $this->assign('info',$info);
        }

//        dump($info);
        $this->assign('id',$id);
        $this->display();
    }


    /*
     *社保补缴订单列表
     */
    public function sb_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sb_bujiao");

        $count      = $model->alias('a')
                        ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }

            switch($v['deal_status']){
                case 0: $order_mess[$k]['deal_status']='正常';
                    break;
                case 1: $order_mess[$k]['deal_status']='到期';
                    break;
                case 2: $order_mess[$k]['deal_status']='续费成功';
                    break;
                case 3:$order_mess[$k]['deal_status']='减员完成';
                    break;

            }
            if(date("Y-m")>=$v['end_time']){
                $order_mess[$k]['deal_status']='到期';
            }

            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改社保补缴信息
     */
    public function sb_edit(){
        $model=D("sb_bujiao");
        if(IS_POST){
            $id=I('post.id');
            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sb_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sb_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $mouth_d=getMonthNum($info['start_time'],$info['end_time']);//差额月
            $mouth_d=$mouth_d==0 ? 1 : $mouth_d;
            $info['sb_unit_fee']=round(($info['sb_fee']/$mouth_d),2);
            $info['gjj_unit_fee']=round(($info['gjj_fee']/$mouth_d),2);
            $this->assign('info',$info);
        }

//        dump($mouth_d);
//        dump($info);
        $this->assign('id',$id);
        $this->display();
    }

    /*
     *社保转移订单列表
     */
    public function sb_zhuanyi_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sb_zhuanyi");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        /****tp框架bug不能设置数组类的查询只能这么写**/
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,r.name op_name,e.name oc_name,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as r ON r.id=a.out_province",'left')
            ->join("tp_region as e ON e.id=a.out_city",'left')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
         修改s社保转移信息
     */
    public function sb_zhuanyi_edit(){
        $model=D("sb_zhuanyi");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sb_zhuanyi_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sb_zhuanyi_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,r.name op_name,e.name oc_name,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as r ON r.id=a.out_province",'left')
                ->join("tp_region as e ON e.id=a.out_city",'left')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
     *公积金转移订单列表
     */
    public function gjj_zhuanyi_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("gjj_zhuanyi");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        /****tp框架bug不能设置数组类的查询只能这么写**/
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,r.name op_name,e.name oc_name,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as r ON r.id=a.out_province",'left')
            ->join("tp_region as e ON e.id=a.out_city",'left')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板


    }


    /**
         修改s公积金转移信息
     */
    public function gjj_zhuanyi_edit(){
        $model=D("gjj_zhuanyi");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/gjj_zhuanyi_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/gjj_zhuanyi_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,r.name op_name,e.name oc_name,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as r ON r.id=a.out_province",'left')
                ->join("tp_region as e ON e.id=a.out_city",'left')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
    公积金提取订单列表
    */
    public function gjj_tiqu_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("gjj_tiqu");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改公积金提取信息
     */
    public function gjj_tiqu_edit(){
        $model=D("gjj_tiqu");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/gjj_tiqu_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/gjj_tiqu_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
    医疗手工帐订单列表
    */
    public function yl_sgz_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("yl_sgz");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改医疗收工张信息
     */
    public function yl_sgz_edit(){
        $model=D("yl_sgz");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/yl_sgz_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/yl_sgz_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
   生育申领订单列表
    */
    public function sy_shenqing_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sy_shenqing");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改生育信息
     */
    public function sy_shenqing_edit(){
        $model=D("sy_shenqing");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sy_shenqing_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sy_shenqing_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
 *异地备案就医订单列表
 */
    public function yd_bajy_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("yd_bajy");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改异地备案就医信息
     */
    public function yd_bajy_edit(){
        $model=D("yd_bajy");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/yd_bajy_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/yd_bajy_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
 *社保信息修改 订单列表
 */
    public function sb_editinfo_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("sb_editinfo");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改社保信息修改 信息
     */
    public function sb_editinfo_edit(){
        $model=D("sb_editinfo");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/sb_editinfo_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/sb_editinfo_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username  uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
*个税订单列表
*/
    public function own_money_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("own_money");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改个税修改 信息
     */
    public function own_money_edit(){
        $model=D("own_money");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/own_money_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/own_money_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
*退休订单列表
*/
    public function tx_yanglao_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("tx_yanglao");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;
            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改退休养老修改 信息
     */
    public function tx_yanglao_edit(){
        $model=D("tx_yanglao");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/tx_yanglao_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/tx_yanglao_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }


    /*
*上学材料订单列表
*/
    public function school_info_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("school_info");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;

            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    上学材料修改
     */
    public function school_info_edit(){
        $model=D("school_info");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/school_info_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/school_info_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
*天津人才引进列表
*/
    public function rc_yingjin_list(){
        $status=I('status',0);
        $is_pay=I('is_pay',0);

        $account_name=I('account_name','');
        $starttime=I('start_time',0);
        $endtime=I('end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_pay){
            if($is_pay==2){
                $where['a.is_pay']=0;
            }else{
                $where['a.is_pay']=1;
            }

        }

        if($status){
            if($status==10){
                $where['a.status']=0;
            }else{
                $where['a.status']=$status;
            }

        }
        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
        if($account_name){
            $where['u.account_name']=['like',"%$account_name%"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("rc_yingjin");

        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['status']   =  urlencode($status);
        $Page->parameter['is_pay']   =  urlencode($is_pay);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }
        if($account_name){
            $Page->parameter['account_name']=urlencode($account_name);
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->join("tp_region as g ON g.id=a.to_province",'left')
            ->join("tp_region as i ON i.id=a.to_city",'left')
            ->where($where)
            ->order('a.status asc,a.add_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $no=$Page->firstRow;
        foreach($order_mess as $k=>$v){
            $order_mess[$k]['no']=$no;

            switch($v['status']){
                case 0: $order_mess[$k]['status']='未审核';
                    break;
                case 1: $order_mess[$k]['status']='已审核';
                    break;
                case 2: $order_mess[$k]['status']='审核通过';
                    break;
                case 3:$order_mess[$k]['status']='办理中';
                    break;
                case 4: $order_mess[$k]['status']='已完成';
                    break;
            }
            $no++;
        }
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('status',$status);
        $this->assign('is_pay',$is_pay);
        $this->assign('account_name',$account_name);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));

        $this->display(); // 输出模板

    }


    /**
    修改天津人才引进 信息
     */
    public function rc_yingjin_edit(){
        $model=D("rc_yingjin");
        if(IS_POST){
            $id=I('post.id');
//            $status=I("post.status");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 1024*1024;// 设置附件上传大小
//            $upload->exts  =     array('dco', 'docx','PDF');// 设置附件上传类型
            $upload->rootPath  = './Public/certify/'; // 设置附件上传根目录
            // 上传单个文件
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $info   =   $upload->upload();

            if($model->create()){
                $info['ht']['urlpath']===null ? 0 :$info['ht']['urlpath'];
                if($info['ht']['urlpath']){
                    $model->ht=$info['ht']['urlpath'];
                }
                $info['certify']['urlpath']===null ? 0 :$info['certify']['urlpath'];
                if($info['certify']['urlpath']){
                    $model->certify=$info['certify']['urlpath'];
                }
                unset($model->id);
                $result=$model->where(['id'=>$id])->save();
                if($result){
                    $this->success('操作成功',U('Admin/Order/rc_yingjin_list'));
                }else{
                    $this->error('操作失败,请重试',U('Admin/Order/rc_yingjin_list'));
                }
            }else{
                $this->error("错误……");
            }
            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->alias('a')
                ->field('a.*,u.account_name,u.username uname,g.name top_name,i.name toc_name')
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->join("tp_region as g ON g.id=a.to_province",'left')
                ->join("tp_region as i ON i.id=a.to_city",'left')
                ->where(['a.id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

}
