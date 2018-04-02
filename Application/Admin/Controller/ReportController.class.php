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
 * Date: 2015-12-21
 */

namespace Admin\Controller;
use Admin\Logic\GoodsLogic;

class ReportController extends BaseController{
	public $begin;
	public $end;
	public function _initialize(){
        parent::_initialize();
		$timegap = I('timegap');
		if($timegap){
			$gap = explode(' - ', $timegap);
			$begin = $gap[0];
			$end = $gap[1];
		}else{
			$lastweek = date('Y-m-d',strtotime("-1 month"));//30天前
			$begin = I('begin',$lastweek);
			$end =  I('end',date('Y-m-d'));
		}
		$this->begin = strtotime($begin);
		$this->end = strtotime($end)+86399;
		$this->assign('timegap',date('Y-m-d',$this->begin).' - '.date('Y-m-d',$this->end));
	}
	
	public function index(){

		$starttime=I('start_time',0);
		$endtime=I('end_time',0);
		$start_time=$starttime > 0 ? strtotime($starttime) : '';
		$end_time=$endtime > 0 ? strtotime($endtime) : '';
		if($start_time && $end_time){
			$where['add_time']=['between',"$start_time,$end_time"];
		}

		$service_name=get_service_name();//获取表明对应的服务名称

		$where['is_pay']=1;
		$data=D("order_info")
				->where($where)->group("table_name")->getField("table_name,count(*) total_num ,sum(pay_money) total_fee");

		$all_data=[];
		foreach($service_name as $k=>$v){
			  $vo=$data[$k];
			if($vo){
				$vo['service_name']=$v;
				$all_data[$k]=$vo;
			}else{
				$all_data[$k]=['table_name'=>$k,'total_num'=>0,'total_fee'=>0.00,'service_name'=>$v];
			}

		}

		$service_n=[];
		$o_num=[];
		$o_fee=[];
		foreach($all_data as $ak=>$av){
			$service_n[]=$av['service_name'];
			$o_num[]=$av["total_num"];
			$o_fee[]=$av["total_fee"];
		}

//		dump($all_data);
//		dump(json_encode($service_n));
//		dump($o_num);
//		dump(json_encode($o_num));
//		dump(json_encode($o_fee));
//		$o_num=['2.6', '5.9', '9.0', '26.4', '28.7', '70.7', '175.6', '182.2', '0', 0,0,0];
//		$o_fee=[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 0, 0, 0, 0, 0];

		$this->assign('o_fee',json_encode($o_fee));
		$this->assign('service_n',json_encode($service_n));
		$this->assign('o_num',json_encode($o_num));


		$this->assign('start_time',date('Y-m-d',$start_time));
		$this->assign('end_time',date("Y-m-d",$end_time));
		$this->display();
	}

	public function saleTop(){
		$sql = "select goods_name,goods_sn,sum(goods_num) as sale_num,sum(goods_num*goods_price) as sale_amount from __PREFIX__order_goods ";
		$sql .=" where is_send = 1 group by goods_id order by sale_amount DESC limit 100";
		$res = M()->cache(true,3600)->query($sql);
		$this->assign('list',$res);
		$this->display();
	}
	
	public function userTop(){
		$p = I('p',1);
		$start = ($p-1)*20;
		$mobile = I('mobile');
		$email = I('email');
		if($mobile){
			$where =  "and b.mobile='$mobile'";
		}		
		if($email){
			$where = "and b.email='$email'";
		}
		$sql = "select count(a.order_id) as order_num,sum(a.order_amount) as amount,a.user_id,b.mobile,b.email from __PREFIX__order as a left join __PREFIX__users as b ";
		$sql .= " on a.user_id = b.user_id where a.add_time>$this->begin and a.add_time<$this->end and a.pay_status=1 $where group by user_id order by amount DESC limit $start,20";
		$res = M()->cache(true)->query($sql);
		$this->assign('list',$res);
		if(empty($where)){
			$count = M('order')->where("add_time>$this->begin and add_time<$this->end and pay_status=1")->group('user_id')->count();
			$Page = new \Think\Page($count,20);
			$show = $Page->show();
			$this->assign('page',$show);
		}
		$this->display();
	}
	
	public function saleList(){
		$p = I('p',1);
		$start = ($p-1)*20;
		$cat_id = I('cat_id',0);
		$brand_id = I('brand_id',0);
		$where = "where b.add_time>$this->begin and b.add_time<$this->end ";
		if($cat_id>0){
			$where .= " and g.cat_id=$cat_id";
			$this->assign('cat_id',$cat_id);
		}
		if($brand_id>0){
			$where .= " and g.brand_id=$brand_id";
			$this->assign('brand_id',$brand_id);
		}
		$sql = "select a.*,b.order_sn,b.shipping_name,b.pay_name,b.add_time from __PREFIX__order_goods as a left join __PREFIX__order as b on a.order_id=b.order_id ";
		$sql .= " left join __PREFIX__goods as g on a.goods_id = g.goods_id $where ";
		$sql .= "  order by add_time desc limit $start,20";
		$res = M()->query($sql);
		$this->assign('list',$res);
		
		$sql2 = "select count(*) as tnum from __PREFIX__order_goods as a left join __PREFIX__order as b on a.order_id=b.order_id ";
		$sql2 .= " left join __PREFIX__goods as g on a.goods_id = g.goods_id $where";
		$total = M()->query($sql2);
		$count =  $total[0]['tnum'];
		$Page = new \Think\Page($count,20);
		$show = $Page->show();
		$this->assign('page',$show);
		
        $GoodsLogic = new GoodsLogic();        
        $brandList = $GoodsLogic->getSortBrands();
        $categoryList = $GoodsLogic->getSortCategory();
        $this->assign('categoryList',$categoryList);
        $this->assign('brandList',$brandList);
		$this->display();
	}
	
	public function user(){
		$today = strtotime(date('Y-m-d'));
		$month = strtotime(date('Y-m-01'));
		$user['today'] = D('users')->where("reg_time>$today")->count();//今日新增会员
		$user['month'] = D('users')->where("reg_time>$month")->count();//本月新增会员
		$user['total'] = D('users')->count();//会员总数
		$user['user_money'] = D('users')->sum('user_money');//会员余额总额
		$res = M('order')->cache(true)->distinct(true)->field('user_id')->select();
		$user['hasorder'] = count($res);
		$this->assign('user',$user);
		$sql = "SELECT COUNT(*) as num,FROM_UNIXTIME(reg_time,'%Y-%m-%d') as gap from __PREFIX__users where reg_time>$this->begin and reg_time<$this->end group by gap";
		$new = M()->query($sql);//新增会员趋势		
		foreach ($new as $val){
			$arr[$val['gap']] = $val['num'];
		}
		
		for($i=$this->begin;$i<=$this->end;$i=$i+24*3600){
			$brr[] = empty($arr[date('Y-m-d',$i)]) ? 0 : $arr[date('Y-m-d',$i)];
			$day[] = date('Y-m-d',$i);
		}		
		$result = array('data'=>$brr,'time'=>$day);
		$this->assign('result',json_encode($result));					
		$this->display();
	}
	
	//财务统计
	public function finance(){

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


			if($start_time && $end_time){
				$where['a.add_time']=['between',"$start_time,$end_time"];
			}
			if($account_name){
				$where['u.account_name']=['like',"%$account_name%"];
			}
//        $where=['store_id'=>$cid[0],'is_del'=>0,'order_time'=>['between',[$starttime,$endtime]]];
//        dump($where);
			$model=D("order_info");

			$count      = $model->alias('a')
					->join("tp_users as u ON u.user_id=a.user_id",'inner')                            ->where($where)->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)

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
					->field("a.*,u.account_name,u.username uname")
					->join("tp_users as u ON u.user_id=a.user_id",'inner')
					->where($where)
					->order('a.add_time desc')
					->limit($Page->firstRow.','.$Page->listRows)->select();
			$no=$Page->firstRow;
		foreach($order_mess as $k=>$v){
			$order_mess[$k]['no']=$no;
			$no++;
		}
			$this->assign('order_mess',$order_mess);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出

			$this->assign('is_pay',$is_pay);
			$this->assign('account_name',$account_name);
			$this->assign('start_time',date('Y-m-d',$start_time));
			$this->assign('end_time',date("Y-m-d",$end_time));

			$this->display(); // 输出模板

		}

//	public function finance(){
//		$sql = "SELECT sum(b.goods_num*b.member_goods_price) as goods_amount,sum(a.shipping_price) as shipping_amount,sum(b.goods_num*b.cost_price) as cost_price,";
//		$sql .= "sum(a.coupon_price) as coupon_amount,FROM_UNIXTIME(a.add_time,'%Y-%m-%d') as gap from  __PREFIX__order a left join __PREFIX__order_goods b on a.order_id=b.order_id ";
//		$sql .= " where a.add_time>$this->begin and a.add_time<$this->end AND a.pay_status=1 and a.shipping_status=1 and b.is_send=1 group by gap order by a.add_time";
//		$res = M()->cache(true)->query($sql);//物流费,交易额,成本价
//
//		foreach ($res as $val){
//			$arr[$val['gap']] = $val['goods_amount'];
//			$brr[$val['gap']] = $val['cost_price'];
//			$crr[$val['gap']] = $val['shipping_amount'];
//			$drr[$val['gap']] = $val['coupon_amount'];
//		}
//
//		for($i=$this->begin;$i<=$this->end;$i=$i+24*3600){
//			$date = $day[] = date('Y-m-d',$i);
//			$tmp_goods_amount = empty($arr[$date]) ? 0 : $arr[$date];
//			$tmp_cost_amount = empty($brr[$date]) ? 0 : $brr[$date];
//			$tmp_shipping_amount = empty($crr[$date]) ? 0 : $crr[$date];
//			$tmp_coupon_amount = empty($drr[$date]) ? 0 : $drr[$date];
//
//			$goods_arr[] = $tmp_goods_amount;
//			$cost_arr[] = $tmp_cost_amount;
//			$shipping_arr[] = $tmp_shipping_amount;
//			$coupon_arr[] = $tmp_coupon_amount;
//			$list[] = array('day'=>$date,'goods_amount'=>$tmp_goods_amount,'cost_amount'=>$tmp_cost_amount,
//					'shipping_amount'=>$tmp_shipping_amount,'coupon_amount'=>$tmp_coupon_amount,'end'=>date('Y-m-d',$i+24*60*60));
//		}
//		$this->assign('list',$list);
//		$result = array('goods_arr'=>$goods_arr,'cost_arr'=>$cost_arr,'shipping_arr'=>$shipping_arr,'coupon_arr'=>$coupon_arr,'time'=>$day);
//		$this->assign('result',json_encode($result));
//		$this->display();
//	}
	
}