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


class TipsController extends BaseController {

 public function index()
 {
	if ($_POST) {
	    $data = $_POST;
	    $res = M('tips')->where('id=1')->save($data);
	    if ($res!==false) {
	    	$this->success('修改成功');
	    }else{
	    	$this->error('修改失败');
	    }
	    exit;
	}
	$info = M('tips')->find();
	$this->assign('info',$info);
    $this->display();
 }

}