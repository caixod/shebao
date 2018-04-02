<?php
namespace Admin\Controller;
use Think\AjaxPage;
use Think\Page;
class ManageController extends BaseController{

    public $where_general_list = array('is_del'=>0); //定义全局通用条件语句，比如 列表中没有被删除的数据is_del=0
    /*
     *地区基本设置
     * */
   public function area_list(){
       $where=['flag'=>1,'parent_id'=>0,'level'=> 1,];
       $data=D("region")->field('id,name')->where($where)->select();
       $k_data=tree($data);//查找开通的省下面的市区
       $area_list=[];
       $no=0;
       foreach($k_data as $k=>$v){
           foreach($v as $kk=>$vv){
               $no++;
               $area_list[$no]=['id'=>$vv['id'],'province'=>$k,'city'=>$vv['name']];
           }
       }
//       dump($area_list);
       $this->assign('area_list',$area_list);
       $this->display();
   }
    /**
      修改地区信息
     */
    public function area_add(){
        $model=D("region");
        if(IS_POST){
//            dump($_POST);die;
            $id=I('post.id');
            $own_service_mess=I('post.own');//个人办理的费用
            $company_service_mess=I('post.company');//企业办理的费用
//            $model->where(['id'=>$province_id])->setField('flag',1);
            if($model->create()){
                $model->sb_daijiao=json_encode($own_service_mess);
                $model->company_sb_daijiao=json_encode($company_service_mess);
                $result = $model->where(['id'=>$id])->save(); // 写入数据到数据库

                if($result !==false){
                    $this->success('修改成功',U('Admin/Manage/area_list'));
                }else{
                    $this->error('修改失败,请重试',U('Admin/Manage/area_list'));
                }
            }

            exit;
        }
        $id=I('get.id');
        if($id){

          $info=$model->field("a.*,g.name gname")
              ->alias('a')->where(['a.id'=>$id])
              ->join("tp_region as g ON g.id=a.parent_id",'left')
              ->find();
          //将社保的json数据转化过来
            $own_service_mess=json_decode($info['sb_daijiao'],true);
            $company_service_mess=json_decode($info['company_sb_daijiao'],true);
            $this->assign('own',$own_service_mess);
            $this->assign('company',$company_service_mess);
            $this->assign('info',$info);
            $this->assign('id',$id);
//            dump($own_service_mess);
        }


       $this->display();
   }

    /*
     * 添加地区
     * */

    public function area_new_add(){
        $model=D("region");
        if(IS_POST){
//            dump($_POST);die;
            $own_service_mess=I('post.own');//个人办理的费用
            $company_service_mess=I('post.company');//企业办理的费用
            $city_id=I('post.city');
            $province_id=I('post.province');
            $model->where(['id'=>$province_id])->setField('flag',1);
            if($model->create()){
                $model->sb_daijiao=json_encode($own_service_mess);
                $model->company_sb_daijiao=json_encode($company_service_mess);
              unset($model->province);
              unset($model->city);
                $model->flag=1;
                $result = $model->where(['id'=>$city_id])->save(); // 写入数据到数据库

                if($result !==false){
                  $this->success('地区开通成功',U('Admin/Manage/area_list'));
                }else{
                    $this->error('开通失败,请重试',U('Admin/Manage/area_list'));
                }
            }

            exit;
        }

        $where=['parent_id'=>0,'level'=> 1,];
        $p=$model->field('id,name')->where($where)->select();

        $this->assign('province',$p);
       $this->display();
   }

    /*
     * ajax 删除地区
     * */
    public function area_del(){
        $id=I('get.id');
       $ret= D("region")->where(['id'=>$id])->setField('flag',0);
//        dump($ret);
       if($ret){
           echo json_encode(array('code'=>1,'msg'=>'删除成功'));die;
       }else{
           echo json_encode(array('code'=>0,'msg'=>'删除失败，请重试'));die;
       }
   }

    /*
     *社保基本设置
     * */
   public function sb_list(){
       $where=['flag'=>1,'parent_id'=>0,'level'=> 1,];
       $data=D("region")->field('id,name')->where($where)->select();
       $k_data=tree($data);//查找开通的省下面的市区
       $area_list=[];
       $no=0;
       foreach($k_data as $k=>$v){
           foreach($v as $kk=>$vv){
               $no++;
               $area_list[$no]=['id'=>$vv['id'],'province'=>$k,'city'=>$vv];
           }
       }
//       dump($area_list);
       $this->assign('area_list',$area_list);
       $this->display();
   }
    /**
    修改社保信息
     */
    public function sb_edit(){
        $model=D("region");
        if(IS_POST){
            $id=I('post.id');

            if($model->create()){
                unset($model->id);
                unset($model->name);
                $result = $model->where(['id'=>$id])->save(); // 写入数据到数据库
                if($result){
                    $this->success('修改成功',U('Admin/Manage/sb_list'));
                }else{
                    $this->error('修改失败,请重试',U('Admin/Manage/sb_list'));
                }
            }

            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->where(['id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }

    /*
     *公积金基本设置
     * */
   public function gjj_list(){
       $where=['flag'=>1,'parent_id'=>0,'level'=> 1,];
       $data=D("region")->field('id,name')->where($where)->select();
       $k_data=tree($data);//查找开通的省下面的市区
       $area_list=[];
       $no=0;
       foreach($k_data as $k=>$v){
           foreach($v as $kk=>$vv){
               $no++;
               $area_list[$no]=['id'=>$vv['id'],'province'=>$k,'city'=>$vv];
           }
       }
//       dump($area_list);
       $this->assign('area_list',$area_list);
       $this->display();

   }
    /**
    修改公积金信息
     */
    public function gjj_edit(){
        $model=D("region");
        if(IS_POST){
            $id=I('post.id');

            if($model->create()){
                unset($model->id);
                unset($model->name);
                $result = $model->where(['id'=>$id])->save(); // 写入数据到数据库
                if($result){
                    $this->success('修改成功',U('Admin/Manage/gjj_list'));
                }else{
                    $this->error('修改失败,请重试',U('Admin/Manage/gjj_list'));
                }
            }

            exit;
        }
        $id=I('get.id');
        if($id){
            $info=$model->where(['id'=>$id])->find();
            $this->assign('info',$info);
        }

        $this->assign('id',$id);
        $this->display();
    }


    /*
     * 代金券发放
     * */

    public function coupon_list(){

        $is_use=I('get.is_use',0);

        $starttime=I('get.start_time',0);
        $endtime=I('get.end_time',0);
        $start_time=$starttime > 0 ? strtotime($starttime) : '';
        $end_time=$endtime > 0 ? strtotime($endtime) : '';

        $where=['a.is_del'=>0];

        if($is_use){
                $where['a.is_use']=$is_use;
        }

        if($start_time && $end_time){
            $where['a.add_time']=['between',"$start_time,$end_time"];
        }
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
        $model=D("coupon");
//        dump($where);
        $count      = $model->alias('a')
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter['is_use']   =  urlencode($is_use);
        if($start_time && $end_time){
            $Page->parameter['start_time']=urlencode(date('Y-m-d',$start_time));
            $Page->parameter['end_time']=urlencode(date('Y-m-d',$end_time));
        }

//        dump($Page->parameter);
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $order_mess=$model->alias('a')
            ->field("a.*,u.username,u.account_name")
            ->join("tp_users as u ON u.user_id=a.user_id",'left')
            ->where($where)
            ->order('add_time')
            ->limit($Page->firstRow.','.$Page->listRows)->select();

//        dump($order_mess);
        $this->assign('order_mess',$order_mess);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('is_use',$is_use);
        $this->assign('start_time',date('Y-m-d',$start_time));
        $this->assign('end_time',date("Y-m-d",$end_time));
        $this->display(); // 输出模板
    }
    /*
 * ajax 删除
 * */
    public function coupon_del(){
        $id=I('get.id');
        $ret= D("coupon")->where(['id'=>$id])->setField('is_del',1);
//        dump($ret);
        if($ret){
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));die;
        }else{
            echo json_encode(array('code'=>0,'msg'=>'删除失败，请重试'));die;
        }
    }
    /*
     * 代金券添加
     * */
    public function coupon_add(){
        $model=D("coupon");
        if(IS_POST){
          $user_id_arr=I('post.user_id');
          $start_time=I("post.start_time");
          $money=I("post.money");
          $max_fee=I("post.max_fee");
          $end_time=I("post.end_time");
          foreach($user_id_arr as $k=>$v){
              $code="V".$v.date("Ymd").mt_rand(1,9);
              $dat=[
                  'user_id'=>$v,
                  'coupon_code'=>$code,
                  'money'=>$money,
                  'max_fee'=>$max_fee,
                  'start_time'=>$start_time,
                  'end_time'=>$end_time,
                  'add_time'=>time(),
              ];
              $model->add($dat);
          }
       $this->success("发放成功",U("Manage/coupon_list"));
            die;
        }
        $user_list=D("users")->field('user_id,username,account_name')->where(['is_lock'=>0,'account_name'=>array('gt','0')])->select();
        foreach($user_list as $k=>$v){
            if($v['username']==""){
                $user_list[$k]['username']=$v['account_name'];
            }
        }
        $this->assign('user_list',$user_list);
        $this->display();

    }
    /*
     * 代金券修改
     * */
    public function coupon_edit(){
        $model=D("coupon");

        if(IS_POST){
            $id=I('post.id');
            $start_time=I("post.start_time");
            $money=I("post.money");
            $end_time=I("post.end_time");
            $max_fee=I("post.max_fee");
//            dump($id);die;
            if($id){
                $dat=[
                    'money'=>$money,
                    'max_fee'=>$max_fee,
                    'start_time'=>$start_time,
                    'end_time'=>$end_time,];
                $ret=$model->where(['id'=>$id])->save($dat);
                if($ret){
                    $this->success("修改成功",U("Manage/coupon_list"));
                }else{
                    $this->error("操作失败",U("Manage/coupon_list"));
                }
            }else{
                $this->error("操作失败",U("Manage/coupon_list"));
            }
            die;
        }
        $id=I("get.id");
        if($id){
            $info=$model->alias('a')
                ->field("a.*,u.username,u.account_name")
                ->join("tp_users as u ON u.user_id=a.user_id",'inner')
                ->where(['a.id'=>$id])->find();
            $info['username']=$info['username']=="" ? $info['account_name'] :$info['username'];
            $this->assign('info',$info);
        }
        $this->display();

    }

    /*
     * 问题反馈
     * */
    public function up_question(){
        $data=D("question")->select();
        $this->assign('data',$data);
        $this->display();
    }
    /*
     * 消息发送
     * */
    public function news_list(){
        $model=D("news");
        $data=$model->alias('a')
            ->field("a.*,u.username,u.account_name,u.mobile")
            ->join("tp_users as u ON u.user_id=a.user_id",'inner')
            ->where(['a.is_del'=>0])
            ->select();
//        dump($data);
        $this->assign('data',$data);
        $this->display();
    }
    public function news_del(){
        $id=I('get.id');
        $ret= D("news")->where(['id'=>$id])->setField('is_del',1);
//        dump($ret);
        if($ret){
            echo json_encode(array('code'=>1,'msg'=>'删除成功'));die;
        }else{
            echo json_encode(array('code'=>0,'msg'=>'删除失败，请重试'));die;
        }
    }

    public function add_news(){
        $model=D("news");
        if(IS_POST){
            $id=I('post.id',0);
            $question_content=I('post.question_content');
            $user_id=I('post.user_id',0);


            if($id){
               $ret= $model->where(['id'=>$id])->save(['question_content'=>$question_content]);
            }else{
                $ret= $model->add(['question_content'=>$question_content,'user_id'=>$user_id,'time'=>time()]);

            }
            if($ret){
                $this->success("操作成功",U("Manage/news_list"));
            }else{
                $this->error("操作失败",U("Manage/news_list"));
            }
            die;
        }

        $id=I("get.id");
        $user_info=D("users")->field("user_id,username,account_name")->where(['is_lock'=>0,'account_name'=>array('gt','0')])->select();
//        dump($user_info);
            if($id){
                $info=$model->where(['id'=>$id])->find();
                $this->assign('info',$info);
            }

        $this->assign('user_info',$user_info);
        $this->display();
    }
   /*
     * 短信消息发送
     * */
    public function sms_send_list(){
        $model=D("sms_send");
        $data=$model->where(['is_del'=>0])->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function add_sms_send(){
        $model=D("sms_send");
        if(IS_POST){
            $content=I('post.content');
            $mobile=I('post.mobile');
            send_mess_to_user($mobile,$content);
                $ret= $model->add(['content'=>$content,'mobile'=>$mobile,'time'=>time()]);
            if($ret){
                $this->success("发送成功",U("Manage/sms_send_list"));
            }else{
                $this->error("发送失败",U("Manage/sms_send_list"));
            }
            die;
        }

        $id=I("get.id");
//        dump($user_info);
            if($id){
                $info=$model->where(['id'=>$id])->find();
                $this->assign('info',$info);
            }

        $this->display();
    }
    public function pay_config(){
        $model=D("dlb_config");
        if(IS_POST){
            $id=I('post.id');

            if($model->create()){
                unset($model->id);
                if($id){
                    $ret= $model->where(['id'=>$id])->save();
                }else{
                    $ret= $model->add();
                }
     
                if($ret){
                    $this->success("操作成功",U("Manage/pay_config"));
                }else{
                    $this->error("操作失败",U("Manage/pay_config"));
                }
            }else{
                $this->error("操作失败",U("Manage/pay_config"));
            }

            die;
        }
           $info=$model->find();
//        dump($info);
            $this->assign('info',$info);
        $this->display();
    }




}