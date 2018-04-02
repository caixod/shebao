<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 北京易启东方网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.shop.yiqidongfang.com
 * ----------------------------------------------------------------------------
 *
 * ============================================================================
 * $Author:  2016-01-09
 */ 
namespace Dish\Controller;
class IndexController extends MobileBaseController {
    public $store_id='';
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

    }

    public function index(){
//        dump($_SESSION);
//        header("Access-Control-Allow-Origin: *");
        /*if(!isMobile()){
                    header("Content-type:text/html;charset=utf-8");
                    exit('请使用用移动设备访问');
                }*/

            //获取微信配置
            $wechat_list = M('wx_user')->select();
            $wechat_config = $wechat_list[0];
            $this->weixin_config = $wechat_config;        
            // 微信Jssdk 操作类 用分享朋友圈 JS            
            $jssdk = new \Mobile\Logic\Jssdk($this->weixin_config['appid'], $this->weixin_config['appsecret']);
            $signPackage = $jssdk->GetSignPackage();              
            //print_r($signPackage);


        //获取微信配置
        $mpInfo = M("wx_user")->where(array("id"=>1))->find();
        //获取省份
        $p = M('region')->where(array('parent_id'=>0,'level'=> 1))->cache(true,3600)->select();

        $this->assign('mpInfo',$signPackage);
        $this->assign('province',$p);
        //$this->assign('city',$c);
        //$this->assign('district',$d);
        $this->display('restaurantList');
    }

    /**
     * 获取当前城市的店铺列表
     */
    public function getStoreListOfCurrentCity(){
        //$province = I("get.");
        $city = I("get.city");
        $field = I("get.field");
        $lng = I("get.lng");
        $lat = I("get.lat");
        $lng_lat_arr = switchAnyLngLatToAmap($lng,$lat,'gps');
        $lng = $lng_lat_arr['lng'];
        $lat = $lng_lat_arr['lat'];
        $city = empty($city) ? 2 : $city ;
        $store_list = M("Store")->where(array($field=>$city))->select();
        foreach($store_list as $k => $v){
            //$kilometre = sqrt(pow(($lng-$v['longitude']),2)+pow(($lat-$v['latitude']),2));
            $kilometre = getDistanceBetweenCoordinate($lng,$lat,$v['longitude'],$v['latitude'],'km',2);
            $store_list[$k]['kilometre'] = $kilometre;
        }
        //echo $lng.'<br />'.$lat.'<br /><br />';
        //var_export($store_list);exit;
        //echo $lng.'<br />'.$lat;exit;
        $this->assign('lng_now',$lng);
        $this->assign('lat_now',$lat);
        $this->assign('list',$store_list);
        $this->display("ajaxStoreList");
        //$this->ajaxReturn(array('msg'=>'获取成功','status'=>1,'data'=>$store_list));
    }


    
    public function ajaxGetMore(){
    	$p = I('p',1);
    	$favourite_goods = M('goods')->where("is_recommend=1 and is_on_sale=1")->order('goods_id DESC')->page($p,10)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
    	$this->assign('favourite_goods',$favourite_goods);
    	$this->display();
    }

    /*************点餐*****************/

    //餐厅列表
    public function restaurantList(){



        $this->display();
    }

    //菜品列表
    public function dishList(){

        $store_id = I("get.store_id");
        //echo $store_id;exit;
        $sort_list = M("Dish")
            ->alias("a")
            ->field("distinct a.sort_id,b.name")
            ->join("tp_dish_sort as b ON a.sort_id=b.id")
            ->where(array("a.is_del"=>0,"b.status"=>1,"b.is_del"=>0))
            //->cache(3600)
            ->select();
        $this->assign('sort_list',$sort_list);
        $this->assign("store_id",$store_id);
        $this->display();
    }

    //拉取style_two的页面
    public function getStyleTwo(){
        $store_id = I('get.store_id');
        //分类列表
        $sort_list = M("Dish")
            ->alias("a")
            ->field("distinct a.sort_id,b.name")
            ->join("tp_dish_sort as b ON a.sort_id=b.id")
            ->where(array("a.is_del"=>0,"b.status"=>1,"b.is_del"=>0))
            //->cache(3600)
            ->select();

        $dish_list = M("dish_to_store_restaurant")
            //->cache(3600)
            ->alias("a")
            ->field("
                    a.dish_id,
                    a.restaurant_id,
                    a.standard_on_off as standard_on_off_son,
                    a.pungency_on_off as pungency_on_off_son,
                    a.price,
                    a.instock,
                    a.is_hot,
                    a.is_discount,
                    a.sort,
                    b.standard_on_off as standard_on_off_father,
                    b.pungency_on_off as pungency_on_off_father,
                    b.unit
                    ")
            ->join("tp_dish_attribute as b ON a.dish_id=b.dish_id","left")
            ->where(array('a.store_id'=>$store_id,'a.status'=>1))
            ->select();
        $dish_sort_key_list = array();
        foreach($dish_list as $k => $v){
            $dish_sort_key_list[getSortId($v['dish_id'])][] = $v;
        }

        //$unit_list = M("dish_unit")->;
        //echo $_GET['store_id'];exit;
        //var_export($dish_sort_key_list);exit;
        //var_export(getSortId());exit;
        //var_export($sort_list);exit;
        //var_export($dish_sort_key_list);exit;
        //var_export($standard_list);exit;
        //$this->assign("standard_list",$standard_list);
        //var_export(getStandardList(145));exit;
        $this->assign('dish_list',$dish_sort_key_list);
        $this->assign('sort_list',$sort_list);
        $this->display('style_two');
    }

    //订单确认列表
    public function confirmList(){
        $store_id = I("get.store_id");
        if(IS_POST){
            cookie("dish_item",null);
            cookie("total_fee",null);
            $dish = $_POST['dish'];
            $total_fee = I("post.total_fee");
            cookie("dish_item",$dish);
            cookie('total_fee',$total_fee);

        }

        $dish_arr = cookie("dish_item");
        $total_fee = cookie("total_fee");

        foreach($dish_arr as $k=>$v){
            $v = json_decode($v,true);
            $dish_arr[$k] = $v;
            $dish_arr[$k]['total_fee'] = formatFloat($v['dish_price'])*$v['dish_num'];//带小数点的钱，做字符串处理然后拼接成整计算
        }
       
        //header("Content-type:text/html;charset=utf-8");
        //var_export($dish_arr);exit;
        $this->assign('confirm_list',$dish_arr);
        $this->assign('total_fee',$total_fee);
        $this->assign('store_id',$store_id);
        $this->display();
    }


    //订单入库
    public function confirmOrder(){
        if(IS_POST){
            $store_id=I('get.store_id');
            if(empty($store_id)){
                exit("没有店铺id，请重新登录");
            }
            /***再次下单前，默认将本店排队购买的所有未删除但又未支付的订单全部标记为删除，
             * 避免顾客扫吗时候获取到其他顾客未支付的订单
             is_dish   0为排队购买时候的订单，1为去点餐系统下单的订单
             **/
            $del_where=['store_id'=>$store_id,'paid'=>0,'is_del'=>0,'is_dish'=>0];
            D("dish_order")->where($del_where)->setField('is_del',1);

            $dish_mess=I("post.");
            $dish_info_id=$dish_mess['id'];
            //取出本蛋糕的详情
            $dish_info=D("dish")->alias('a')
                ->join("tp_dish_to_store_restaurant b ON a.id=b.dish_id",'left')
                ->where("b.store_id={$store_id} AND b.id={$dish_info_id}")
                ->field("a.dish_name,b.*")->find();

            $data_order = array(); //订单数据
            $take_away = 1; //1 堂食、2 外卖

//            dump($total_fee);//40.70
            $total_fee = $dish_mess['customer']*100;   //传递过来订单总价 换算成分
//            dump($total_fee);die;//4070
            $store_id = I("get.store_id");
                 //详细的订单插入dish_order_info
                $data_order_dish= array(
                    //'order_id'=>,
                    'restaurant_id'=>$dish_info['restaurant_id'],
                    'dish_id'=>$dish_info['dish_id'],
                    'standard_id'=>1,
                    'dish_num'=>1,
                    'price_cerrent'=>$dish_info['price'],
                    'standard_name'=>'份',
                    'total_fee_current'=>$total_fee
                );

                //主订单数据
                $data_order['remarks'] = I("post.remarks",'无');
                $data_order['store_id'] = $store_id;
                $data_order['openid'] = session('openid');    //用户的微信openid
                $data_order['is_dish'] = 0;    //排队下单的订单
                $data_order['dish_total_num'] = 1; //本订单菜品总数
                $data_order['order_total_fee'] = $total_fee;  //订单总价
                $data_order['total_weight'] = $dish_mess['total_weight'];  //总重量
                $data_order['give_weight'] = $dish_mess['give_weight'];  //赠送重量
                $actually_total_fee = $total_fee;   //目前未开启优惠卷折扣
                $data_order['actually_total_fee'] = $actually_total_fee;   //订单实付
                $data_order['queue_number'] = date("His",time()).mt_rand(10,99);   //订单实付
                $data_order['order_time'] = time();    //订单时间
                $data_order['system_order_id'] = date("YmdHis").rand(100000,999999).time();  //系统生成的订单id
                $data_order['take_away'] = $take_away;
                $data_order['come_from'] = MODULE_NAME; //订单来源

                $re_order_insert = M("Dish_order")
                            ->data($data_order)
                            ->add();
                if($re_order_insert){
                    $data_order_dish['order_id']=$re_order_insert;
                    $re_order_info_insert = M("dish_order_info")->add($data_order_dish);
                    if($re_order_info_insert){
                        $this->assign('store_id',$store_id);

                        ////////调用支付
                        $this->redirect('Dish/Index/wait',array('system_order_id'=>$data_order['system_order_id'],'store_id'=>$store_id));
                    }
                }else{
                    header("Content-type:text/html;charset=utf-8");
                    exit('订单写入失败');
                }

        }
    }
    //提交订单等待页面
    public function wait(){
        $store_id=I('get.store_id');
        $system_order_id=I('get.system_order_id');
        $this->assign('store_id',$store_id);
        $this->assign('system_order_id',$system_order_id);
        $this->display('wait_paid');
    }


    //支付调用页面
    public function pay(){
        header("Content-type:text/html;charset=utf-8");
        /*
         * 用户直接扫二维码进入中这个页面，查询出对应的订单信息，去支付
         * 按照store_id查询，查询出最近的一单未支付的；
         * */
        $store_id=I("get.store_id");
        $store_id= $store_id ? intval($store_id) : "";
        $time=time()-1200;//查找的数据在一小时内下单的
        if($store_id){
            $swhere="is_dish=0 AND is_del=0 AND paid=0 AND store_id={$store_id} AND order_time>{$time}";
            $order_data=D("dish_order")->where($swhere)->order("id desc")->limit(0,1)->find();
            if(!$order_data){
                exit('错误!请重新下单');
            }
        }else{
            exit('错误!请重新扫码支付');
        }

        $system_order_id =$order_data['system_order_id'];
        $order = $order_data;

        // 如果已经支付过的订单直接到订单详情页面. 不再进入支付页面
        if($order['paid'] == 1){
            $order_detail_url = U("Dish/Index/myOrderList",array('system_order_id'=>$order['system_order_id']));
            header("Location: $order_detail_url");
        }

        $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and  scene in(0,1)")->select();
        //微信浏览器
        if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
            $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and code in('weixin')")->select();
        }
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
        $payment = M('Plugin')->where("`type`='payment' and status = 1")->select();
        $this->assign('paymentList',$paymentList);
        $this->assign('bank_img',$bank_img);
        //var_export($paymentList);exit;

        $this->assign("order",$order);
        $this->assign('system_order_id',$system_order_id);
//        $this->redirect('Mobile/Payment/getCode',array('system_order_id'=>$system_order_id,'pay_radio'=>"pay_code=weixin"));
        $this->display();
    }

    //由经纬度拿城市代码
    public function getCityCodeFromLngLat(){
//        header("Access-Control-Allow-Origin: *");
        $lng = I("get.lng");
        $lat = I("get.lat");
        $location_arr = getCityCodeFromLngLat($lng,$lat);
        //var_export($location_arr);exit;
        if($location_arr['status']){
            $city_name = $location_arr['regeocode']['addressComponent']['city'];
            if($city_name){
                $level = 2;
                $field = 'city';
                $city_name = $location_arr['regeocode']['addressComponent']['city'];
            }else{
                $level = 1;
                $field = 'province';
                $city_name = $location_arr['regeocode']['addressComponent']['province'];
            }
            $city_code = M("region")->where(array('name'=>array("like",$city_name),"level"=>$level))->getField("id");
            //var_export($city_code);exit;
            $this->ajaxReturn(array('status'=>$location_arr['status'],'city_code'=>$city_code,'field'=>$field,'msg'=>'获取数据成功'),"json");
        }else{
            $this->ajaxReturn(array('status'=>$location_arr['status'],'city_code'=>'','msg'=>'地图接口失败'),"json");
        }


    }



    public function gpsBusSubway(){

        $this->assign('lng1',$_GET['lng1']);
        $this->assign('lat1',$_GET['lat1']);
        $this->assign('lng2',$_GET['lng2']);
        $this->assign('lat2',$_GET['lat2']);
        $this->display("Public:gps_bus_subway");
    }

    /*
     * ajax登录页面
     * 还得判断该账户能登录的店铺有哪些，没有权限的店铺登录不进去
     *
     * */

    public function cake_login(){
//        $store_id = I("get.store_id");
        if(IS_POST){
//            $store_id = I("post.store_id");

            $user_name=I('post.user_name');
            $password=I('post.password');
            $password=encrypt(trim($password));
            $where=['user_name'=>$user_name,'password'=>$password];
              $ret=D("admin")->where($where)->find();

            if($ret){
                $store_ids=D("store")->where('is_del=0')->getField('id');
                $cid_arr=explode(',',$ret['cid']);
                $store_id = $ret['cid']==0 ? $store_ids[0] : $cid_arr[0];
                //超级管理员是
                if($cid_arr[0] || $ret['cid']==0){
                    session('store_id',$store_id);
                    session('user_name',$user_name);
                    session('is_boss',$ret['is_boss']);
                    $this->ajaxReturn(array('code'=>1,'store_id'=>$store_id));
//                    $this->redirect("Dish/Index/dishList_new",array('store_id'=>$store_id));
                }else{
                    $this->ajaxReturn(['code'=>0,'error'=>"错误"]);
                }
            }else{
                $this->ajaxReturn(['code'=>0,'error'=>"账号或密码错误"]);
               exit;
            }
            exit;
        }
        $this->display("login");
    }

    //点选蛋糕页面
    public function dishList_new(){
        if(!session("user_name")){
            header("Content-type:text/html;charset=utf-8");
            $this->redirect("Dish/Index/index",'',2,"请登录再操作");
            die;
        }
        $store_id = I("get.store_id");
       
        $store_name=D("store")->where(['id'=>$store_id])->getField('name');
       
        $dish_mess=D("dish")->alias('a')
            ->join("tp_dish_to_store_restaurant b ON a.id=b.dish_id",'left')
            ->where("b.store_id={$store_id} AND a.is_del=0")
            ->field("a.dish_name,b.*")->select();
        $this->assign("dish_mess",$dish_mess);
        $this->assign("store_name",$store_name);
        $this->assign("user_name",session('user_name'));
        $this->assign("is_boss",session('is_boss'));
        $this->assign("store_id",$store_id);
        $this->display('cake_handle');
    }

   //wait_paid 页面传输过来的    ajax
    public function ajax_get_paid(){
        $system_order_id=I('get.system_order_id');
        $where=['system_order_id'=>$system_order_id,'is_del'=>0];
       $ret=D("dish_order")->where($where)->getField("paid");
        if($ret){
            echo $ret;
        }
      
     }

    /***
     * ajax删除订单
       从wait_paid 传过来的
     **/
    public function del_thisOrder(){
        $store_id=I("get.store_id");
        $system_order_id=I('get.system_order_id');
        $where=['is_dish'=>0,'store_id'=>$store_id,'system_order_id'=>$system_order_id,'is_del'=>0];
        $paid=D("dish_order")->where($where)->getField('paid');
        if($paid){
            echo 0;
        }else{
            $ret=D("dish_order")->where($where)->setField("is_del",1);
            if($ret){
                echo 1;
            }
        }


    }
    //ajax获取商品的信息
    public function ajax_get_mess(){
        $cake_id=I('cake_id');
        $store_id=I('get.store_id');
        if($cake_id){
            $this_cake=D("dish")->alias('a')
                ->join("tp_dish_to_store_restaurant b ON a.id=b.dish_id",'left')
                ->where("b.store_id=".$store_id." AND b.id=".$cake_id)
                ->find();
//            $model=D('Cake');
//            $this_cake=$model->where(['is_delete'=>0,'id'=>$cake_id])->find();
            if($this_cake)
                exit(json_encode($this_cake));
        }

    }
    //根据顾客的钱数算出总的重量
    public function ajax_weight(){
        $cake_id=I('post.cake_id');
        $price=I('post.price');
        $store_id=I("get.store_id");
        $price=$price*100;
        if($cake_id && $price){
            $where=["store_id"=>$store_id,'id'=>$cake_id];
            $this_cake=D("dish_to_store_restaurant")
                ->where($where)
                ->find();
            if($this_cake){
                //顾客最终购买的价格
                $sale_price=0;//最终购买的价格
                if($price<$this_cake['cake_low_price'] || $this_cake['cake_low_price']==0){//小于时候为原价
                    $sale_price=$this_cake['price'];
                }else{//大于时候为优惠价
                    $sale_price=$this_cake['cake_low_price'];
                }
                //下单时候本金所购买的重量
                $weight=round($price/$sale_price,3)*500;//转化为g
                //赠送的重量和钱数
                $give_price=0;//赠送的价格
                $give_weight=0;//赠送的重量
                if($price>=$this_cake['cake_full_price'] && $this_cake['cake_full_price']>0){
                    $give_price=floor($price/$this_cake['cake_full_price'])*$this_cake['cake_give_price'];
                    $give_weight=round($give_price/$this_cake['price'],3)*500;//转化为g
                }
                $total_weight=$give_weight+$weight;
                $array=[
                    'weight'=>$weight,
                    'give_price'=>($give_price/100),
                    'give_weight'=>$give_weight,
                    'total_weight'=>$total_weight
                ];
                exit(json_encode($array));
            }

        }

    }

    //新菜品列表style_one
    public function dishListStyleAjaxNew_one(){
        $store_id = I("get.store_id");
        $where = array("store_id"=>$store_id,"status"=>1);
        //拿取当前店铺下面所有正常状态下菜品的分类id
        $dish_list = M("dish_to_store_restaurant")->where($where)->order("is_hot DESC")->select();
        //剥离出dish_id用来拿取分类信息
        $dish_id_arr = array();
        foreach($dish_list as $k => $v){
            $dish_id_arr[]=$v['dish_id'];
        }
        $sort_id_arr = M("dish")->where(array('id'=>array("in",implode(',',$dish_id_arr))))->field("sort_id,id")->select();
        $dish = array();
        $sort = array();
        foreach($dish_list as $k1=>$v1){
            foreach($sort_id_arr as $k2=>$v2){
                if($v1['dish_id']==$v2['id']){
                    $dish[$v2['sort_id']][]=$v1;
                    $sort[]=$v2['sort_id'];
                }
            }
            //推荐的菜品
            if($v1['is_up']){
                $dish[65535][] = $v1;
            }
        }
        $dish_assign = array();
        $m = 0;
        foreach($dish as $kd => $vd){
            $a=0;
            for($i=0;$i<count($vd);$i++){
                if($i<($a+1)*6){
                    $dish_assign[$kd][$a][]=$vd[$i];
                }else{
                    $dish_assign[$kd][$a+1][]=$vd[$i];
                    $a++;
                }
            }
            $m++;
        }
        //var_export(array_unique(array_values($sort)));exit;
        //var_export($dish_assign);exit;
        //var_export($dish);exit;
        $this->assign('list',$dish_assign);
        $this->assign('sort_list',array_unique(array_values($sort)));
        $this->display();
    }
    //新菜品列表style_two
    public function dishListStyleAjaxNew_two(){
        $store_id = I("get.store_id");
        $this->display();
    }

    //个人中心
    public function my(){
        $this->display();
    }
    //蛋糕的管理中心
    public function cake_my(){
        $is_boss=$_SESSION['is_boss'];
        $this->assign('is_boss',$is_boss);
        $this->display();
    }
    /*
     * 蛋糕店销量统计
     * */
    public function cake_sales(){
        $this->display();
    }
    /*
     * 蛋糕店的订单管理
     * */
    public function cake_order_manage(){
        $this->display();
    }


    //点餐订单类型选择列表
    public function myOrderListSelect(){
        $take_away = I("get.take_away",1);
        $this->assign('take_away',$take_away);
        $this->display();
    }
    //订单列表
    public function myOrderList(){

        $take_away = I("get.take_away",1);
        $model_order = M("dish_order");
        $model_order_info = M("dish_order_info");
        $order_step_type = I("get.order_type",'waiting_take');
        switch($take_away){
            case 2:
                $title = '外卖';
                break;
            case 3:
                $title = '自提';
                break;
            default :
                $title = '堂食';
                break;
        }
        $where = array("openid"=>session("openid"),'take_away'=>$take_away,'is_del'=>0);
        $orderList = $model_order->where($where)->order("order_time desc")->limit(50)->select();
        //echo D()->getLastSql();
        //待支付的记录数，一天之内的
        $where1 = array('paid'=>0,'order_time'=>array('gt',time()-86400));
        $count_waiting_pay =$model_order->where($where+$where1)->count();
        //待取餐记录数,一天之内的
        $where2 = array('paid'=>1,'order_time'=>array('gt',time()-86400),'order_state'=>array('in','1,2'),'_logic'=>'AND');
        $dish_waiting_take = $model_order->where($where+$where2)->count();
        //退款记录数
        $where3 = array('paid'=>1,'refund_state'=>array('neq',0));
        $refund_count = $model_order->where($where+$where3)->count();
        //已完成的记录数
        $where4 = array('paid'=>1,'order_state'=>3,'refund_type'=>0,'refund_state'=>0);
        $dish_done_count = $model_order->where($where+$where4)->count();
        //echo D()->getLastSql();
        //var_export($_SESSION);
        //echo $count_waiting_pay;
        $this->assign("o_s_t",getDishOrderStepType($order_step_type));
        $this->assign('refund_count',$refund_count);
        $this->assign('dish_done_count',$dish_done_count);
        $this->assign("list",$orderList);
        $this->assign("cwp",$count_waiting_pay);
        $this->assign("dwt",$dish_waiting_take);
        $this->assign("title",$title);
        $this->display();
    }
    //支付成功之后回调函数
    public function payCallBack(){

        $order_model= D("dish_order");
        $take_away = I("get.take_away",1);
        $go = I("get.go");
        $order_step_type = I("get.order_type",'dish_done');   //订单流程类型 如 待支付，待取餐 等..
        $system_order_id = I("get.system_order_id");
        $name=$_SESSION['user']['nickname'];
        if($go == 'success'){
            /*
            支付之后看是否后台人员已经删除本订单，如果删除，直接自动退款
             * */
            $is_dels=$order_model->where(['system_order_id'=>$system_order_id])->getField('is_del');
            if($is_dels){
                $this->auto_refund($system_order_id);
                exit();
            }
            //进行付款成功的标记操作
         
            $save_data=['paid'=>1,'openid'=>$_SESSION['user']['openid'],'name'=>"$name"];

            $order_model->where(['system_order_id'=>$system_order_id])->save($save_data);
            $order_detail_url = U("Dish/Index/myOrderList",array('system_order_id'=>$system_order_id,'take_away'=>$take_away,'order_type'=>3));
            header("Location: $order_detail_url");
        }else if($go == 'cancel'){
            $save_data=['is_del'=>1,'openid'=>$_SESSION['user']['openid'],'name '=>"$name"];
            $order_model->where(['system_order_id'=>$system_order_id])->setField($save_data);
            $order_detail_url = U("Dish/Index/myOrderList",array('system_order_id'=>$system_order_id,'take_away'>$take_away,'order_type'=>getDishOrderStepType($order_step_type)));
            header("Location: $order_detail_url");
        }else if($go == 'back'){

        }
    }
    /**
    自动退款。如果用户支付输入密码支付完时候被店员取消订单了，就直接自动退款，
     **/
    public function auto_refund($system_order_id){

        $order_info=D("dish_order")->where(['system_order_id'=>$system_order_id])->find();
        $out_trade_no = $order_info['system_order_id']; //商户订单号
        $out_refund_no = $this->createReFundKey();    //商户退款单号.
        $total_fee = $order_info['order_total_fee']; ;   //订单金额
        $refund_fee = $order_info['order_total_fee']; ;   //退款金额
        $refund_reason = "管理员已经删除,所有自动退款";    //退款原因
        $wx_plugin=D("plugin")->where(['code'=>'weixin','`type`'=>'payment','status'=>1])->find();
        $mch_info=unserialize($wx_plugin['config_value']);
        //var_export($wx_pay_config);exit;
        $refund_wx_url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $mch_id = $mch_info['mchid'];    //商户号
        $appid = $mch_info['appid']; //appid
        $op_user_id = $mch_info['mchid'];    //操作员 默认为商户号
        $nonce_str = md5(time());

        //生成签名
        $stringA = "appid=".$appid."&mch_id=".$mch_id."&nonce_str=".$nonce_str."&op_user_id=".$op_user_id."&out_refund_no=".$out_refund_no."&out_trade_no=".$out_trade_no."&refund_fee=".$refund_fee."&total_fee=".$total_fee;
        $stringSignTemp = $stringA."&key=".$mch_info['key'];
        $sign = strtoupper(md5($stringSignTemp));
        $refund_array = array(
            'appid'=>$appid,
            'mch_id'=>$mch_id,
            'nonce_str'=>$nonce_str,
            'op_user_id'=>$op_user_id,
            'out_refund_no'=>$out_refund_no,
            'out_trade_no'=>$out_trade_no,
            'refund_fee'=>$refund_fee,
            'sign'=>$sign,
            'total_fee'=>$refund_fee
        );

        //array转换xml
        $xml='<xml>';
        foreach($refund_array as $k=>$v){
            $xml.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $xml = $xml.'</xml>';

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$refund_wx_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);//证书检查
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
        curl_setopt($ch,CURLOPT_SSLCERT,'/var/www/dangao/wwwroot/plugins/payment/weixin/cert/apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
        curl_setopt($ch,CURLOPT_SSLKEY,'/var/www/dangao/wwwroot/plugins/payment/weixin/cert/apiclient_key.pem');
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'pem');
        curl_setopt($ch,CURLOPT_CAINFO,'/var/www/dangao/wwwroot/plugins/payment/weixin/cert/rootca.pem');
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);

        $data=curl_exec($ch);
        if($data){ //返回来的是xml格式需要转换成数组再提取值，用来做更新
            curl_close($ch);
            $xmlstring = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            $val = json_decode(json_encode($xmlstring),true);
            //处理本系内逻辑
            if($val['return_code'] == 'SUCCESS'){
                echo $val['return_code'];//先返回信息给前端，再处理逻辑
                //在对应的菜品订单下面做以下退款的标记
                $edit_data=['is_refund'=>1 ,'refund_fee'=>$refund_fee,'refund_reason'=>$refund_reason,'refund_time'=>time()];
//                    $this_order=D("dish_order")->where(['id'=>$order_id])->find();
                D("dish_order_info")->where(['order_id'=>$order_info['id']])->save($edit_data);
                $_data=['refund_type'=>2 ,'refund_fee'=>$refund_fee,'refund_reason'=>$refund_reason,'refund_time'=>time()];
                D("dish_order")->where(['id'=>$order_info['id']])->save($_data);
                $order_detail_url = U("Dish/Index/myOrderList",array('system_order_id'=>$system_order_id,'take_away'=>1));
                header("Location: $order_detail_url");
            }
        }else{
            $error=curl_errno($ch);
            echo "curl出错，错误代码：$error"."<br/>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurs.html'>;错误原因查询</a><br/>";
            curl_close($ch);
            //echo false;
        }

    }
    /**生成退款单号*/
    public function createReFundKey(){

        return date('YmdHis',time()).time();

    }
}