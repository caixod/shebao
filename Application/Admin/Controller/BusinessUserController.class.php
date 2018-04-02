<?php
namespace Admin\Controller;
use Think\AjaxPage;
use Think\Page;
/*
添加店铺，分店和总店
*/
class BusinessUserController extends BaseController{

    public $where_general_list = array('del'=>0); //定义全局通用条件语句，比如 列表中没有被删除的数据is_del=0




    //商业用户列表
    public function businessUserList(){
        //header("Content-type:text/html;charset=utf-8");
        $model = M("Business_user");
        $where = array();
        $keyword = I('keyword');
        $where = $keyword ?  array('user_name'=>array('like',"%{$keyword}%")) : array();
        $where = $this->where_general_list+$where;
        $count = $model->where($where)->count();
        $Page  = new Page($count,10);
        $list = $model
            //->alias("a")
            //->join("region b ON a.business_user_id = b.id ","left")
            ->where($where)
            ->order("sort asc")
            ->limit($Page->firstRow.','.$Page->listRows)
            //->field("*,a.id id,a.name name,a.address address,b.address user_address")
            ->select();
        $region_list = get_region_list();
        $show  = $Page->show();
        $this->assign('show',$show);
        $this->assign('storeList',$list);
        $this->assign('region_list',$region_list);
        $this->display();
    }

    //修改编辑商业用户
    public function addEditBusinessUser(){
        $id = I('get.id');
        $model = M("Business_user");
        if(IS_POST)
        {
            if($id){
                $_POST['update_time'] = time();
                $data_obj = $model->create();
                $model->save();
            }else{
                $_POST['update_time'] = $_POST['create_time'] = time();
                $model->create();
                $id = $model->add();
            }
            $this->success("操作成功!!!",U('Admin/BusinessUser/businessUserList',array('p'=>$_GET['p'])));
            exit;
        }
        $list = $model->find($id);
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->select();
        //编辑的时候拉取现有数据
       if($id){
           //获取省份
           $c = M('region')->where(array('parent_id'=>$list['province'],'level'=> 2))->select();
           $d = M('region')->where(array('parent_id'=>$list['city'],'level'=> 3))->select();
           if($list['town']){
               $e = M('region')->where(array('parent_id'=>$list['district'],'level'=>4))->select();
               $this->assign('town',$e);
           }
           $this->assign('city',$c);
           $this->assign('district',$d);
       }
        $this->assign('province',$p);
        $this->assign('list',$list);
        //var_export($business_user);exit;
        $this->display('_addEditBusinessUser');
    }

    /**
     * 删除商业用户
     */
    public function delBusinessUser(){
        $model = M("Business_user");
        // 判断当前用户是否在正常使用
        $status_yes = $model->where(array('id'=>$_GET['id']))->getField('status');
        //判断当前用户下面有无正常使用的门店
        $where_store_count = array('is_del'=>0);
        $store_count = M("store")->where($where_store_count)->count();
        if($status_yes)
        {
            $return_arr = array('status' => -1,'msg' => '此用户状态正常不得删除!请先关停后重试!','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
            $this->ajaxReturn(json_encode($return_arr));
        }else if($store_count>0){
            $return_arr = array('status' => -1,'msg' => '此用户下尚有门店营业!请先关停后重试!','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
            $this->ajaxReturn(json_encode($return_arr));
        }


        $re_del = $model->where('id ='.$_GET['id'])->data(array('del'=>1))->save();
        if($re_del !== false){
            $return_arr = array('status' => 1,'msg' => '操作成功','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
        }else{
            $return_arr = array('status' => -1,'msg' => '操作失败，请重试','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
        }

        $this->ajaxReturn(json_encode($return_arr));
    }

    //取微信分组
    public function ajaxGetTags(){
        $b_u_id = I("b_u_id");
        $model = M("business_user_role");
        //$model_user_tags = M("business_role_to_user");
        $tags_list = $model
                    ->alias("a")
                    ->join("tp_business_role_to_user as b ON a.id=b.business_role_id","left")
                    ->where(array('a.status'=>1,'b.is_del'=>0))
                    ->field("a.name,a.id,b.business_user_id,a.tag_id,b.business_role_id")
                    ->select();

        if($tags_list){
            $s=1;
            $m = '获取成功';
        }else{
            $s=0;
            $m='获取失败';
        }
        $this->ajaxReturn(array('status'=>$s,'msg'=>$m,'data'=>json_encode($tags_list,JSON_UNESCAPED_UNICODE)));
    }

    //ajax改变用户角色;只允许改变一次?
    public function ajaxChangeTags(){
        $model = M("business_role_to_user");
        $b_u_id  = I("b_u_id");
        $tags_arr = I("tags");  //array
        $tags_cur = $model->where(array('business_user_id'=>$b_u_id))->getField("business_role_id",true);
        //删除当前的
        if(count($tags_cur)>0){
            $re_del = $model
                ->where(array('business_user_id'=>$b_u_id))
                ->delete();
        }
        $insert_data = array();
        foreach($tags_arr as $k => $v){
            $insert_data[] = array(
                'business_user_id' => $b_u_id,
                'business_role_id'  => $v,
                'create_time' =>time(),
                'update_time' => time(),
                'status' => 1,
                'is_del' => 0
            );
        }

        $re_add = $model->addAll($insert_data);
        if(count($tags_cur)>0 ){
            if($re_del && $re_add){
                $this->ajaxReturn(array('status'=>1,'msg'=>'执行成功','data'=>array()));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'执行失败','data'=>array()));
            }

        }else{
            if($re_add){
                $this->ajaxReturn(array('status'=>1,'msg'=>'执行成功','data'=>array()));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'执行失败请重试','data'=>array()));
            }
        }

    }

    //角色List
    public function BusinessUserRoleList(){
        $model = M("business_user_role");
        $list = $model
            ->alias("a")
            ->join("tp_wx_tags as b ON a.tag_id=b.tag_id","left")
            ->field("a.id,a.name,a.tag_id,b.tag_name")
            ->where(array('a.status'=>1,'a.is_del'=>0))
            ->order("a.id ASC")
            ->select();
        $this->assign('list',$list);
        $this->display("roleList");
    }
    //添加编辑角色
    public function addEditRole(){
        $id = I("id");
        $model = M("business_user_role");
        if(IS_POST){
            $name = I("name");
            $tag_id = I("tag_id");
            if(!empty($id)){//编辑
                $re = $model->where(array('id'=>$id))->save(array('name'=>$name,'tag_id'=>$tag_id));
            }else{  //新增
                $re = $model->add(array('name'=>$name,'tag_id'=>$tag_id));
            }
            if($re !== false){
                $this->success("执行成功",U('Admin/BusinessUser/BusinessUserRoleList'));
            }else{
                $this->error("执行失败，请重试");
            }
        }else{
            $tags = M("wx_tags")->select();
            $role = $model->where(array('id'=>$id))->find();
            $this->assign("tags",$tags);
            $this->assign('role',$role);
            $this->display('_addEditRole');
        }

    }

    //删除角色
    public function delRole(){
        $id = I("id",0);
        $model = M("business_user_role");
        if($id){
            $re = $model->where(array('id'=>$id))->save(array("is_del"=>1,"is_del_time"=>time()));
        }else{
            $this->error("执行出错，请重试");
            exit;
        }
        if($re !== false){
            $this->success("删除成功",U('Admin/BusinessUser/BusinessUserRoleList'));
        }else{
            $this->error("删除失败，请重试");
        }
    }

////////////////////////
}
