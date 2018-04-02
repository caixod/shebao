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

//
/*
计算 个人  社保五险一金  或者 社保/公积金 服务费用
 *  1、费用数组；$own=[
        'wuxian'=>['month'=>150,'season'=>300,'half_year'=>500,'year'=>800],
        'wuxian_and_gjj'=>['month'=>300,'season'=>500,'half_year'=>1000,'year'=>1500],
    ];
2、开始日期.只传年月  2017-01，0,27-09
3、结束日期
4、办理类型，1为五险一金，2为五险==3为公积金
 * */
function own_service_total_fee($data,$start_m,$end_m,$type){
    $month_diff=_getMonthNum($start_m,$end_m);
     $val=get_mjn($month_diff,1);//$val=['m'=>0,'s'=>0,'h_y'=>0,'y'=>0];
     $wy=$data['wuxian_and_gjj'];//五险一金
     $wx=$data['wuxian'];//五险
    $total=0;
    switch($type){
        case 1://五险一金
           $total=$val['y']*$wy['year']+$val['h_y']*$wy['half_year']+$val['s']*$wy['season']+$val['m']*$wy['month'];
            break;
        case 2://五险或者一金
           $total=$val['y']*$wx['year']+$val['h_y']*$wx['half_year']+$val['s']*$wx['season']+$val['m']*$wx['month'];
            break;
    }
    return $total;
}

/*
计算 企业 社保五险一金  或者 社保/公积金 服务费用
 *  1、费用数组；$company=[
        'guakao'=>['wuxian'=>['ten'=>150,'gt_ten'=>300],'wuxian_and_gjj'=>['ten'=>150,'gt_ten'=>300]],//每月
        'daili'=>['wuxian'=>['ten'=>150,'gt_ten'=>300],'wuxian_and_gjj'=>['ten'=>150,'gt_ten'=>300]]//每年
    ];
2、开始日期
3、结束日期
4、办理类型，1为五险一金，2为五险==
5. 1.挂靠 2.代理
6，办理人数
 * */
function company_service_total_fee($data,$start_m,$end_m,$type,$is_guakao,$people){
    $month_diff=_getMonthNum($start_m,$end_m);
    $year=intval($month_diff/12);

     $guakao=$data['guakao'];//五险一金
     $daili=$data['daili'];//五险
    $total=0;

    switch($is_guakao){
        case 1://挂靠

            if($type==1){//五险一金
                if($people<=10){//小于10人
                    $total=$guakao['wuxian_and_gjj']['ten'] *$month_diff;//元/月
                }else{
                    $total=$guakao['wuxian_and_gjj']['gt_ten']*$people *$month_diff;// 元/人/月
                }
            }else{//五险
                if($people<=10){//小于10人
                    $total=$daili['wuxian']['ten'] *$month_diff;//元/月
                }else{
                    $total=$daili['wuxian']['gt_ten']*$people *$month_diff;// 元/人/月
                }
            }
            break;
        case 2://代理
            if($type==1){//五险一金
                if($people<=10){//小于10人
                    $total=$guakao['wuxian_and_gjj']['ten'] *$year;//元/年
                }else{
                    $total=$guakao['wuxian_and_gjj']['gt_ten']*$people *$year;//元/人/年
                }

            }else{//五险
                if($people<=10){//小于10人
                    $total=$daili['wuxian']['ten'] *$year;//元/年
                }else{
                    $total=$daili['wuxian']['gt_ten']*$people *$year;//元/人/年
                }
            }
            break;
    }
    return $total;
}
/*
 * 按照时间段计算 月 季 半年 年
 * 参数1：总月数
 * 参数2：$y,优先级，1为由大到小递归算法，0为先取整，再按月，
 * 返回值:[m=>int,s=>int,h_y=>int,y=>int];
 * */
function get_mjn($t,$y){
    $val=['m'=>0,'s'=>0,'h_y'=>0,'y'=>0];
    if($y==1){//由大到小递归
        $val['y'] = intval($t/12);
        $val['h_y']= intval(($t-$val['y']*12)/6);
        $val['s'] = intval(($t-$val['y']*12-$val['h_y']*6)/3);
        $val['m']= intval(($t-$val['y']*12-$val['h_y']*6-$val['s'] *3)/1);


    }else{//先取整再按月
        if($t>=12){
            $val['y']=intval($t/12);
            $val['m']=($t-$val['y']*12);
        }elseif ($t>=6){
            $val['h_y']=intval($t/6);
            $val['m']=($t-$val['h_y']*6);
        }elseif($t>=3){
            $val['s']=intval($t/3);
            $val['m']=($t-$val['s']*3);
        }else{
            $val['m']=$t;
        }

    }
    return $val;
}


function _getMonthNum($date1,$date2,$tags='-'){
    $date1 = explode($tags,$date1);
    $date2 = explode($tags,$date2);

//    dump(($date1[1] - $date2[1]));
    return  abs(($date2[0] - $date1[0]) * 12 + ( $date2[1] - $date1[1]));
}

/**
 * tpshop检验登陆
 * @param
 * @return bool
 */

function is_login(){
    if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
        return $_SESSION['admin_id'];
    }else{
        return false;
    }
}
function check_mess_isok(){
    $data=D("users")->where(['user_id'=>$_SESSION['user_id']])->find();
    //信息不完善不能下单
        if($data['username']=='' || $data['nature']==0){
            return 0;
        }
        if($data['sex']==0 || empty($data['image'])){
            return 0;
        }
  return 1;
}
function check_company_isok(){
    $data=D("company")->where(['user_id'=>$_SESSION['user_id']])->find();
//    dump($data);die;
    //信息不完善不能下单
        if($data['company_name']=='' || $data['linkman']==""){
            return 0;
        }
  return 1;
}
//计算这个数在两个数的中间还是大于最大的小于最小的
function get_num($min,$max,$money){
    if($money>=$min && $money<=$max){
        return $money;
    }elseif($money>=$max){
        return $max;
    }else{
        return $min;
    }
}
/*
 * 按照订单详情。计算各个项目所花费的费用
 * **/
function get_every_info($info){
    $mouth_d=_getMonthNum($info['start_time'],$info['end_time']);//差额月
    $mouth_d=$mouth_d==0 ? 0 : $mouth_d;
//    dump($info);
    $data=[];
    //1、险1的费用
        $data['compaany_one']=round((((($info['xian_one_base']*$info['c_xian_one']))/100)*$mouth_d),2);
         $data['oneself_one']=round((((($info['xian_one_base']*$info['xian_one']))/100)*$mouth_d),2);

        //2、险2的费用
        $data['compaany_two']=round((((($info['xian_two_base']*$info['c_xian_two']))/100)*$mouth_d),2);
         $data['oneself_two']=round((((($info['xian_two_base']*$info['xian_two']))/100)*$mouth_d),2);

        //3、险3的费用
        $data['compaany_three']=round((((($info['xian_three_base']*$info['c_xian_three']))/100)*$mouth_d),2);
         $data['oneself_three']=round((((($info['xian_three_base']*$info['xian_three']))/100)*$mouth_d),2);
        //4、险4的费用
        $data['compaany_four']=round((((($info['xian_four_base']*$info['c_xian_four']))/100)*$mouth_d),2);
         $data['oneself_four']=round((((($info['xian_four_base']*$info['xian_four']))/100)*$mouth_d),2);
    //5、险5的费用
        $data['compaany_five']=round((((($info['xian_five_base']*$info['c_xian_five']))/100)*$mouth_d),2);
         $data['oneself_five']=round((((($info['xian_five_base']*$info['xian_five']))/100)*$mouth_d),2);
    //6、公积金费用
        $data['gjj_compaany']=0;
        $data['gjj_oneself']=0;
        if($info['is_gjj']==1){
            $data['gjj_compaany'] =round((((($info['c_gjj_base']*$info['c_gjj_bilie']))/100)*$mouth_d),2);
            $data['gjj_oneself']=round((((($info['c_gjj_base']*$info['gjj_bilie']))/100)*$mouth_d),2);
        }

    //7、公司、个人总缴纳社保：
    $data['compaany_total']=($data['compaany_one']+ $data['compaany_two']+$data['compaany_three']+$data['compaany_four']+$data['compaany_five']+$data['gjj_compaany']);

    $data['oneself_total']=($data['oneself_one']+ $data['oneself_two']+$data['oneself_three']+$data['oneself_four']+$data['oneself_five']+$data['gjj_oneself']);

    $data['zhina']=($info['gjj_zhina_fee']+$info['sb_zhina_fee']);

  return $data;

}

//计算两个日期相差几个月
function getMonthNum($date1,$date2,$tags='-'){
    $date1 = explode($tags,$date1);
    $date2 = explode($tags,$date2);
    $d=($date2[2] - $date1[2])>0 ? 1 : 0;
//    dump(($date1[1] - $date2[1]));
    return abs(($date2[0] - $date1[0]) * 12 + ( $date2[1] - $date1[1]))+$d;
}
/*
 * 获取该地区的各个费用
 *      data:{'id':city,'money':money,'bj_time':bj_time},
 * 实际缴纳=基数*（比例1+2+3+4+5）+*月数+danwei*yueshu+服务费
 * 笨方法只给社保的订单详情使用，其他的服务用  other_service_order

 *  $_SESSION['order_data']=['order_id'=>$id,'table_name'=>'gjj_bujiao'];
 */
 function shebao_daijiao_getBase($id){
    $data=D("{$_SESSION['order_data']['table_name']}")->where(['id'=>$id])->find();

//        dump($_SESSION['order_data']['table_name']);die;
    $city_id=$data['to_city'];//地区id
    $sb_base=$data['sb_base'];//补缴基数
    $gjj_base=$data['gjj_base'];//公积金补缴基数
    $end_time=$data['end_time'];//补缴时间
    $start_time=$data['start_time'];//补缴时间
    $is_gjj=$data['is_gjj'];//是否缴纳公积金
    $d=strtotime($end_time)-strtotime($start_time);
    $day_d=$d/(3600*24);//差额天数
    $mouth_d=getMonthNum($data['start_time'],$data['end_time']);//差额月
     $mouth_d=$mouth_d==0 ? 1 : $mouth_d;
//        dump($c_d);
//        dump($m_d);
//        dump($end_time);die;
    if($city_id){
        $city=D("region")->where(['id'=>$city_id])->find();
        if($city){

            //服务费 是对应这个服务的表名的
            $service_fee=$city["{$_SESSION['order_data']['table_name']}"];
            //险
            $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
            $xian_one=((($xian_one_base*$city['xian_one'])+($xian_one_base*$city['c_xian_one']))/100)*$mouth_d;//险一缴纳的金额

            $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
            $xian_two=((($xian_two_base*$city['xian_two'])+($xian_two_base*$city['c_xian_two']))/100)*$mouth_d;//险2缴纳的金额

            $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
            $xian_three=((($xian_three_base*$city['xian_three'])+($xian_three_base*$city['c_xian_three']))/100)*$mouth_d;//险3缴纳的金额

             $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
            $xian_four=((($xian_four_base*$city['xian_four'])+($xian_four_base*$city['c_xian_four']))/100)*$mouth_d;//险3缴纳的金额

            $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);
            $xian_five=((($xian_five_base*$city['xian_five'])+($xian_five_base*$city['c_xian_five']))/100)*$mouth_d;//险3缴纳的金额


            $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);//实际缴纳的社保费=单位+个人
            $gjj_js_base=0;
            $gjj_fee=0;
            $gjj_zhina_fee=0;
            if($is_gjj==1){//如果有公积金，将公积金也算进去
                $gjj_js_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                $fee=(($gjj_js_base*($city['gjj_bilie']))/100)*$mouth_d;//缴的公积金钱数
                $company_fee=(($gjj_js_base*($city['c_gjj_bilie']))/100)*$mouth_d;//单位补缴的公积金钱数
                $gjj_fee=round(($company_fee+$fee),2);
                $gjj_zhina_fee=(($day_d*$gjj_fee*$city['stop_money'])/10000);
                $gjj_zhina_fee=round($gjj_zhina_fee,2);
                $gjj_zhina_fee=$_SESSION['order_data']['table_name']=='sb_bujiao'? $gjj_zhina_fee: 0;
            }

            //滞纳金=天数*滞纳率
//            dump( $_SESSION['order_data']['table_name']);
            $sb_zhina_fee=(($day_d*$sb_fee*$city['stop_money'])/10000);
            $sb_zhina_fee=round($sb_zhina_fee,2);
            $sb_zhina_fee=$_SESSION['order_data']['table_name']=='sb_bujiao'? $sb_zhina_fee: 0;
//            dump($city['stop_money']);
            $total_fee=$gjj_zhina_fee+$sb_zhina_fee+$service_fee+$sb_fee+$gjj_fee;//总共缴纳的=社保费+服务费+滞纳金
            $data=[
                'sb_fee'=>$sb_fee,
                'gjj_fee'=>$gjj_fee,
                'money'=>$total_fee,
                'sb_zhina_fee'=>$sb_zhina_fee,
                'gjj_zhina_fee'=>$gjj_zhina_fee,
                'service_fee'=>$service_fee,
                'xian_one_base'=>$xian_one_base,
                'c_xian_one'=>$city['c_xian_one'],
                'xian_one'=>$city['xian_one'],
                'xian_two_base'=>$xian_two_base,
                'xian_two'=>$city['xian_two'],
                'c_xian_two'=>$city['c_xian_two'],
                'xian_three_base'=>$xian_three_base,
                'xian_three'=>$city['xian_three'],
                'c_xian_three'=>$city['c_xian_three'],                                       'xian_four_base'=>$xian_four_base,
                'xian_four'=>$city['xian_four'],
                'c_xian_four'=>$city['c_xian_four'],                                       'xian_five_base'=>$xian_five_base,
                'xian_five'=>$city['xian_five'],
                'c_xian_five'=>$city['c_xian_four'],
                'c_gjj_bilie'=>$city['c_gjj_bilie'],
                'gjj_bilie'=>$city['gjj_bilie'],
                'c_gjj_base'=>$gjj_js_base,

            ];
            $ret=D("{$_SESSION['order_data']['table_name']}")->where(['id'=>$id])->save($data);
            if($ret){
                $_SESSION['order_data']['total_fee']=$total_fee;
                $_SESSION['order_data']['end_fee']=$total_fee;//用于后面是否有代金券，如果有代金券，则变为使用券之后的价格
                return true;
            }else{
                return false;
            }

        }

    }else{
        return false;
    }

}
/*
 * 企业订单获取费用
 * */
 function company_order_shebao($id){
     $data=D("sb_company_order")->where(['id'=>$id])->find();

    $city_id=$data['to_city'];//地区id
    $sb_base=$data['sb_base'];//补缴基数
    $gjj_base=$data['gjj_base'];//公积金补缴基数
    $end_time=$data['end_time'];//补缴时间
    $start_time=$data['start_time'];//补缴时间
    $is_gjj=$data['is_gjj'];//是否缴纳公积金
    $d=strtotime($end_time)-strtotime($start_time);
    $day_d=$d/(3600*24);//差额天数
    $mouth_d=getMonthNum($start_time,$end_time);//差额月
     $mouth_d=$mouth_d==0 ? 1 : $mouth_d;
    if($city_id){
        $city=D("region")->where(['id'=>$city_id])->find();
        if($city){

            //服务费 是对应这个服务的表名的
            $service_fee=$city["{$_SESSION['order_data']['table_name']}"];
            //险
            $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
            $xian_one=((($xian_one_base*$city['xian_one'])+($xian_one_base*$city['c_xian_one']))/100)*$mouth_d;//险一缴纳的金额

            $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
            $xian_two=((($xian_two_base*$city['xian_two'])+($xian_two_base*$city['c_xian_two']))/100)*$mouth_d;//险2缴纳的金额

            $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
            $xian_three=((($xian_three_base*$city['xian_three'])+($xian_three_base*$city['c_xian_three']))/100)*$mouth_d;//险3缴纳的金额

             $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
            $xian_four=((($xian_four_base*$city['xian_four'])+($xian_four_base*$city['c_xian_four']))/100)*$mouth_d;//险3缴纳的金额

            $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);
            $xian_five=((($xian_five_base*$city['xian_five'])+($xian_five_base*$city['c_xian_five']))/100)*$mouth_d;//险3缴纳的金额


            $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);//实际缴纳的社保费=单位+个人
            $gjj_js_base=0;
            $gjj_fee=0;
            $gjj_zhina_fee=0;
            if($is_gjj==1){//如果有公积金，将公积金也算进去
                $gjj_js_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                $fee=(($gjj_js_base*($city['gjj_bilie']))/100)*$mouth_d;//缴的公积金钱数
                $company_fee=(($gjj_js_base*($city['c_gjj_bilie']))/100)*$mouth_d;//单位补缴的公积金钱数
                $gjj_fee=round(($company_fee+$fee),2);
            }

            $sb_zhina_fee=0;

            $total_fee=$gjj_zhina_fee+$sb_zhina_fee+$service_fee+$sb_fee+$gjj_fee;//总共缴纳的=社保费+服务费+滞纳金

            $data=[
                'sb_fee'=>$sb_fee,
                'gjj_fee'=>$gjj_fee,
                'money'=>$total_fee,
                'sb_zhina_fee'=>$sb_zhina_fee,
                'gjj_zhina_fee'=>$gjj_zhina_fee,
                'service_fee'=>$service_fee,
                'xian_one_base'=>$xian_one_base,
                'c_xian_one'=>$city['c_xian_one'],
                'xian_one'=>$city['xian_one'],
                'xian_two_base'=>$xian_two_base,
                'xian_two'=>$city['xian_two'],
                'c_xian_two'=>$city['c_xian_two'],
                'xian_three_base'=>$xian_three_base,
                'xian_three'=>$city['xian_three'],
                'c_xian_three'=>$city['c_xian_three'],                                       'xian_four_base'=>$xian_four_base,
                'xian_four'=>$city['xian_four'],
                'c_xian_four'=>$city['c_xian_four'],                                       'xian_five_base'=>$xian_five_base,
                'xian_five'=>$city['xian_five'],
                'c_xian_five'=>$city['c_xian_four'],
                'c_gjj_bilie'=>$city['c_gjj_bilie'],
                'gjj_bilie'=>$city['gjj_bilie'],
                'c_gjj_base'=>$gjj_js_base,

            ];
            $ret=D("sb_company_order")->where(['id'=>$id])->save($data);

        }

    }else{
        return false;
    }

}
/*
 * 获取该地区的各个费用
 *      data:{'id':city,'money':money,'bj_time':bj_time},
 * 实际缴纳=基数*（比例1+2+3+4+5）*月数+服务费+
 * 笨方法只给公积金代缴的订单详情使用，其他的服务用  other_service_order
 */
function gjj_daijiao_getfee($id){
    $data=D("{$_SESSION['order_data']['table_name']}")->where(['id'=>$id])->find();
//        dump($data);die;
    $city_id=$data['to_city'];//地区id
    $money=$data['base_money'];//基数
    $end_time=$data['end_time'];//补缴时间
    $start_time=$data['start_time'];//补缴时间
    $d=strtotime($end_time)-strtotime($start_time);
    $day_d=date("d",$d);//差额天数
    $mouth_d=date("m",$d);//差额月

    if($city_id){
        $city=D("region")->where(['id'=>$city_id])->find();
        if($city){
            //如果基数大于最大基数或者小于最小基数，就不能计算
                $service_fee=$city["{$_SESSION['order_data']['table_name']}"];//服务费 是对应这个服务的表名的为字段名

            $gjj_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$money);
                $fee=(($gjj_base*($city['gjj_bilie']))/100)*$mouth_d;//缴的公积金钱数

                $company_fee=(($gjj_base*($city['c_gjj_bilie']))/100)*$mouth_d;//单位补缴的公积金钱数

                $gjj_fee=round(($fee+$company_fee),2);//公积金总费用
            $zhina_fee=(($day_d*$money*$city['stop_money'])/10000);
//            dump($day_d); dump($money);dump($city['stop_money']);
            $zhina_fee=round($zhina_fee,2);
            $zhina_fee=$_SESSION['order_data']['table_name']=='gjj_bujiao'? $zhina_fee : 0;

            $total_fee=($gjj_fee+$service_fee+$zhina_fee);//总共缴纳的

                $data_all=[
                    'zhina_fee'=>$zhina_fee,
                    'service_fee'=>$service_fee,
                    'c_gjj_bilie'=>$city['c_gjj_bilie'],
                    'gjj_bilie'=>$city['gjj_bilie'],
                    'sb_fee'=>$gjj_fee,
                    'gjj_base'=>$gjj_base,
                    'money'=>$total_fee
                ];
            $ret=D("{$_SESSION['order_data']['table_name']}")->where(['id'=>$id])->save($data_all);
            if($ret){
                $_SESSION['order_data']['total_fee']=$total_fee;
                return true;
            }else{
                return false;
            }
        }

    }

}
/*
 * 获取该地区的各个费用
 *      data:{'id':city,'money':money,'bj_time':bj_time},
 * 实际缴纳=基数*（比例1+2+3+4+5）*月数+服务费+滞纳金
 * 笨方法只给社保补缴的订单详情使用，其他的服务用  other_service_order
 */
function other_service_order($id){
    $table_name=$_SESSION['order_data']['table_name'];
    $data=D("{$table_name}")->where(['id'=>$id])->find();
    if($data){
        $city=D("region")->where(['id'=>$data['to_city']])->find();
        if($city){
            //只要服务费的

            $service_fee=$city["$table_name"];//每个服务的服务费以表名来设置

//            dump($table_name);
//            dump($id);
//            dump($service_fee);
//            dump($service_fee);

            $ret= M("{$table_name}")->where(['id'=>$id])->save(['service_fee'=>$service_fee,'money'=>$service_fee]);
//            dump($ret);
//           dump(M("{$table_name}")->getError());
//            dump(M("{$table_name}")->_sql());
//            echo  M()->getDbError();
////            echo $this->getDbError();
//            echo  M("{$table_name}")->getLastSql();die;
//            echo 444;
//            dump($ret);
//            dump($service_fee);
            if($ret){
                $_SESSION['order_data']['total_fee']=$service_fee;
                $_SESSION['order_data']['end_fee']=$service_fee;//用于后面是否有代金券，如果有代金券，则变为使用券之后的价格
                return true;
            }else{
                return false;
            }
        }
    }

}


/*
 * ajax  个人社保计算费用【五险一金或者无线或者公积金】
 *  1、user array(user_id=>[shebao_base,gjj_base],user_id2=>[shebao_base,gjj_base]);
 * 4/社保，[开始时间,结束时间]
 * 5/公积金，[开始时间,结束时间]
 * 。6 is_shebao  7.is_gjj
 * $is_bujiao 1 为补缴  0为代缴
 * */
function shebao_daijiao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$city,$is_bujiao=0){

    $city=D("region")->where(['id'=>intval($city)])->find();

    $shebao_start_time=$is_shebao==1 ? $shebao_date[0] : '';//社保缴纳时间,避免社保不交却计算出社保费
    $shebao_end_time=$is_shebao==1 ? $shebao_date[1] : '';//社保缴纳时间

     $gjj_start_time=$is_gjj==1 ? $gjj_date[0] : '';//公积金缴纳时间
    $gjj_end_time=$is_gjj==1 ? $gjj_date[1] : '';//公积金缴纳时间
//    echo $is_shebao;
//    echo $shebao_start_time;
//    echo $gjj_start_time;
    $all_total=0;//所有办理人的总额
    $data_fee=[];//办理人的所有费用总和
  //循环要办理社保的人
    foreach($user as $k=>$v){
        //取出这个人的户口性质，农村户口 的失业保险 个人部分不交。
        $user_info=M("users")->field("nature,username")->where(['user_id'=>$k])->find();

    $sb_base=$v['shebao_base'];//补缴基数
    $gjj_base=$v['gjj_base'];//公积金补缴基数


//    $d=strtotime($end_time)-strtotime($start_time);
//    $day_d=$d/(3600*24);//差额天数
    $shebao_mouth_diff=_getMonthNum($shebao_start_time,$shebao_end_time);//差额月
    $shebao_mouth_diff=$shebao_mouth_diff==0 ? 0 : $shebao_mouth_diff;
        $sb_diff_d=(strtotime($shebao_end_time)-strtotime($shebao_start_time))/(24*3600);//差额的天数,y用于计算社保滞纳金
    $gjj_mouth_diff=_getMonthNum($gjj_start_time,$gjj_end_time);//差额月
    $gjj_mouth_diff=$gjj_mouth_diff==0 ? 0 : $gjj_mouth_diff;
        $gjj_diff_d=(strtotime($gjj_end_time)-strtotime($gjj_start_time))/(24*3600);//差额的天数,y用于计算社保滞纳金
//    dump($shebao_mouth_diff);
//    dump($gjj_mouth_diff);die;

        if($city){

            //服务费
            $service_fee=0;
//            $mouth_d=0;
            $service_fee_info=json_decode($city['sb_daijiao'],true);
            //如果社保时间和公积金时间不同。
            if($is_shebao && $is_gjj){//社保和公积金都办理。
                if(($shebao_start_time==$gjj_start_time) && ($shebao_end_time==$gjj_end_time)){
                    //时间相同按照五险一金算
                    $service_fee= own_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,1);


                }else{//时间不同按照单独算

                    $sb_service_fee= own_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,2);
                    $gj_service_fee= own_service_total_fee($service_fee_info,$gjj_start_time,$gjj_end_time,2);
                    $service_fee=($sb_service_fee+$gj_service_fee);


                }
            }elseif($is_shebao){//只是社保

                $service_fee= own_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,2);

            }elseif($is_gjj){//只是公积金
                $service_fee= own_service_total_fee($service_fee_info,$gjj_start_time,$gjj_end_time,2);

            }

            $data_fee[$k]['sb_old_base']=$sb_base ? $sb_base : 0;
            $data_fee[$k]['gjj_old_base']=$gjj_base ? $gjj_base : 0;


            $data_fee[$k]['service_fee']=$service_fee;
            $data_fee[$k]['username']=$user_info['username'];

            //各个险的费用

            //险1
            $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
            $xian_one_own=(($xian_one_base*$city['xian_one'])/100)*$shebao_mouth_diff;
            $xian_one_company =(($xian_one_base*$city['c_xian_one'])/100)*$shebao_mouth_diff;//险一缴纳的金额
            $xian_one=round(($xian_one_own+$xian_one_company),2);//险一缴纳的金额
            $data_fee[$k]['xian_one_company']=$xian_one_company;
            $data_fee[$k]['xian_one_own']=$xian_one_own;
            $data_fee[$k]['xian_one']=$xian_one;
            $data_fee[$k]['xian_one_base']=$xian_one_base;

            //险二
            $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
            if($user_info['nature']==1){
                $xian_two_own=0;
            }else{//农村户口个人不交失业险
                $xian_two_own=((($xian_two_base*$city['xian_two'])/100)*$shebao_mouth_diff);
            }

            $xian_two_company=(($xian_two_base*$city['c_xian_two'])/100)*$shebao_mouth_diff;
            $xian_two=round(($xian_two_company+$xian_two_own),2);//险2缴纳的金额
            $data_fee[$k]['xian_two_own']=$xian_two_own;
            $data_fee[$k]['xian_two_company']=$xian_two_company;
            $data_fee[$k]['xian_two']=$xian_two;
            $data_fee[$k]['xian_two_base']=$xian_two_base;


          //   险三
            $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
            $xian_three_own=(($xian_three_base*$city['xian_three'])/100)*$shebao_mouth_diff;
            $xian_three_company=(($xian_three_base*$city['c_xian_three'])/100)*$shebao_mouth_diff;
            $xian_three=round(($xian_three_own+$xian_three_company),2);//险3缴纳的金额
            $data_fee[$k]['xian_three_own']=$xian_three_own;
            $data_fee[$k]['xian_three_company']=$xian_three_company;
            $data_fee[$k]['xian_three']=$xian_three;
            $data_fee[$k]['xian_three_base']=$xian_three_base;

            //险4
            $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
            $xian_four_own=(($xian_four_base*$city['xian_four'])/100)*$shebao_mouth_diff;
            $xian_four_company=(($xian_four_base*$city['c_xian_four'])/100)*$shebao_mouth_diff;//险4缴纳的金额
            $xian_four=round(($xian_four_own+$xian_four_company),2);//险4缴纳的金额
            $data_fee[$k]['xian_four_own']=$xian_four_own;
            $data_fee[$k]['xian_four_company']=$xian_four_company;
            $data_fee[$k]['xian_four']=$xian_four;
            $data_fee[$k]['xian_four_base']=$xian_four_base;

//            险5
            $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);
            $xian_five_own=$is_shebao==1 ? ((($xian_five_base*$city['xian_five'])/100)*$shebao_mouth_diff+3) : 0;//个人医疗加三块
            $xian_five_company=(($xian_five_base*$city['c_xian_five'])/100)*$shebao_mouth_diff;//险5缴纳的金额
            $xian_five=round(($xian_five_company+$xian_five_own),2);//险5缴纳的金额
            $data_fee[$k]['xian_five_own']=$xian_five_own;
            $data_fee[$k]['xian_five_company']=$xian_five_company;
            $data_fee[$k]['xian_five']=$xian_five;
            $data_fee[$k]['xian_five_base']=$xian_five_base;


            $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);//实际缴纳的社保费=单位+个人
            $data_fee[$k]['sb_fee']=$sb_fee;

                $gjj_js_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                $gjj_own=(($gjj_js_base*($city['gjj_bilie']))/100)*$gjj_mouth_diff;//缴的公积金钱数
                $gjj_company=(($gjj_js_base*($city['c_gjj_bilie']))/100)*$gjj_mouth_diff;//单位补缴的公积金钱数
                $gjj_fee=round(($gjj_own+$gjj_company),2);
            $data_fee[$k]['gjj_own']=$gjj_own;
            $data_fee[$k]['gjj_company']=$gjj_company;
            $data_fee[$k]['gjj_fee']=$gjj_fee;
            $data_fee[$k]['gjj_js_base']=$gjj_js_base;

            //单位缴纳的总金额：
            $data_fee[$k]['company_fee']=($gjj_company+$xian_five_company+$xian_four_company+$xian_three_company+$xian_two_company+$xian_one_company);
            //个人缴纳的总金额：
            $data_fee[$k]['own_fee']=($gjj_own+$xian_five_own+$xian_four_own+$xian_three_own+$xian_two_own+$xian_one_own);
//                $gjj_zhina_fee=(($day_d*$gjj_fee*$city['stop_money'])/10000);
//                $gjj_zhina_fee=round($gjj_zhina_fee,2);
//                $gjj_zhina_fee=$_SESSION['order_data']['table_name']=='sb_bujiao'? $gjj_zhina_fee: 0;


            //滞纳金=天数*滞纳率*总社保费
            $zhina_fee=0;
            $sb_zhinafee=0;
            $gjj_zhinafee=0;
            if($is_bujiao){
                $sb_zhinafee=(($sb_diff_d*($sb_fee+$gjj_fee)*$city['stop_money'])/10000);
                $gjj_zhinafee=(($gjj_diff_d*($sb_fee+$gjj_fee)*$city['stop_money'])/10000);
                $zhina_fee=round(($gjj_zhinafee+$sb_zhinafee),2);
            }
            $data_fee[$k]['zhina_fee']=$zhina_fee;
            $data_fee[$k]['gjj_zhinafee']=$gjj_zhinafee;
            $data_fee[$k]['sb_zhinafee']=$sb_zhinafee;

            $gjj_unit_fee=$gjj_mouth_diff==0 ? 0 : round(($gjj_fee/$gjj_mouth_diff),2);
            $data_fee[$k]['gjj_unit_fee']=$gjj_unit_fee;//每月公积金费用

            $sb_unit_fee=$shebao_mouth_diff==0 ? 0 : round(($sb_fee/$shebao_mouth_diff),2);
            $data_fee[$k]['sb_unit_fee']=$sb_unit_fee;//每月社保费用
//             dump($sb_fee);
//             dump($shebao_mouth_diff);
//             dump($sb_unit_fee);
            $total_fee=$service_fee+$sb_fee+$gjj_fee+$zhina_fee;//总共缴纳的=社保费+服务费+滞纳金

            $data_fee[$k]['total_fee']=$total_fee;
            $all_total+=$total_fee;

        }

    }
    return array('data_fee'=>$data_fee,'all_total'=>$all_total);

}


/*
 * ajax  企业社保计算费用【五险一金或者无线或者公积金】
 *  1、user array(user_id=>[shebao_base,gjj_base],user_id2=>[shebao_base,gjj_base]);
 * 4/社保，[开始时间,结束时间]
 * 5/公积金，[开始时间,结束时间]
 * 。6 is_shebao  7.is_gjj
 * $is_bujiao 1 为补缴  0为代缴
 * $is_guakao  1 挂靠，2补缴
 * $people  办理人数
 * */
function company_shebao_ajax_jisuan($user,$shebao_date,$gjj_date,$is_shebao,$is_gjj,$city,$is_bujiao=0,$is_guakao,$people){

    $city=D("region")->where(['id'=>intval($city)])->find();

    $shebao_start_time=$is_shebao==1 ? $shebao_date[0] : '';//社保缴纳时间,避免社保不交却计算出社保费
    $shebao_end_time=$is_shebao==1 ? $shebao_date[1] : '';//社保缴纳时间

     $gjj_start_time=$is_gjj==1 ? $gjj_date[0] : '';//公积金缴纳时间
    $gjj_end_time=$is_gjj==1 ? $gjj_date[1] : '';//公积金缴纳时间
//    echo $is_shebao;
//    echo $shebao_start_time;
//    echo $gjj_start_time;
    $all_total=0;//所有办理人的总额
    $data_fee=[];//办理人的所有费用总和
  //循环要办理社保的人
    foreach($user as $k=>$v){
        //取出这个人的户口性质，农村户口 的失业保险 个人部分不交。
        $user_info=M("users")->field("nature,username")->where(['user_id'=>$k])->find();

    $sb_base=$v['shebao_base'];//补缴基数
    $gjj_base=$v['gjj_base'];//公积金补缴基数


//    $d=strtotime($end_time)-strtotime($start_time);
//    $day_d=$d/(3600*24);//差额天数
    $shebao_mouth_diff=_getMonthNum($shebao_start_time,$shebao_end_time);//差额月
    $shebao_mouth_diff=$shebao_mouth_diff==0 ? 0 : $shebao_mouth_diff;
        $sb_diff_d=(strtotime($shebao_end_time)-strtotime($shebao_start_time))/(24*3600);//差额的天数,y用于计算社保滞纳金
    $gjj_mouth_diff=_getMonthNum($gjj_start_time,$gjj_end_time);//差额月
    $gjj_mouth_diff=$gjj_mouth_diff==0 ? 0 : $gjj_mouth_diff;
        $gjj_diff_d=(strtotime($gjj_end_time)-strtotime($gjj_start_time))/(24*3600);//差额的天数,y用于计算社保滞纳金

        if($city){

            //服务费
            $service_fee=0;
//            $mouth_d=0;
            $service_fee_info=json_decode($city['company_sb_daijiao'],true);
            //如果社保时间和公积金时间不同。
            if($is_shebao && $is_gjj){//社保和公积金都办理。
                if(($shebao_start_time==$gjj_start_time) && ($shebao_end_time==$gjj_end_time)){
                    //时间相同按照五险一金算 1.挂靠 2.代理
                    //company_service_total_fee($data,$start_m,$end_m,$type,$is_guakao,$people)
                    $service_fee= company_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,1,$is_guakao,$people);


                }else{//时间不同按照单独算

                    $sb_service_fee= company_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,2,$is_guakao,$people);
                    $gj_service_fee= company_service_total_fee($service_fee_info,$gjj_start_time,$gjj_end_time,2,$is_guakao,$people);
                    $service_fee=($sb_service_fee+$gj_service_fee);

//                    dump($sb_service_fee);
//                    dump($gj_service_fee);
                }
            }elseif($is_shebao){//只是社保

                $service_fee= company_service_total_fee($service_fee_info,$shebao_start_time,$shebao_end_time,2,$is_guakao,$people);

            }elseif($is_gjj){//只是公积金
                $service_fee= company_service_total_fee($service_fee_info,$gjj_start_time,$gjj_end_time,2,$is_guakao,$people);

            }

            $data_fee[$k]['service_fee']=$service_fee;
            $data_fee[$k]['username']=$user_info['username'];

            //各个险的费用
            $data_fee[$k]['sb_old_base']=$sb_base ? $sb_base : 0;
            $data_fee[$k]['gjj_old_base']=$gjj_base ? $gjj_base : 0;
            //险1
            $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
            $xian_one_own=(($xian_one_base*$city['xian_one'])/100)*$shebao_mouth_diff;
            $xian_one_company =(($xian_one_base*$city['c_xian_one'])/100)*$shebao_mouth_diff;//险一缴纳的金额
            $xian_one=round(($xian_one_own+$xian_one_company),2);//险一缴纳的金额
            $data_fee[$k]['xian_one_company']=$xian_one_company;
            $data_fee[$k]['xian_one_own']=$xian_one_own;
            $data_fee[$k]['xian_one']=$xian_one;
            $data_fee[$k]['xian_one_base']=$xian_one_base;


            //险二
            $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);
            if($user_info['nature']==1){
                $xian_two_own=0;
            }else{//农村户口个人不交失业险
                $xian_two_own=((($xian_two_base*$city['xian_two'])/100)*$shebao_mouth_diff);
            }

            $xian_two_company=(($xian_two_base*$city['c_xian_two'])/100)*$shebao_mouth_diff;
            $xian_two=round(($xian_two_company+$xian_two_own),2);//险2缴纳的金额
            $data_fee[$k]['xian_two_own']=$xian_two_own;
            $data_fee[$k]['xian_two_company']=$xian_two_company;
            $data_fee[$k]['xian_two']=$xian_two;
            $data_fee[$k]['xian_two_base']=$xian_two_base;


          //   险三
            $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
            $xian_three_own=(($xian_three_base*$city['xian_three'])/100)*$shebao_mouth_diff;
            $xian_three_company=(($xian_three_base*$city['c_xian_three'])/100)*$shebao_mouth_diff;
            $xian_three=round(($xian_three_own+$xian_three_company),2);//险3缴纳的金额
            $data_fee[$k]['xian_three_own']=$xian_three_own;
            $data_fee[$k]['xian_three_company']=$xian_three_company;
            $data_fee[$k]['xian_three']=$xian_three;
            $data_fee[$k]['xian_three_base']=$xian_three_base;

            //险4
            $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
            $xian_four_own=(($xian_four_base*$city['xian_four'])/100)*$shebao_mouth_diff;
            $xian_four_company=(($xian_four_base*$city['c_xian_four'])/100)*$shebao_mouth_diff;//险4缴纳的金额
            $xian_four=round(($xian_four_own+$xian_four_company),2);//险4缴纳的金额
            $data_fee[$k]['xian_four_own']=$xian_four_own;
            $data_fee[$k]['xian_four_company']=$xian_four_company;
            $data_fee[$k]['xian_four']=$xian_four;
            $data_fee[$k]['xian_four_base']=$xian_four_base;

//            险5
            $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);
            $xian_five_own=$is_shebao==1 ? ((($xian_five_base*$city['xian_five'])/100)*$shebao_mouth_diff+3) : 0;//个人医疗加三块
            $xian_five_company=(($xian_five_base*$city['c_xian_five'])/100)*$shebao_mouth_diff;//险5缴纳的金额
            $xian_five=round(($xian_five_company+$xian_five_own),2);//险5缴纳的金额
            $data_fee[$k]['xian_five_own']=$xian_five_own;
            $data_fee[$k]['xian_five_company']=$xian_five_company;
            $data_fee[$k]['xian_five']=$xian_five;
            $data_fee[$k]['xian_five_base']=$xian_five_base;


            $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);//实际缴纳的社保费=单位+个人
            $data_fee[$k]['sb_fee']=$sb_fee;

                $gjj_js_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                $gjj_own=(($gjj_js_base*($city['gjj_bilie']))/100)*$gjj_mouth_diff;//缴的公积金钱数
                $gjj_company=(($gjj_js_base*($city['c_gjj_bilie']))/100)*$gjj_mouth_diff;//单位补缴的公积金钱数
                $gjj_fee=round(($gjj_own+$gjj_company),2);
            $data_fee[$k]['gjj_own']=$gjj_own;
            $data_fee[$k]['gjj_company']=$gjj_company;
            $data_fee[$k]['gjj_fee']=$gjj_fee;
            $data_fee[$k]['gjj_js_base']=$gjj_js_base;

            //单位缴纳的总金额：
            $data_fee[$k]['company_fee']=($gjj_company+$xian_five_company+$xian_four_company+$xian_three_company+$xian_two_company+$xian_one_company);
            //个人缴纳的总金额：
            $data_fee[$k]['own_fee']=($gjj_own+$xian_five_own+$xian_four_own+$xian_three_own+$xian_two_own+$xian_one_own);
//                $gjj_zhina_fee=(($day_d*$gjj_fee*$city['stop_money'])/10000);
//                $gjj_zhina_fee=round($gjj_zhina_fee,2);
//                $gjj_zhina_fee=$_SESSION['order_data']['table_name']=='sb_bujiao'? $gjj_zhina_fee: 0;


            //滞纳金=天数*滞纳率*总社保费
            $zhina_fee=0;
            $sb_zhinafee=0;
            $gjj_zhinafee=0;
            if($is_bujiao){
                $sb_zhinafee=(($sb_diff_d*($sb_fee+$gjj_fee)*$city['stop_money'])/10000);
                $gjj_zhinafee=(($gjj_diff_d*($sb_fee+$gjj_fee)*$city['stop_money'])/10000);
                $zhina_fee=round(($gjj_zhinafee+$sb_zhinafee),2);
            }
            $data_fee[$k]['zhina_fee']=$zhina_fee;
            $data_fee[$k]['gjj_zhinafee']=$gjj_zhinafee;
            $data_fee[$k]['sb_zhinafee']=$sb_zhinafee;

            $gjj_unit_fee=$gjj_mouth_diff==0 ? 0 : round(($gjj_fee/$gjj_mouth_diff),2);
            $data_fee[$k]['gjj_unit_fee']=$gjj_unit_fee;//每月公积金费用

            $sb_unit_fee=$shebao_mouth_diff==0 ? 0 : round(($sb_fee/$shebao_mouth_diff),2);
            $data_fee[$k]['sb_unit_fee']=$sb_unit_fee;//每月社保费用
//             dump($sb_fee);
//             dump($shebao_mouth_diff);
//             dump($sb_unit_fee);
            $total_fee=$service_fee+$sb_fee+$gjj_fee+$zhina_fee;//总共缴纳的=社保费+服务费+滞纳金

            $data_fee[$k]['total_fee']=$total_fee;
            $all_total+=$total_fee;

        }

    }
    return array('data_fee'=>$data_fee,'all_total'=>$all_total);

}


/*
 * ajax 社保计算器
 *  1、user array(user_id=>[shebao_base,gjj_base],user_id2=>[shebao_base,gjj_base]);
 * 4/社保，[开始时间,结束时间]
 * 5/公积金，[开始时间,结束时间]
 * 。6 is_shebao  7.is_gjj
 * $is_bujiao 1 为补缴  0为代缴
 * $is_guakao  1 挂靠，2补缴
 * $people  办理人数
 * */
function search_shebao_ajax_jisuan($city,$sb_base,$gjj_base){

    $city=D("region")->where(['id'=>intval($city)])->find();

    $shebao_mouth_diff=1;
    $gjj_mouth_diff=1;
    $all_total=0;//所有办理人的总额
    $data_fee=[];//办理人的所有费用总和

        if($city){


            //各个险的费用

            //险1
            $xian_one_base=get_num($city['xian_one_min'],$city['xian_one_max'],$sb_base);
            $xian_one_own=(($xian_one_base*$city['xian_one'])/100)*$shebao_mouth_diff;
            $xian_one_company =(($xian_one_base*$city['c_xian_one'])/100)*$shebao_mouth_diff;//险一缴纳的金额
            $xian_one=round(($xian_one_own+$xian_one_company),2);//险一缴纳的金额
            $data_fee['xian_one_company']=$xian_one_company;
            $data_fee['xian_one_own']=$xian_one_own;
            $data_fee['xian_one']=$xian_one;
            $data_fee['xian_one_base']=$xian_one_base;

            //险二
            $xian_two_base=get_num($city['xian_two_min'],$city['xian_two_max'],$sb_base);

                $xian_two_own=((($xian_two_base*$city['xian_two'])/100)*$shebao_mouth_diff);


            $xian_two_company=(($xian_two_base*$city['c_xian_two'])/100)*$shebao_mouth_diff;
            $xian_two=round(($xian_two_company+$xian_two_own),2);//险2缴纳的金额
            $data_fee['xian_two_own']=$xian_two_own;
            $data_fee['xian_two_own_n']=0;//农村为0
            $data_fee['xian_two_company']=$xian_two_company;
            $data_fee['xian_two']=$xian_two;
            $data_fee['xian_two_n']=$xian_two_company;
//            $data_fee['xian_two_base']=$xian_two_base;


          //   险三
            $xian_three_base=get_num($city['xian_three_min'],$city['xian_three_max'],$sb_base);
            $xian_three_own=(($xian_three_base*$city['xian_three'])/100)*$shebao_mouth_diff;
            $xian_three_company=(($xian_three_base*$city['c_xian_three'])/100)*$shebao_mouth_diff;
            $xian_three=round(($xian_three_own+$xian_three_company),2);//险3缴纳的金额
            $data_fee['xian_three_own']=$xian_three_own;
            $data_fee['xian_three_company']=$xian_three_company;
            $data_fee['xian_three']=$xian_three;
            $data_fee['xian_three_base']=$xian_three_base;

            //险4
            $xian_four_base=get_num($city['xian_four_min'],$city['xian_four_max'],$sb_base);
            $xian_four_own=(($xian_four_base*$city['xian_four'])/100)*$shebao_mouth_diff;
            $xian_four_company=(($xian_four_base*$city['c_xian_four'])/100)*$shebao_mouth_diff;//险4缴纳的金额
            $xian_four=round(($xian_four_own+$xian_four_company),2);//险4缴纳的金额
            $data_fee['xian_four_own']=$xian_four_own;
            $data_fee['xian_four_company']=$xian_four_company;
            $data_fee['xian_four']=$xian_four;
            $data_fee['xian_four_base']=$xian_four_base;

//            险5
            $xian_five_base=get_num($city['xian_five_min'],$city['xian_five_max'],$sb_base);
            $xian_five_own=((($xian_five_base*$city['xian_five'])/100)*$shebao_mouth_diff+3);//个人医疗加三块
            $xian_five_company=(($xian_five_base*$city['c_xian_five'])/100)*$shebao_mouth_diff;//险5缴纳的金额
            $xian_five=round(($xian_five_company+$xian_five_own),2);//险5缴纳的金额
            $data_fee['xian_five_own']=$xian_five_own;
            $data_fee['xian_five_company']=$xian_five_company;
            $data_fee['xian_five']=$xian_five;
            $data_fee['xian_five_base']=$xian_five_base;


            $sb_fee_n=round(($xian_five+$xian_four+$xian_three+$xian_two_company+$xian_one),2);//农村  实际缴纳的社保费=单位+个人
            $sb_fee=round(($xian_five+$xian_four+$xian_three+$xian_two+$xian_one),2);//城市 实际缴纳的社保费=单位+个人
            $data_fee['sb_fee']=$sb_fee;
            $data_fee['sb_fee_n']=$sb_fee_n;//农村的社保总费用

            $data_fee['sb_fee_own_n']=$xian_one_own+0+$xian_three_own+$xian_four_own+$xian_five_own;//农村的个人缴纳的社保总费用

            $data_fee['sb_fee_own_city']=$xian_one_own+$xian_two_own+$xian_three_own+$xian_four_own+$xian_five_own;//城市的个人缴纳的社保总费用

            $data_fee['sb_fee_company_n']=$xian_one_company+$xian_two_company+$xian_three_company+$xian_four_company+$xian_five_company;//农村的单位缴纳的社保总费用
            $data_fee['sb_fee_company_city']=$xian_one_company+$xian_two_company+$xian_three_company+$xian_four_company+$xian_five_company;//城市的单位缴纳的社保总费用


                $gjj_js_base=get_num($city['gjj_minbase'],$city['gjj_maxbase'],$gjj_base);
                $gjj_own=(($gjj_js_base*($city['gjj_bilie']))/100)*$gjj_mouth_diff;//个人缴的公积金钱数
                $gjj_company=(($gjj_js_base*($city['c_gjj_bilie']))/100)*$gjj_mouth_diff;//单位补缴的公积金钱数

                $gjj_fee=round(($gjj_own+$gjj_company),2);
            $data_fee['gjj_own']=$gjj_own;
            $data_fee['gjj_company']=$gjj_company;
            $data_fee['gjj_fee']=$gjj_fee;
            $data_fee['gjj_js_base']=$gjj_js_base;

            //单位缴纳的总金额：
            $data_fee['company_fee']=($gjj_company+$xian_five_company+$xian_four_company+$xian_three_company+$xian_two_company+$xian_one_company);
            //个人缴纳的总金额：
            $data_fee['own_fee_n']=($gjj_own+$xian_five_own+$xian_four_own+$xian_three_own+0+$xian_one_own);//农村
            $data_fee['own_fee']=($gjj_own+$xian_five_own+$xian_four_own+$xian_three_own+$xian_two_own+$xian_one_own);//城市


//             dump($sb_fee);
//             dump($shebao_mouth_diff);
//             dump($sb_unit_fee);
            $total_fee=$sb_fee+$gjj_fee;//总共缴纳的=社保费+服务费+滞纳金
            $total_fee_n=$sb_fee_n+$gjj_fee;//总共缴纳的=社保费+服务费+滞纳金

            $data_fee['total_fee']=$total_fee;
            $data_fee['total_fee_n']=$total_fee_n;

        }


    return $data_fee;

}



////标记代金券为已使用
// function _remark_coupon($order_sn=""){
//    $table_name=$_SESSION['order_data']['table_name'];
//    $coupon_id=$_SESSION['order_data']['coupon_id'];
//    $data=['order_sn'=>"$order_sn",'table_name'=>"$table_name",'is_use'=>2,'use_time'=>time(),'user_id'=>$_SESSION['user_id']];
//    D("coupon")->where(['coupon_id'=>$coupon_id])->save($data);
//}


function send_mess_to_user($mobile,$content){
    $url="http://web.cr6868.com/asmx/smsservice.aspx?";
//    $mobile=D("admin")->where(['admin_id'=>1])->find();
    $data=[
        'name'=>'18210418995',
        'pwd'=>'741592C128BA3DE65F204DB96448',
        'content'=>$content,
        'mobile'=>$mobile,
        'sign'=>'【慧智博思社保代理】',
        'type'=>'pt',
    ];
    httpRequest($url,'post',$data);
    return true;
}

function httpRequest_array($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
//        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
    //return array($http_code, $response,$requestinfo);
}
/**
 * CURL请求 json 格式的数据
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
function httpRequest_json($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
//                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, json_decode($postfields));
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
//        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
    //return array($http_code, $response,$requestinfo);
}
/**
   订单号 表名+年月日
 *
 */
function get_order_sn(){
    $order_sn= date('YmdHis').mt_rand(10000,99999);
    return $order_sn;
}

/**
 * 获取用户信息
 * @param $user_id_or_name  用户id 邮箱 手机 第三方id
 * @param int $type  类型 0 user_id查找 1 邮箱查找 2 手机查找 3 第三方唯一标识查找
 * @param string $oauth  第三方来源
 * @return mixed
 */

function get_user_info($user_id_or_name,$type = 0,$oauth=''){
    $map = array();
    if($type == 0)
        $map['user_id'] = $user_id_or_name;
    if($type == 1)
        $map['email'] = $user_id_or_name;
    if($type == 2)
        $map['mobile'] = $user_id_or_name;
    if($type == 3){
        $map['openid'] = $user_id_or_name;
        $map['oauth'] = $oauth;
    }
    $user = M('users')->where($map)->find();
    return $user;
}
//微信生成临时二维码
/*	string@ticket 二维码ticket
    string@action_name 二维码类型 QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
    int@expire_seconds	有效时长 单位s
    int@scene_id	场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
    string@scene_str	场景值ID（字符串形式的ID），字符串类型，长度限制为1到64，仅永久二维码支持此字段
 *
 * */
function createQRcode($url=null,$ticket=null,$action_name='QR_SCENE',$expire_secondes=600,$scene_id=0,$scene_str=null){
    if(!$ticket){	//没有ticket的时候
        $json = array();
        $json['action_name'] = $action_name;
        if($action_name == 'QR_SCENE'){	//临时二维码
            $json['expire_seconds'] = $expire_secondes;
            $json['action_info'] = array(
                "scene" =>array(
                    "scene_id"=>$scene_id
                )
            );
        }else{	//永久二维码
            if($scene_id){	//优先采用scene_id
                $json['action_info'] = array(
                    "scene" =>array(
                        "scene_id"=>$scene_id
                    )
                );
            }else{
                if($scene_str){
                    $json['action_info'] = array(
                        "scene" =>array(
                            "scene_str"=>$scene_id
                        )
                    );
                }else{
                    return array('msg'=>'生成永久二维码时scene_id、scene_str必填其一','status'=>false);
                    exit;
                }
            }

        }

        $re = httpRequest_array($url,'POST',json_encode($json,JSON_UNESCAPED_UNICODE));
        return $re;
    }else{

        $re = httpRequest_array($url.$ticket,'GET');
        return $re;
    }
}


/**
 * 更新会员等级,折扣，消费总额
 * @param $user_id  用户ID
 * @return boolean
 */
function update_user_level($user_id){
    $level_info = M('user_level')->order('level_id')->select();
    $total_amount = M('order')->where("user_id=$user_id AND pay_status=1 and order_status not in (3,5)")->sum('order_amount');
    if($level_info){
    	foreach($level_info as $k=>$v){
    		if($total_amount >= $v['amount']){
    			$level = $level_info[$k]['level_id'];
    			$discount = $level_info[$k]['discount']/100;
    		}
    	}
    	$user = session('user');
    	$updata['total_amount'] = $total_amount;//更新累计修复额度
    	//累计额度达到新等级，更新会员折扣
    	if(isset($level) && $level>$user['level']){
    		$updata['level'] = $level;
    		$updata['discount'] = $discount;	
    	}
    	M('users')->where("user_id=$user_id")->save($updata);
    }
}

/**
 *  商品缩略图 给于标签调用 拿出商品表的 original_img 原始图来裁切出来的
 * @param type $goods_id  商品id
 * @param type $width     生成缩略图的宽度
 * @param type $height    生成缩略图的高度
 */
function goods_thum_images($goods_id,$width,$height){

     if(empty($goods_id))
		 return '';
    //判断缩略图是否存在
    $path = "Public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name ="goods_thumb_{$goods_id}_{$width}_{$height}";
  
    // 这个商品 已经生成过这个比例的图片就直接返回了
    if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg'; 
    if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg'; 
    if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif'; 
    if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png'; 
        
    $original_img = M('Goods')->where("goods_id = $goods_id")->getField('original_img');
    if(empty($original_img)) return '';
    
    $original_img = '.'.$original_img; // 相对路径
    if(!file_exists($original_img)) return '';

    $image = new \Think\Image();
    $image->open($original_img);
        
    $goods_thumb_name = $goods_thumb_name. '.'.$image->type();
    //生成缩略图
    if(!is_dir($path)) 
        mkdir($path,0777,true);
    
    //参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
    $image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
    
    //图片水印处理
    $water = tpCache('water');
    if($water['is_mark']==1){
    	$imgresource = './'.$path.$goods_thumb_name;
    	if($width>$water['mark_width'] && $height>$water['mark_height']){
    		if($water['mark_type'] == 'img'){
    			$image->open($imgresource)->water(".".$water['mark_img'],$water['sel'],$water['mark_degree'])->save($imgresource);
    		}else{
    		    //检查字体文件是否存在
    			if(file_exists('./zhjt.ttf')){
    				$image->open($imgresource)->text($water['mark_txt'],'./zhjt.ttf',20,'#000000',$water['sel'])->save($imgresource);
    			}
    		}
    	}
    }
    return '/'.$path.$goods_thumb_name;
}

/**
 * 商品相册缩略图
 */
function get_sub_images($sub_img,$goods_id,$width,$height){
	//判断缩略图是否存在
	$path = "Public/upload/goods/thumb/$goods_id/";
	$goods_thumb_name ="goods_sub_thumb_{$sub_img['img_id']}_{$width}_{$height}";
	//这个缩略图 已经生成过这个比例的图片就直接返回了
	if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg';
	if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg';
	if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif';
	if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png';
	
	$original_img = '.'.$sub_img['image_url']; //相对路径
	if(!file_exists($original_img)) return '';
	
	$image = new \Think\Image();
	$image->open($original_img);
	
	$goods_thumb_name = $goods_thumb_name. '.'.$image->type();
	// 生成缩略图
	if(!is_dir($path))
		mkdir($path,777,true);
	$image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
	return '/'.$path.$goods_thumb_name;
}

/**
 * 刷新商品库存, 如果商品有设置规格库存, 则商品总库存 等于 所有规格库存相加
 * @param type $goods_id  商品id
 */
function refresh_stock($goods_id){
    $count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->count();
    if($count == 0) return false; // 没有使用规格方式 没必要更改总库存

    $store_count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->sum('store_count');
    M("Goods")->where("goods_id = $goods_id")->save(array('store_count'=>$store_count)); // 更新商品的总库存
}

/**
 * 根据 order_goods 表扣除商品库存
 * @param type $order_id  订单id
 */
function minus_stock($order_id){
    $orderGoodsArr = M('OrderGoods')->where("order_id = $order_id")->select();
    foreach($orderGoodsArr as $key => $val)
    {
        // 有选择规格的商品
        if(!empty($val['spec_key']))
        {   // 先到规格表里面扣除数量 再重新刷新一个 这件商品的总数量
            M('SpecGoodsPrice')->where("goods_id = {$val['goods_id']} and `key` = '{$val['spec_key']}'")->setDec('store_count',$val['goods_num']);
            refresh_stock($val['goods_id']);
        }else{
            M('Goods')->where("goods_id = {$val['goods_id']}")->setDec('store_count',$val['goods_num']); // 直接扣除商品总数量
        }
        M('Goods')->where("goods_id = {$val['goods_id']}")->setInc('sales_sum',$val['goods_num']); // 增加商品销售量
        //更新活动商品购买量
        if($val['prom_type']==1 || $val['prom_type']==2){
        	$prom = get_goods_promotion($val['goods_id']);
        	if($prom['is_end']==0){
        		$tb = $val['prom_type']==1 ? 'flash_sale' : 'group_buy';
        		M($tb)->where("id=".$val['prom_id'])->setInc('buy_num',$val['goods_num']);
        		M($tb)->where("id=".$val['prom_id'])->setInc('order_num');
        	}
        }
    }
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    require_once THINK_PATH.'Library/Vendor/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $config = tpCache('smtp');
	$mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //调试输出格式
	//$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
	
	if($mail->Port === 465) $mail->SMTPSecure = 'ssl';// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
    	foreach ($to as $v){
    		$mail->addAddress($v);
    	}
    }else{
    	$mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    return $mail->send();
}

/**
 * 发送短信
 * @param $mobile  手机号码
 * @param $content  内容
 * @return bool

function sendSMS($mobile,$content)
{
    $config = F('sms','',TEMP_PATH);
    $http = $config['sms_url'];			//短信接口
    $uid = $config['sms_user'];			//用户账号
    $pwd = $config['sms_pwd'];			//密码
    $mobileids = $mobile;         		//号码发送状态接收唯一编号
    $data = array
    (
        'uid'=>$uid,					//用户账号
        'pwd'=>md5($pwd.$uid),			//MD5位32密码,密码和用户名拼接字符
        'mobile'=>$mobile,				//号码，以英文逗号隔开
        'content'=>$content,			//内容
        'mobileids'=>$mobileids,
    );
    //即时发送
    $res = httpRequest($http,'POST',$data);//POST方式提交
    $stat = strpos($res,'stat=100');
    if($stat){
        return true;
    }else{
        return false;
    }
}
 */
//    /**
//     * 发送短信
//     * @param $mobile  手机号码
//     * @param $code    验证码
//     * @return bool    短信发送成功返回true失败返回false
//     */
function sendSMS($mobile, $code)
{
    //时区设置：亚洲/上海
    date_default_timezone_set('Asia/Shanghai');
    //这个是你下面实例化的类
    vendor('Alidayu.TopClient');
    //这个是topClient 里面需要实例化一个类所以我们也要加载 不然会报错
    vendor('Alidayu.ResultSet');
    //这个是成功后返回的信息文件
    vendor('Alidayu.RequestCheckUtil');
    //这个是错误信息返回的一个php文件
    vendor('Alidayu.TopLogger');
    //这个也是你下面示例的类
    vendor('Alidayu.AlibabaAliqinFcSmsNumSendRequest');

    $c = new \TopClient;
    $config =  tpCache('sms');
    //短信内容：公司名/名牌名/产品名
    $product = $config['sms_product'];
    //App Key的值 这个在开发者控制台的应用管理点击你添加过的应用就有了
    $c->appkey = $config['sms_appkey'];
    //App Secret的值也是在哪里一起的 你点击查看就有了
    $c->secretKey = $config['sms_secretKey'];
    //这个是用户名记录那个用户操作
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    //代理人编号 可选
    $req->setExtend("123456");
    //短信类型 此处默认 不用修改
    $req->setSmsType("normal");
    //短信签名 必须
    $req->setSmsFreeSignName("注册验证");
    //短信模板 必须
    $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
    //短信接收号码 支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，
    $req->setRecNum("$mobile");
    //短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。
    $req->setSmsTemplateCode($config['sms_templateCode']); // templateCode
    
    $c->format='json'; 
    //发送短信
    $resp = $c->execute($req);
    //短信发送成功返回True，失败返回false
    //if (!$resp)
    if ($resp && $resp->result)   // if($resp->result->success == true)
    {
        // 从数据库中查询是否有验证码
        $data = M('sms_log')->where("code = '$code' and add_time > ".(time() - 60*60))->find();
        // 没有就插入验证码,供验证用
        empty($data) && M('sms_log')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => SESSION_ID));
        return true;        
    }
    else 
    {
        return false;
    }
}

/**
 * 查询快递
 * @param $postcom  快递公司编码
 * @param $getNu  快递单号
 * @return array  物流跟踪信息数组
 */
function queryExpress($postcom , $getNu) {
    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id={$postcom}&fromWeb=null&postid={$getNu}";
    //$resp = httpRequest($url,'GET');
    $resp = file_get_contents($url);
    if (empty($resp)) {
        return array('status'=>0, 'message'=>'物流公司网络异常，请稍后查询');
    }
    preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $resp, $arr);
    if (!isset($arr[1])) {
        return array( 'status'=>0, 'message'=>'查询失败，参数有误' );
    }else{
        foreach ($arr[1] as $key => $value) {
            $a = array();
            $a = explode('<br /> ', $value);
            $data[$key]['time'] = $a[0];
            $data[$key]['context'] = $a[1];
        }     
        return array( 'status'=>1, 'message'=>'ok','data'=> array_reverse($data));
    }
}

/**
 * 获取某个商品分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getCatGrandson ($cat_id)
{
    $GLOBALS['catGrandson'] = array();
    $GLOBALS['category_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['catGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['category_id_arr'] = M('GoodsCategory')->cache(true,TPSHOP_CACHE_TIME)->getField('id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('GoodsCategory')->where("parent_id = $cat_id")->cache(true,TPSHOP_CACHE_TIME)->getField('id',true);
    foreach($son_id_arr as $k => $v)
    {
        getCatGrandson2($v);
    }
    return $GLOBALS['catGrandson'];
}

/**
 * 获取某个文章分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getArticleCatGrandson ($cat_id)
{
    $GLOBALS['ArticleCatGrandson'] = array();
    $GLOBALS['cat_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['cat_id_arr'] = M('ArticleCat')->getField('cat_id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('ArticleCat')->where("parent_id = $cat_id")->getField('cat_id',true);
    foreach($son_id_arr as $k => $v)
    {
        getArticleCatGrandson2($v);
    }
    return $GLOBALS['ArticleCatGrandson'];
}

/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getCatGrandson2($cat_id)
{
    $GLOBALS['catGrandson'][] = $cat_id;
    foreach($GLOBALS['category_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getCatGrandson2($k); // 继续找孙子
        }
    }
}


/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getArticleCatGrandson2($cat_id)
{
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    foreach($GLOBALS['cat_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getArticleCatGrandson2($k); // 继续找孙子
        }
    }
}

/**
 * 查看某个用户购物车中商品的数量
 * @param type $user_id
 * @param type $session_id
 * @return type 购买数量
 */
function cart_goods_num($user_id = 0,$session_id = '')
{
    $where = " session_id = '$session_id' ";
    $user_id && $where .= " or user_id = $user_id ";
    // 查找购物车数量
    $cart_count =  M('Cart')->where($where)->sum('goods_num');
    $cart_count = $cart_count ? $cart_count : 0;
    return $cart_count;
}

/**
 * 获取商品库存
 * @param type $goods_id 商品id
 * @param type $key  库存 key
 */
function getGoodNum($goods_id,$key)
{
    if(!empty($key))
        return  M("SpecGoodsPrice")->where("goods_id = $goods_id and `key` = '$key'")->getField('store_count');
    else
        return  M("Goods")->where("goods_id = $goods_id")->getField('store_count');
}
 
/**
 * 获取缓存或者更新缓存
 * @param string $config_key 缓存文件名称
 * @param array $data 缓存数据  array('k1'=>'v1','k2'=>'v3')
 * @return array or string or bool
 */
function tpCache($config_key,$data = array()){
    $param = explode('.', $config_key);
    if(empty($data)){
        //如$config_key=shop_info则获取网站信息数组
        //如$config_key=shop_info.logo则获取网站logo字符串
        $config = F($param[0],'',TEMP_PATH);//直接获取缓存文件
        if(empty($config)){
            //缓存文件不存在就读取数据库
            $res = D('config')->where("inc_type='$param[0]'")->select();
            if($res){
                foreach($res as $k=>$val){
                    $config[$val['name']] = $val['value'];
                }
                F($param[0],$config,TEMP_PATH);
            }
        }
        if(count($param)>1){
            return $config[$param[1]];
        }else{
            return $config;
        }
    }else{
        //更新缓存
        $result =  D('config')->where("inc_type='$param[0]'")->select();
        if($result){
            foreach($result as $val){
                $temp[$val['name']] = $val['value'];
            }
            foreach ($data as $k=>$v){
                $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                if(!isset($temp[$k])){
                    M('config')->add($newArr);//新key数据插入数据库
                }else{
                    if($v!=$temp[$k])
                        M('config')->where("name='$k'")->save($newArr);//缓存key存在且值有变更新此项
                }
            }
            //更新后的数据库记录
            $newRes = D('config')->where("inc_type='$param[0]'")->select();
            foreach ($newRes as $rs){
                $newData[$rs['name']] = $rs['value'];
            }
        }else{
            foreach($data as $k=>$v){
                $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
            }
            M('config')->addAll($newArr);
            $newData = $data;
        }
        return F($param[0],$newData,TEMP_PATH);
    }
}

/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $desc    变动说明
 * @param   float   distribut_money 分佣金额
 * @return  bool
 */
function accountLog($user_id, $user_money = 0,$pay_points = 0, $desc = '',$distribut_money = 0){
    /* 插入帐户变动记录 */
    $account_log = array(
        'user_id'       => $user_id,
        'user_money'    => $user_money,
        'pay_points'    => $pay_points,
        'change_time'   => time(),
        'desc'   => $desc,
    );
    /* 更新用户信息 */
    $sql = "UPDATE __PREFIX__users SET user_money = user_money + $user_money," .
        " pay_points = pay_points + $pay_points, distribut_money = distribut_money + $distribut_money WHERE user_id = $user_id";
    if( D('users')->execute($sql)){
    	M('account_log')->add($account_log);
        return true;
    }else{
        return false;
    }
}

/**
 * 订单操作日志
 * 参数示例
 * @param type $order_id  订单id
 * @param type $action_note 操作备注
 * @param type $status_desc 操作状态  提交订单, 付款成功, 取消, 等待收货, 完成
 * @param type $user_id  用户id 默认为管理员
 * @return boolean
 */
function logOrder($order_id,$action_note,$status_desc,$user_id = 0)
{
    $status_desc_arr = array('提交订单', '付款成功', '取消', '等待收货', '完成','退货');
    // if(!in_array($status_desc, $status_desc_arr))
    // return false;

    $order = M('order')->where("order_id = $order_id")->find();
    $action_info = array(
        'order_id'        =>$order_id,
        'action_user'     =>$user_id,
        'order_status'    =>$order['order_status'],
        'shipping_status' =>$order['shipping_status'],
        'pay_status'      =>$order['pay_status'],
        'action_note'     => $action_note,
        'status_desc'     =>$status_desc, //''
        'log_time'        =>time(),
    );
    return M('order_action')->add($action_info);
}

/*
 * 获取地区列表
 */
function get_region_list(){
    //获取地址列表 缓存读取
    if(!S('region_list')){
        $region_list = M('region')->select();
        $region_list = convert_arr_key($region_list,'id');        
        S('region_list',$region_list);
    }

    return $region_list ? $region_list : S('region_list');
}
/*
 * 获取用户地址列表
 */
function get_user_address_list($user_id){
    $lists = M('user_address')->where(array('user_id'=>$user_id))->select();
    return $lists;
}

/*
 * 获取指定地址信息
 */
function get_user_address_info($user_id,$address_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->find();
    return $data;
}
/*
 * 获取用户默认收货地址
 */
function get_user_default_address($user_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'is_default'=>1))->find();
    return $data;
}
/**
 * 获取订单状态的 中文描述名称
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return string
 */
function orderStatusDesc($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();

    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0)
            return 'WAITSEND'; //'待发货',
    }
    else // 非货到付款
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0)
            return 'WAITPAY'; //'待支付',
        if($order['pay_status'] == 1 &&  in_array($order['order_status'],array(0,1)) && $order['shipping_status'] != 1)
            return 'WAITSEND'; //'待发货',
    }
    if(($order['shipping_status'] == 1) && ($order['order_status'] == 1))
        return 'WAITRECEIVE'; //'待收货',
    if($order['order_status'] == 2)
        return 'WAITCCOMMENT'; //'待评价',
    if($order['order_status'] == 3)
        return 'CANCEL'; //'已取消',
    if($order['order_status'] == 4)
        return 'FINISH'; //'已完成',
    if($order['order_status'] == 5)
    	return 'CANCELLED'; //'已作废',
    return 'OTHER';
}

/**
 * 获取订单状态的 显示按钮
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return array()
 */
function orderBtn($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();
    /**
     *  订单用户端显示按钮
    去支付     AND pay_status=0 AND order_status=0 AND pay_code ! ="cod"
    取消按钮  AND pay_status=0 AND shipping_status=0 AND order_status=0
    确认收货  AND shipping_status=1 AND order_status=0
    评价      AND order_status=1
    查看物流  if(!empty(物流单号))
     */
    $btn_arr = array(
        'pay_btn' => 0, // 去支付按钮
        'cancel_btn' => 0, // 取消按钮
        'receive_btn' => 0, // 确认收货
        'comment_btn' => 0, // 评价按钮
        'shipping_btn' => 0, // 查看物流
        'return_btn' => 0, // 退货按钮 (联系客服)
    );


    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(($order['order_status']==0 || $order['order_status']==1) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['cancel_btn'] = 1; // 取消按钮 (联系客服)
        }
        if($order['shipping_status'] == 1 && $order['order_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }       
    }
    // 非货到付款
    else
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0) // 待支付
        {
            $btn_arr['pay_btn'] = 1; // 去支付按钮
            $btn_arr['cancel_btn'] = 1; // 取消按钮
        }
        if($order['pay_status'] == 1 && in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
        if($order['pay_status'] == 1 && $order['order_status'] == 1  && $order['shipping_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
    }
    if($order['order_status'] == 2)
    {
        $btn_arr['comment_btn'] = 1;  // 评价按钮
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    if($order['shipping_status'] != 0)
    {
        $btn_arr['shipping_btn'] = 1; // 查看物流
    }
    if($order['shipping_status'] == 2 && $order['order_status'] == 1) // 部分发货
    {            
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    
    return $btn_arr;
}

/**
 * 给订单数组添加属性  包括按钮显示属性 和 订单状态显示属性
 * @param type $order
 */
function set_btn_order_status($order)
{
    $order_status_arr = C('ORDER_STATUS_DESC');
    $order['order_status_code'] = $order_status_code = orderStatusDesc(0, $order); // 订单状态显示给用户看的
    $order['order_status_desc'] = $order_status_arr[$order_status_code];
    $orderBtnArr = orderBtn(0, $order);
    return array_merge($order,$orderBtnArr); // 订单该显示的按钮
}


/**
 * 支付完成修改订单
 * $order_sn 订单号
 * $pay_status 默认1 为已支付
 */
function update_pay_status($order_sn,$pay_status = 1)
{
	if(stripos($order_sn,'recharge') !== false){
		//用户在线充值
		$count = M('recharge')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
		if($count == 0) return false;
		$order = M('recharge')->where("order_sn = '$order_sn'")->find();
		M('recharge')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
		accountLog($order['user_id'],$order['account'],0,'会员在线充值');
	}else{
		// 如果这笔订单已经处理过了
		$count = M('order')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
		if($count == 0) return false;
		// 找出对应的订单
		$order = M('order')->where("order_sn = '$order_sn'")->find();
		// 修改支付状态  已支付
		M('order')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
		// 减少对应商品的库存
		minus_stock($order['order_id']);
		// 给他升级, 根据order表查看消费记录 给他会员等级升级 修改他的折扣 和 总金额
		update_user_level($order['user_id']);
		// 记录订单操作日志
		logOrder($order['order_id'],'订单付款成功','付款成功',$order['user_id']);
		//分销设置
		M('rebate_log')->where("order_id = {$order['order_id']}")->save(array('status'=>1));
		// 成为分销商条件
		$distribut_condition = tpCache('distribut.condition');
		if($distribut_condition == 1)  // 购买商品付款才可以成为分销商
			M('users')->where("user_id = {$order['user_id']}")->save(array('is_distribut'=>1));
	}

}

/*
 * 修改点餐订单支付状态
 * string@sys_id    订单中system_order_id
 * */
    function updateDishOrderStatus($sys_id){
        $model = M("dish_order");
        $re =$model->where(array('system_order_id'=>$sys_id))->getField('paid');
        if(!$re){
            $re = $model->where(array('system_order_id'=>$sys_id))->data(array('paid'=>1))->save();

        }
        if($re){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 订单确认收货
     * @param $id   订单id
     */
    function confirm_order($id,$user_id = 0){
        
        $where = "order_id = $id";
        $user_id && $where .= " and user_id = $user_id ";
        
        $order = M('order')->where($where)->find();
        if($order['order_status'] != 1)
            return array('status'=>-1,'msg'=>'该订单不能收货确认');
        
        $data['order_status'] = 2; // 已收货        
        $data['pay_status'] = 1; // 已付款        
        $data['confirm_time'] = time(); // 收货确认时间
        if($order['pay_code'] == 'cod'){
        	$data['pay_time'] = time();
        }
        $row = M('order')->where(array('order_id'=>$id))->save($data);
        if(!$row)        
            return array('status'=>-3,'msg'=>'操作失败');
        
        order_give($order);// 调用送礼物方法, 给下单这个人赠送相应的礼物
        
        //分销设置
        M('rebate_log')->where("order_id = $id")->save(array('status'=>2,'confirm'=>time()));
               
        return array('status'=>1,'msg'=>'操作成功');
    }

/**
 * 给订单送券送积分 送东西
 */
function order_give($order)
{
	$order_goods = M('order_goods')->where("order_id=".$order['order_id'])->cache(true)->select();
	//查找购买商品送优惠券活动
	foreach ($order_goods as $val)
    {
		if($val['prom_type'] == 3)
        {
			$prom = M('prom_goods')->where('type=3 and id='.$val['prom_id'])->find();
			if($prom){
				$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
				if($coupon && $coupon['createnum']>0){					                                        
                    $remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)                                            
                    {
                        $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                        M('coupon_list')->add($data);       
                        M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }
				}
		 	}
		 }
	}
	
	//查找订单满额送优惠券活动
	$pay_time = $order['pay_time'];
	$prom = M('prom_order')->where("type>1 and end_time>$pay_time and start_time<$pay_time and money<=".$order['order_amount'])->order('money desc')->find();
	if($prom){
		if($prom['type']==3){
			$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
			if($coupon){
				if($coupon['createnum']>0){
					$remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)
                    {
                       $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                       M('coupon_list')->add($data);           
                       M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }				
				}
			}
		}else if($prom['type']==2){
			accountLog($order['user_id'], 0 , $prom['expression'] ,"订单活动赠送积分");
		}
	}
    $points = M('order_goods')->where("order_id = {$order[order_id]}")->sum("give_integral * goods_num");
    $points && accountLog($order['user_id'], 0,$points,"下单赠送积分");
}


/**
 * 查看商品是否有活动
 * @param goods_id 商品ID
 */

function get_goods_promotion($goods_id,$user_id=0){
	$now = time();
	$goods = M('goods')->where("goods_id=$goods_id")->find();
	$where = "end_time>$now and start_time<$now and id=".$goods['prom_id'];
	
	$prom['price'] = $goods['shop_price'];
	$prom['prom_type'] = $goods['prom_type'];
	$prom['prom_id'] = $goods['prom_id'];
	$prom['is_end'] = 0;
	
	if($goods['prom_type'] == 1){//抢购
		$prominfo = M('flash_sale')->where($where)->find();
		if(!empty($prominfo)){
			if($prominfo['goods_num'] == $prominfo['buy_num']){
				$prom['is_end'] = 2;//已售馨
			}else{
				//核查用户购买数量
				$where = "user_id = $user_id and order_status!=3 and  add_time>".$prominfo['start_time']." and add_time<".$prominfo['end_time'];
				$order_id_arr = M('order')->where($where)->getField('order_id',true);
				if($order_id_arr){
					$goods_num = M('order_goods')->where("prom_id={$goods['prom_id']} and prom_type={$goods['prom_type']} and order_id in (".implode(',', $order_id_arr).")")->sum('goods_num');
					if($goods_num < $prominfo['buy_limit']){
						$prom['price'] = $prominfo['price'];
					}
				}else{
					$prom['price'] = $prominfo['price'];
				}
			} 				
		}
	}
	
	if($goods['prom_type']==2){//团购
		$prominfo = M('group_buy')->where($where)->find();
		if(!empty($prominfo)){			
			if($prominfo['goods_num'] == $prominfo['buy_num']){
				$prom['is_end'] = 2;//已售馨
			}else{
				$prom['price'] = $prominfo['price'];
			}				
		}
	}
	if($goods['prom_type'] == 3){//优惠促销
		$parse_type = array('0'=>'直接打折','1'=>'减价优惠','2'=>'固定金额出售','3'=>'买就赠优惠券','4'=>'买M件送N件');
		$prominfo = M('prom_goods')->where($where)->find();
		if(!empty($prominfo)){
			if($prominfo['type'] == 0){
				$prom['price'] = $goods['shop_price']*$prominfo['expression']/100;//打折优惠
			}elseif($prominfo['type'] == 1){
				$prom['price'] = $goods['shop_price']-$prominfo['expression'];//减价优惠
			}elseif($prominfo['type']==2){
				$prom['price'] = $prominfo['expression'];//固定金额优惠
			}
		}
	}
	
	if(!empty($prominfo)){
		$prom['start_time'] = $prominfo['start_time'];
		$prom['end_time'] = $prominfo['end_time'];
	}else{
		$prom['prom_type'] = $prom['prom_id'] = 0 ;//活动已过期
		$prom['is_end'] = 1;//已结束
	}
	
	if($prom['prom_id'] == 0){
		M('goods')->where("goods_id=$goods_id")->save($prom);
	}
	return $prom;
}

/**
 * 查看订单是否满足条件参加活动
 * @param order_amount 订单应付金额
 */
function get_order_promotion($order_amount){
	$parse_type = array('0'=>'满额打折','1'=>'满额优惠金额','2'=>'满额送倍数积分','3'=>'满额送优惠券','4'=>'满额免运费');
	$now = time();
	$prom = M('prom_order')->where("type<2 and end_time>$now and start_time<$now and money<=$order_amount")->order('money desc')->find();
	$res = array('order_amount'=>$order_amount,'order_prom_id'=>0,'order_prom_amount'=>0);
	if($prom){
		if($prom['type'] == 0){
			$res['order_amount']  = round($order_amount*$prom['expression']/100,2);//满额打折
			$res['order_prom_amount'] = $order_amount - $res['order_amount'] ;
			$res['order_prom_id'] = $prom['id'];
		}elseif($prom['type'] == 1){
			$res['order_amount'] = $order_amount- $prom['expression'];//满额优惠金额
			$res['order_prom_amount'] = $prom['expression'];
			$res['order_prom_id'] = $prom['id'];
		}
	}
	return $res;		
}

/**
 * 计算订单金额
 * @param type $user_id  用户id
 * @param type $order_goods  购买的商品
 * @param type $shipping  物流code
 * @param type $shipping_price 物流费用, 如果传递了物流费用 就不在计算物流费
 * @param type $province  省份
 * @param type $city 城市
 * @param type $district 县
 * @param type $pay_points 积分
 * @param type $user_money 余额
 * @param type $coupon_id  优惠券
 * @param type $couponCode  优惠码
 */
 
function calculate_price($user_id=0,$order_goods,$shipping_code='',$shipping_price=0,$province=0,$city=0,$district=0,$pay_points=0,$user_money=0,$coupon_id=0,$couponCode='')
{    
    $cartLogic = new \Home\Logic\CartLogic();               
    $user = M('users')->where("user_id = $user_id")->find();// 找出这个用户
    
    if(empty($order_goods)) 
        return array('status'=>-9,'msg'=>'商品列表不能为空','result'=>'');  
    
    $goods_id_arr = get_arr_column($order_goods,'goods_id');
    $goods_arr = M('goods')->where("goods_id in(".  implode(',',$goods_id_arr).")")->getField('goods_id,weight,market_price,is_free_shipping'); // 商品id 和重量对应的键值对
    
        foreach($order_goods as $key => $val)
        {       
            // 如果传递过来的商品列表没有定义会员价
            if(!array_key_exists('member_goods_price',$val))  
            {
                $user['discount'] = $user['discount'] ? $user['discount'] : 1; // 会员折扣 不能为 0
                $order_goods[$key]['member_goods_price'] = $val['member_goods_price'] = $val['goods_price'] * $user['discount'];
            }
			//如果商品不是包邮的
            if($goods_arr[$val['goods_id']]['is_free_shipping'] == 0)
	            $goods_weight += $goods_arr[$val['goods_id']]['weight'] * $val['goods_num']; //累积商品重量 每种商品的重量 * 数量
				
            $order_goods[$key]['goods_fee'] = $val['goods_num'] * $val['member_goods_price'];    // 小计            
            $order_goods[$key]['store_count']  = getGoodNum($val['goods_id'],$val['spec_key']); // 最多可购买的库存数量
            if($order_goods[$key]['store_count'] <= 0) 
                return array('status'=>-10,'msg'=>$order_goods[$key]['goods_name']."库存不足,请重新下单",'result'=>'');  
            
            $goods_price += $order_goods[$key]['goods_fee']; // 商品总价
            $cut_fee     += $val['goods_num'] * $val['market_price'] - $val['goods_num'] * $val['member_goods_price']; // 共节约
            $anum        += $val['goods_num']; // 购买数量
        }        
        
        // 优惠券处理操作
        $coupon_price = 0;
        if($coupon_id && $user_id)
        {
            $coupon_price = $cartLogic->getCouponMoney($user_id, $coupon_id,1); // 下拉框方式选择优惠券                    
        }        
        if($couponCode && $user_id)
        {                 
             $coupon_result = $cartLogic->getCouponMoneyByCode($couponCode,$goods_price); // 根据 优惠券 号码获取的优惠券             
             if($coupon_result['status'] < 0) 
               return $coupon_result;
             $coupon_price = $coupon_result['result'];            
        }
        // 处理物流
        if($shipping_price == 0)
        {
            $shipping_price = $cartLogic->cart_freight2($shipping_code,$province,$city,$district,$goods_weight);        
            $freight_free = tpCache('shopping.freight_free'); // 全场满多少免运费
            if($freight_free > 0 && $goods_price >= $freight_free)
               $shipping_price = 0;               
        }
        
        if($pay_points && ($pay_points > $user['pay_points']))
            return array('status'=>-5,'msg'=>"你的账户可用积分为:".$user['pay_points'],'result'=>''); // 返回结果状态                
        if($user_money  && ($user_money > $user['user_money']))
            return array('status'=>-6,'msg'=>"你的账户可用余额为:".$user['user_money'],'result'=>''); // 返回结果状态

       $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券
       
       $pay_points = ($pay_points / tpCache('shopping.point_rate')); // 积分支付 100 积分等于 1块钱                              
       $pay_points = ($pay_points > $order_amount) ? $order_amount : $pay_points; // 假设应付 1块钱 而用户输入了 200 积分 2块钱, 那么就让 $pay_points = 1块钱 等同于强制让用户输入1块钱               
       $order_amount = $order_amount - $pay_points; //  积分抵消应付金额       
      
       $user_money = ($user_money > $order_amount) ? $order_amount : $user_money;  // 余额支付原理等同于积分
       $order_amount = $order_amount - $user_money; //  余额支付抵应付金额
      
       $total_amount = $goods_price + $shipping_price;
           //订单总价  应付金额  物流费  商品总价 节约金额 共多少件商品 积分  余额  优惠券
        $result = array(
            'total_amount'      => $total_amount, // 商品总价
            'order_amount'      => $order_amount, // 应付金额
            'shipping_price'    => $shipping_price, // 物流费
            'goods_price'       => $goods_price, // 商品总价
            'cut_fee'           => $cut_fee, // 共节约多少钱
            'anum'              => $anum, // 商品总共数量
            'integral_money'    => $pay_points,  // 积分抵消金额
            'user_money'        => $user_money, // 使用余额
            'coupon_price'      => $coupon_price,// 优惠券抵消金额
            'order_goods'       => $order_goods, // 商品列表 多加几个字段原样返回
        );        
    return array('status'=>1,'msg'=>"计算价钱成功",'result'=>$result); // 返回结果状态
}

/**
 * 获取商品一二三级分类
 * @return type
 */
function get_goods_category_tree(){
	$result = array();
	$cat_list = M('goods_category')->where("is_show = 1")->order('sort_order')->cache(true)->select();//所有分类
	
	foreach ($cat_list as $val){
		if($val['level'] == 2){
			$arr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 3){
			$crr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 1){
			$tree[] = $val;
		}
	}

	foreach ($arr as $k=>$v){
		foreach ($v as $kk=>$vv){
			$arr[$k][$kk]['sub_menu'] = empty($crr[$vv['id']]) ? array() : $crr[$vv['id']];
		}
	}
	
	foreach ($tree as $val){
		$val['tmenu'] = empty($arr[$val['id']]) ? array() : $arr[$val['id']];
		$result[$val['id']] = $val;
	}
	return $result;
}


