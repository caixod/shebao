<?php
    //通过dish_id来获取排序Id
    function getSortId($dish_id=148){
        $dish = M("dish")
                //->cache(3600)
                ->field("sort_id,status")
                ->where(array('is_del'=>0,'status'=>1,'id'=>$dish_id))
                ->find();
        return $dish['sort_id'];
    }

    //通过dish_id返回当前菜品信息
    function getDishInfo($dish_id=0){
        $dish_info = M("Dish")
                    ->where(array("id"=>$dish_id))
                    ->find();
        return $dish_info;
    }

    //返回计量单位unit
    function getUnit($unit_id=0){
        $unit_name = M("dish_unit")
            //->cache(3600)
            ->where(array("id"=>$unit_id))->getField('name');
        return $unit_name;
    }

    //返回规格名
    /*@param int $s_id 规格id
     * */
    function getStandardName($s_id){
        $re = M("dish_standard")->where(array('id'=>$s_id))->getField('name');
        if($re){
            return $re;
        }else{
            return '标准';
        }

    }

    //出库价格格式化显示 price/100
    function priceFormat($price){
        return ($price/100);
    }

//价格入库操作乘100
function formatPriceInsertToDb($price){
    return $price*100;
}

//通过sort_id来返回分类信息
function getSortInfo($sort_id){
    $sort_info = M("dish_sort")->where(array('id'=>$sort_id,'status'=>1,'is_del'=>0,'_logic'=>'AND'))->find();
    return $sort_info;
}

    //返回当前店铺当前菜品有几个大小份
    function getStandardList($dish_id=0){
        //查看当前菜品在当前店铺有没有开启大小份
        //$is_standard_on = M("dish_to_store_restaurant")->where(array("store_id"=>$store_id,"dish_id"=>$dish_id,"restaurant_id"=>$restaurant_id,"status"=>1,"_logic"=>"AND"))->find();
        //拿取standard
        $standard_list = M("dish_standard")
            //->cache(3600)
            ->alias("a")
            ->field("a.id,a.name,b.dish_id,b.price")
            ->join("tp_dish_standard_price as b ON a.id=b.standard_id","right")
            ->select();
        $arr = array();
        foreach($standard_list as $k => $v){
            if($v['dish_id'] == $dish_id){
                //$arr[$dish_id][] = $v['name'];
                $arr[$v['id']] = array('name'=>$v['name'],'price'=>priceFormat($v['price']));
            }
        }
        return $arr;
    }

   //返回是否推荐
    function isHot($dish_id=0){

    }

    //总店控制开启大小份版本；根据菜品Id返回当前菜品各各种标准价格，如果没有开启规格可选返回基础菜品价格
    function getSandardPriceForConsole($dish_id=0,$standard_id=0,$store_id=0,$restaurant_id=0){
        $find = M("dish_to_store_restaurant")->where(array('dish_id'=>$dish_id,'store_id'=>$store_id,'restaurant_id'=>$restaurant_id))->find();
        if($find['standard_on_off']){//如果开启了大小份
            $standard_price = M("dish_standard_price")->where(array("dish_id"=>$dish_id,"standard_id"=>$standard_id))->getField("price");
        }
        $price = $standard_price?$standard_price:$find['price'];
        return $price;
    }
 

    //处理带小数点的钱，拼接成整数字符串
    /*float || string @money
        int@return
     * */
    function formatFloat($money){
        if(strpos($money,'.')){
            $money = explode('.',$money);
            $money = $money[0].$money[1];
        }else{
            $money = $money*100;
        }

        return $money;
    }

    //通过store_id获取店铺信息
    function getStoreInfo($store_id){
        $re = M("store")->where(array('id'=>$store_id))->find();
        return $re;
    }
    //通过id store_id获取子菜品
    function getOrdersItem($id,$store_id){
        $re = M("dish_order_info")->where(array('order_id'=>$id,'store_id'=>$store_id))->select();
        return $re;
    }

    //点餐订单类型定义
    function getDishOrderStepType($a){
        $arr = array(
            'waiting_pay'=>1,   //待支付订单
            'waiting_take'=>2, //待取餐订单
            'dish_done'=>3, //已完成订单
            'refund'=>4 //退款订单
        );
        return $arr[$a];
    }