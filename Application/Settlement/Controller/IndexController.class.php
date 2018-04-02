<?php
/**
 *
 * ============================================================================
 * * 版权所有 2015-2027 北京易启东方网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.shop.yiqidongfang.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 2016-01-09
 */ 
namespace Mobile\Controller;
class IndexController extends MobileBaseController
{

    public function index()
    {
        /*
            //获取微信配置
            $wechat_list = M('wx_user')->select();
            $wechat_config = $wechat_list[0];
            $this->weixin_config = $wechat_config;        
            // 微信Jssdk 操作类 用分享朋友圈 JS            
            $jssdk = new \Mobile\Logic\Jssdk($this->weixin_config['appid'], $this->weixin_config['appsecret']);
            $signPackage = $jssdk->GetSignPackage();              
            print_r($signPackage);
        */
        $title = '商业用户个人中心';

        $this->display();
    }




///////////////////////////////////////////
}
