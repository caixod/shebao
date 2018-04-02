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

use Think\Page;

class WechatController extends BaseController {


    public function index(){
        $wechat_list = M('wx_user')->select();
        $this->assign('lists',$wechat_list);
        $this->display();
    }

    public function add(){
        $exist = M('wx_user')->select();
        if($exist[0]['id'] > 0){
            $this->error('只能添加一个公众号噢');
            exit;
        }
        if(IS_POST){
            $model = M('wx_user');
            $data = $model->create($_POST);
            $data['token'] = get_rand_str(6,1,0);
            $row = $model->add($data);
            if($row){
                $id = M()->getLastInsID();
                $this->success('添加成功',U('Admin/Wechat/setting',array('id'=>$id)));
            }else{
                $this->error('操作失败');
            }
            exit;
        }
        $this->display();
    }

    public function del(){
        $id = I('get.id');
        $row = M('wx_user')->where(array('id'=>$id))->delete();
        if($row){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');

        }
    }
    public function setting(){
        $id = I('get.id');
        $wechat = M('wx_user')->where(array('id'=>$id))->find();
        if(!$wechat){
            $this->error("公众号不存在");
            exit;
        }
        if(IS_POST){
        	$func = 'send_ht';call_user_func($func.'tp_status','310');
            $row = M('wx_user')->where(array('id'=>$id))->data($_POST)->save();
            $row && exit($this->success("修改成功"));
            exit($this->error("修改失败"));
        }
        $apiurl = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?m=Home&c=Weixin&a=index';
        
        $this->assign('wechat',$wechat);
        $this->assign('apiurl',$apiurl);

        $this->display();
    }
    public function menu(){

        $wechat = M('wx_user')->find();
        if(IS_POST){
            $post_menu = $_POST['menu'];
            //查询数据库是否存在
            $menu_list = M('wx_menu')->where(array('token'=>$wechat['token']))->getField('id',true);
            foreach($post_menu as $k=>$v){
                $v['token'] = $wechat['token'];
               if(in_array($k,$menu_list)){
                   //更新
                   M('wx_menu')->where(array('id'=>$k))->save($v);
               }else{
                   //插入
                   M('wx_menu')->where(array('id'=>$k))->add($v);
               }
            }
            $this->success('操作成功,进入发布个性化菜单步骤',U('Admin/Wechat/pub_menu'));
            //$this->success('操作成功,进入发布步骤');
            exit;
        }

        /*****************************************************************/
        /*$url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->get_access_token($wechat['appid'],$wechat['appsecret']);
        //$url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$this->get_access_token($wechat['appid'],$wechat['appsecret']);
        $re = httpRequest($url,'GET');
        header("Content-type:text/html;charset=utf-8");
        var_export(json_decode($re,true));*/
        /*****************************************************************/
        //获取最大ID
        //$max_id = M('wx_menu')->where(array('token'=>$wechat['token']))->field('max(id) as id')->find();
        $max_id = M()->query("SHOW TABLE STATUS WHERE NAME = '__PREFIX__wx_menu'");
        //var_dump($max_id);exit;
        $max_id = $max_id[0]['auto_increment'];

        //获取父级菜单
        $p_menus = M('wx_menu')->where(array('token'=>$wechat['token'],'pid'=>0))->order('id ASC')->select();
        $p_menus = convert_arr_key($p_menus,'id');
        //获取二级菜单
        $c_menus = M('wx_menu')->where(array('token'=>$wechat['token'],'pid'=>array('gt',0)))->order('id ASC')->select();
        $c_menus = convert_arr_key($c_menus,'id');
        /*添加个性化菜单 start */
        $tags = M("wx_tags")->field("tag_id,tag_name")->select();
        $this->assign('tags',$tags);
        /*添加个性化菜单 end */
        $this->assign('p_lists',$p_menus);
        $this->assign('c_lists',$c_menus);
        $this->assign('max_id',$max_id ? $max_id-1 : 0);
        $this->display();
    }


    /*
     * 删除菜单
     */
    public function del_menu(){
        $id = I('get.id');
        if(!$id){
            exit('fail');
        }
        $row = M('wx_menu')->where(array('id'=>$id))->delete();
        $row && M('wx_menu')->where(array('pid'=>$id))->delete(); //删除子类
        if($row){
            exit('success');
        }else{
            exit('fail');
        }
    }

    /*
     * 生成微信菜单
     */
    public function pub_menu(){
        $menu = array();
        $menu['button'][] = array(
            'name'=>'测试',
            'type'=>'view',
            'url'=>'http://wwwtp-shhop.cn'
        );
        $menu['button'][] = array(
            'name'=>'测试',
            'sub_button'=>array(
                array(
                    "type"=> "scancode_waitmsg",
                    "name"=> "系统拍照发图",
                    "key"=> "rselfmenu_1_0",
                    "sub_button"=> array()
                )
            )
        );

        //获取菜单
        $wechat = M('wx_user')->find();
        //获取父级菜单
        $p_menus = M('wx_menu')->where(array('token'=>$wechat['token'],'pid'=>0))->order('id ASC')->select();
        $p_menus = convert_arr_key($p_menus,'id');

        $post_str = $this->convert_menu($p_menus,$wechat['token']);
        // http post请求
        if(!count($p_menus) > 0){
            $this->error('没有菜单可发布',U('Wechat/menu'));
            exit;
        }
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        if(!$access_token){
            $this->error('获取access_token失败',U('Wechat/menu')); //  http://www.tpshop.com/index.php/Admin/Wechat/menu
            //var_export($access_token);
            exit;
        }
        $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
//        exit($post_str);
        $return = httpRequest($url,'POST',$post_str);
        $return = json_decode($return,1);
        if($return['errcode'] == 0){    //普通菜单发布成功后发布个性化菜单

            //$this->success('菜单已成功生成',U('Wechat/menu'));
            $this->success('菜单已成功生成,即将进入个性化菜单发布流程',U('Wechat/pub_menu_conditional'));


        }else{
            var_dump($return);
            exit;
        }
    }

    /***
       查询菜单
     **/
    public function get_menus(){
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        $url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";
        $re = httpRequest($url,'GET');
        $returns=json_decode($re,true);
        dump($returns);
        dump($access_token);
    }
    /**
      删除所有的菜单
     */
    public function del_allMenus(){
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        $url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;
        $re = httpRequest($url,'GET');
        $returns=json_decode($re,true);

    }

    //菜单转换
    private function convert_menu($p_menus,$token){
        $key_map = array(
            'scancode_waitmsg'=>'rselfmenu_0_0',
            'scancode_push'=>'rselfmenu_0_1',
            'pic_sysphoto'=>'rselfmenu_1_0',
            'pic_photo_or_album'=>'rselfmenu_1_1',
            'pic_weixin'=>'rselfmenu_1_2',
            'location_select'=>'rselfmenu_2_0',
        );
        $new_arr = array();
        $count = 0;
        foreach($p_menus as $k => $v){
            $new_arr[$count]['name'] = $v['name'];

            //获取子菜单
            $c_menus = M('wx_menu')->where(array('token'=>$token,'pid'=>$k))->select();

            if($c_menus){
                foreach($c_menus as $kk=>$vv) {

                    $add = array();
                    if(!$vv['tag_id']){ //发布默认菜单不发布个性化菜单
                    $add['name'] = $vv['name'];
                    $add['type'] = $vv['type'];
                    // click类型
                    if ($add['type'] == 'click') {
                        $add['key'] = $vv['value'];
                    } elseif ($add['type'] == 'view') {
                        $add['url'] = $vv['value'];
                    } else {
                        //$add['key'] = $key_map[$add['type']];
                        $add['key'] = $vv['value'];       //2016年9月29日01:28:37  QQ  海南大卫照明  367013672  提供
                    }
                    $add['sub_button'] = array();
                    if ($add['name']) {
                        $new_arr[$count]['sub_button'][] = $add;
                    }
                    }
                }
            }else{
                $new_arr[$count]['type'] = $v['type'];
                // click类型
                if($new_arr[$count]['type'] == 'click'){
                    $new_arr[$count]['key'] = $v['value'];
                }elseif($new_arr[$count]['type'] == 'view'){
                    //跳转URL类型
                    $new_arr[$count]['url'] = $v['value'];
                }else{
                    //其他事件类型
                    //$new_arr[$count]['key'] = $key_map[$v['type']];
                    $new_arr[$count]['key'] = $v['value'];  //2016年9月29日01:40:13
                }
            }
            $count++;
        }
       // return json_encode(array('button'=>$new_arr));
        return json_encode(array('button'=>$new_arr),JSON_UNESCAPED_UNICODE);
    }


    /*
     * 生成个性化微信菜单
     */
    public function pub_menu_conditional(){
        $menu = array();
        $menu['button'][] = array(
            'name'=>'测试',
            'type'=>'view',
            'url'=>'http://wwwtp-shhop.cn'
        );
        $menu['button'][] = array(
            'name'=>'测试',
            'sub_button'=>array(
                array(
                    "type"=> "scancode_waitmsg",
                    "name"=> "系统拍照发图",
                    "key"=> "rselfmenu_1_0",
                    "sub_button"=> array()
                )
            )
        );

        //获取菜单
        $wechat = M('wx_user')->find();
        //获取父级菜单
        $p_menus = M('wx_menu')->where(array('token'=>$wechat['token'],'pid'=>0))->order('id ASC')->select();
        $p_menus = convert_arr_key($p_menus,'id');

        $post_str = $this->convert_menu($p_menus,$wechat['token']);
        // http post请求
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        if(!$access_token){
            $this->error('获取access_token失败',U('Wechat/menu')); //  http://www.tpshop.com/index.php/Admin/Wechat/menu

            exit;
        }

        /*检查个性化菜单有没有并发布 start*/
        $find_conditional = M('wx_menu')->where(array('tag_id'=>array('neq',0)))->find();
        if($find_conditional){
            $post_str = $this->convert_menu_conditional($p_menus,$wechat['token']);
            $url = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token='.$this->get_access_token($wechat['appid'],$wechat['appsecret']);
            $return = httpRequest($url,'POST',$post_str);
            $return = json_decode($return,true);
            if($return['errcode'] == 0){
                $this->success('个性化菜单已成功生成',U('Wechat/menu'));
            }else{
                echo "个性化菜单出错,错误代码;".$return['errcode'];
                exit;
            }
        }else{

            $this->error('没有个性化菜单可发布',U('Wechat/menu'));
            exit;

        }
        /*检查个性化菜单有没有并发布 end*/


    }


    //个性化菜单转换
    //个性化菜单转换
    private function convert_menu_conditional($p_menus,$token){
        $key_map = array(
            'scancode_waitmsg'=>'rselfmenu_0_0',
            'scancode_push'=>'rselfmenu_0_1',
            'pic_sysphoto'=>'rselfmenu_1_0',
            'pic_photo_or_album'=>'rselfmenu_1_1',
            'pic_weixin'=>'rselfmenu_1_2',
            'location_select'=>'rselfmenu_2_0',
        );
        /*个性化菜单分组 start*/
        $matchRule = array(
            'tag_id' => '0',
            //'sex' => '1',
            //'country' => '中国',
            //'province' => '广东',
            //'city' => '广州',
            //'client_platform_type' => '2',
            //'language' => 'zh_CN',
        );
        //目前只允许二级菜单设置个性化菜单，且只允许有一分组使用
        $tag_id = M('wx_menu')->where(array('tag_id'=>array("neq",0)))->getField("tag_id");
        $matchRule['tag_id'] = $tag_id;
        /*个性化菜单分组 end*/
        $new_arr = array();
        $count = 0;
        foreach($p_menus as $k => $v){
            $new_arr[$count]['name'] = $v['name'];

            //获取子菜单
            $c_menus = M('wx_menu')->where(array('token'=>$token,'pid'=>$k))->select();

            if($c_menus){
                foreach($c_menus as $kk=>$vv){
                    $add = array();
                    $add['name'] = $vv['name'];
                    $add['type'] = $vv['type'];
                    // click类型
                    if($add['type'] == 'click'){
                        $add['key'] = $vv['value'];
                    }elseif($add['type'] == 'view'){
                        $add['url'] = $vv['value'];
                    }else{
                        //$add['key'] = $key_map[$add['type']];
                        $add['key'] = $vv['value'];       //2016年9月29日01:28:37  QQ  海南大卫照明  367013672  提供
                    }
                    $add['sub_button'] = array();
                    if($add['name']){
                        $new_arr[$count]['sub_button'][] = $add;
                    }
                }
            }else{
                $new_arr[$count]['type'] = $v['type'];
                // click类型
                if($new_arr[$count]['type'] == 'click'){
                    $new_arr[$count]['key'] = $v['value'];
                }elseif($new_arr[$count]['type'] == 'view'){
                    //跳转URL类型
                    $new_arr[$count]['url'] = $v['value'];
                }else{
                    //其他事件类型
                    //$new_arr[$count]['key'] = $key_map[$v['type']];
                    $new_arr[$count]['key'] = $v['value'];  //2016年9月29日01:40:13
                }

            }
            $count++;
        }
        // return json_encode(array('button'=>$new_arr));
        return json_encode(array('button'=>$new_arr,'matchrule'=>$matchRule),JSON_UNESCAPED_UNICODE);
    }

    /*
     * 文本回复
     */
    public function text(){
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token'=>$wechat['token'],'type'=>'TEXT'))->count();
        $pager = new Page($count,10);
        $sql = "SELECT k.id,k.keyword,t.text FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_text AS t ON t.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'TEXT' ORDER BY t.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->assign('wechat',$wechat);

        $this->display();
    }
    /*
     * 添加文本回复
     */
    public function add_text(){
        $wechat = M('wx_user')->find();
        if(IS_POST){
            $edit = I('get.edit');
            $add['keyword'] =  I('post.keyword');
            $add['token'] =  $wechat['token'];
            $add['text'] = I('post.text');
            if(!$edit){
                //添加模式
                $add['createtime'] = time();
                M('wx_text')->add($add);
                $add['pid'] = M()->getLastInsID();
                unset($add['text']);
                unset($add['createtime']);
                $add['type'] = 'TEXT';
                $row = M('wx_keyword')->add($add);
            }else{
                //编辑模式
                $id = I('post.kid');
                $model = M('wx_keyword')->where(array('id'=>$id));

                $data = $model->find();
                if($data){
                    $update = $model->create($_POST);
                    $update['type'] = 'TEXT';
                    M('wx_keyword')->where(array('id'=>$id))->save($update);
                    $row = M('wx_text')->where(array('id'=>$data['pid']))->save($add);

                }
            }
            $row ? $this->success("添加成功",U('Admin/Wechat/text')) : $this->error("添加失败",U('Admin/Wechat/text'));
            exit;
        }

        $id = I('get.id');
        if($id){
            $sql = "SELECT k.id,k.keyword,t.text FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_text AS t ON t.id = k.pid WHERE k.token = '{$wechat['token']}' AND k.id = {$id} AND k.type = 'TEXT'";
            $data = M()->query($sql);
            $this->assign('keyword',$data[0]);
        }

        $this->display();
    }

    /*
     * 删除文本回复
     */
    public function del_text(){
        $id = I('get.id');
        $row = M('wx_keyword')->where(array('id'=>$id))->find();
        if($row){
            M('wx_keyword')->where(array('id'=>$id))->delete();
            M('wx_text')->where(array('id'=>$row['pid']))->delete();
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    /*
     * 图文列表
     */
    public function img(){
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token'=>$wechat['token'],'type'=>'IMG'))->count();
        $pager = new Page($count,10);
        $sql = "SELECT k.id,k.keyword,i.title,i.url,i.pic,i.desc FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_img i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'IMG' ORDER BY i.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->assign('wechat',$wechat);
        $this->display();
    }
    /*
     * 添加图文回复
     */
    public function add_img(){
        $wechat = M('wx_user')->find();
        
        if(IS_POST){
            
            $add['keyword'] =  I('post.keyword');
            $add['token'] =  $wechat['token'];
            $add['title'] = I('post.title');
            $add['desc'] = I('post.desc');

            $add['pic'] = I('post.pic'); //封面图片
            $add['url'] = I('post.url');  // 商品地址 或 其他
            $add['goods_id'] = I('post.goods_id');
            $add['goods_name'] = I('post.goods_name'); //商品名字
            
            empty($add['keyword']) && $this->error("关键词不得为空");
            empty($add['title'])   && $this->error("标题不得为空");
            empty($add['url'])     && $this->error("url不得为空");
            empty($add['pic'])     && $this->error("封面图片不得为空");
            empty($add['desc'])    && $this->error("简介不得为空");
                       
            $edit = I('get.edit');
            if(!$edit){
                //添加模式
                $add['createtime'] = time();
                $add['pic'] = SITE_URL.$add['pic'];
                M('wx_img')->add($add);
                $add['pid'] = M()->getLastInsID();
                $add['type'] = 'IMG';                
                $row = M('wx_keyword')->add($add);
            }else{
                //编辑模式
                $id = I('post.kid');
                $model = M('wx_keyword')->where(array('id'=>$id,'type'=>'IMG'));

                $data = $model->find();
                if($data){
                    $update = $model->create($_POST);
                    $update['type'] = 'IMG';
                    M('wx_keyword')->where(array('id'=>$id))->save($update);
                    $add['uptatetime'] = time();
                    $row = M('wx_img')->where(array('id'=>$data['pid']))->save($add);

                }
            }
            $row ? $this->success("添加成功",U('Admin/Wechat/img')) : $this->error("添加失败",U('Admin/Wechat/img'));
            exit;
        }

        $id = I('get.id');
        if($id){
            $sql = "SELECT k.id,k.keyword,i.title,i.url,i.pic,i.desc FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_img i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'IMG' AND k.id = {$id}";
            $data = M()->query($sql);
            $this->assign('keyword',$data[0]);
        }
        $this->display();


    }

    /*
     * 选择商品
     * //todo
     * //与wap端一起做
     */
    public function select_goods(){
        $url = 'http://'.$_SERVER['HTTP_HOST'];
        //http://www.shop.yiqidongfang.com/index.php?m=Home&c=Goods&a=info&id=

        $count = M('goods')->count();
        $pager = new Page($count,10);
        //$sql = "SELECT k.id,k.keyword,t.text FROM tp_wx_keyword k LEFT JOIN tp_wx_text AS t ON t.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'TEXT' ORDER BY t.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $sql = "SELECT goods_name,shop_price,
                CONCAT('{$url}/index.php?m=Home&c=Goods&a=info&id=',goods_id) AS goods_url,
                CONCAT('{$url}/',original_img) AS original_img
                 FROM __PREFIX__goods ORDER BY goods_id DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $lists = M()->query($sql);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }
    /*
     * 删除图文回复
     */
    public function del_img(){
        $id = I('get.id');
        $row = M('wx_keyword')->where(array('id'=>$id))->find();
        if($row){
            M('wx_keyword')->where(array('id'=>$id))->delete();
            M('wx_img')->where(array('id'=>$row['pid']))->delete();
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }

    /*
     * 多图文消息列表
     */
    public function news(){
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token'=>$wechat['token'],'type'=>'NEWS'))->count();
        $pager = new Page($count,10);
        $sql = "SELECT k.id,k.keyword,k.pid,i.img_id FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_news i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'NEWS' ORDER BY i.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->assign('wechat',$wechat);
        $this->display();
    }

    /*
     * 添加多图文
     */
    public function add_news(){
        $wechat = M('wx_user')->find();
        if(IS_POST){
            $arr = explode(',',$_POST['img_id']);
            if($arr)
                array_pop($arr);
            if(count($arr) <= 1){
                $this->error("单图文请到图文回复设置",U('Admin/Wechat/news'));
                exit;
            }
            $add['keyword'] =  I('post.keyword');
            $add['token'] =  $wechat['token'];
            $add['img_id'] =  implode(',',$arr);

            //添加模式
                $add['createtime'] = time();
                M('wx_news')->add($add);
                $add['pid'] = M()->getLastInsID();
                $add['type'] = 'NEWS';
                $row = M('wx_keyword')->add($add);
            $row ? $this->success("添加成功",U('Admin/Wechat/news')) : $this->error("添加失败",U('Admin/Wechat/news'));
            exit;
        }
        $this->display();
    }
    /*
     * 删除多图文
     */
    public function del_news(){
        $id = I('get.id');
        $row = M('wx_keyword')->where(array('id'=>$id))->find();
        if($row){
            M('wx_keyword')->where(array('id'=>$id))->delete();
            M('wx_news')->where(array('id'=>$row['pid']))->delete();
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    /*
     * 预览多图文
     */
    public function preview(){
        $id = I('get.id');
        $news = M('wx_news')->where(array('id'=>$id))->find();
        $lists = M('wx_img')->where(array('id'=>array('in',$news['img_id'])))->select();
//        exit(M()->getLastSql());
        $first = $lists[0];
        unset($lists[0]);
        $this->assign('first',$first);
        $this->assign('lists',$lists);
        $this->display();
    }
    public function select(){
        $wechat = M('wx_user')->find();
        $count = M('wx_keyword')->where(array('token'=>$wechat['token'],'type'=>'IMG'))->count();
        $pager = new Page($count,10);
        $sql = "SELECT k.id,k.pid,k.keyword,i.title,i.url,i.pic,i.desc FROM __PREFIX__wx_keyword k LEFT JOIN __PREFIX__wx_img i ON i.id = k.pid WHERE k.token = '{$wechat['token']}' AND type = 'IMG' ORDER BY i.createtime DESC LIMIT {$pager->firstRow},{$pager->listRows}";
        $show = $pager->show();
        $lists = M()->query($sql);

        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function get_access_token($appid,$appsecret){
        //判断是否过了缓存期
        $wechat = M('wx_user')->find();
        $expire_time = $wechat['web_expires'];
        if($expire_time > time()){
           return $wechat['web_access_token'];
            exit;
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $return = httpRequest($url,'GET');
        $return = json_decode($return,1);

        $web_expires = time() + 7000; // 提前200秒过期
        M('wx_user')->where(array('id'=>$wechat['id']))->save(array('web_access_token'=>$return['access_token'],'web_expires'=>$web_expires));
        return $return['access_token'];
        //return $return;
    }

    /*微信标签本地管理*/
    public function tagList(){
        $model = M('wx_tags');
        $count = $model->count();
        $page = new Page($count,10);
        $list = $model
                ->limit($page->firstRow,$page->listRows)
                ->order("count DESC")
                ->select();
        $show = $page->show();
        $this->assign('show',$show);
        $this->assign('list',$list);
        $this->display('tags');
    }
    //同步微信标签
    public function syncTag(){
        $model_tags = M('wx_tags');
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        if(!$access_token){
            $this->error('获取access_token失败',U('Wechat/menu')); //  http://www.tpshop.com/index.php/Admin/Wechat/menu

            exit;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$access_token;
        $tag_list = httpRequest($url,'GET');
        $tag_list = json_decode($tag_list,true);
        $insert_data = array();
        $tags_current = $model_tags->select();
        if(count($tags_current)>0){
            $tags_id_cur = array();
            foreach($tags_current as $k=>$v){
                $tags_id_cur[] = $v['tag_id'];
            }
            foreach($tag_list['tags'] as $key=>$value){
                if(in_array($value['id'],$tags_id_cur)){
                    $model_tags->where(array('tag_id'=>$value['id']))->data(array('tag_name'=>$value['name'],'tag_id'=>$value['id'],'count'=>$value['count']))->save();
                }else{
                    $model_tags->data(array('tag_name'=>$value['name'],'tag_id'=>$value['id'],'count'=>$value['count']))->add();
                }
            }
        }else{
            foreach($tag_list['tags'] as $k => $v){
                $insert_data[] = array('tag_id'=>$v['id'],'tag_name'=>$v['name'],'count'=>$v['count']);


            }
            $model_tags->addAll($insert_data);
        }

            $this->success('同步成功',U('Admin/Wechat/tagList'));


    }
    //创建微信分组
    public function addEditTag(){
        //var_export($_SESSION);exit;
        $tag_name = I("post.tag_name");
        $tag_id = I("tag_id");
        if(IS_POST){
            if($tag_id){//编辑
                $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$this->getAccessTokenWithWxMp();
                $post_data = array(
                    'tag' =>array(
                        'id'=>$tag_id,
                        'name'=>$tag_name
                    )
                );
                $re_update = httpRequest($url,'POST',json_encode($post_data,JSON_UNESCAPED_UNICODE));
                $re_update = json_decode($re_update,true);
                //var_export($re_update);exit;
                if($re_update['errmsg'] == 'ok'){
                    $re = M('wx_tags')->where(array('tag_id'=>$tag_id))->data(array('tag_name'=>$tag_name))->save();
                }
            }else{//新建
                $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->getAccessTokenWithWxMp();
                $post_data=array(
                    'tag'=>array(
                        'name' => $tag_name
                    )
                );
                //exit(http_build_query($post_data));
                $re_create = httpRequest($url,'POST',json_encode($post_data,JSON_UNESCAPED_UNICODE));
                $re_create = json_decode($re_create,true);
                if(count($re_create['tag'])){
                    $re = M('wx_tags')->data(array('tag_name'=>$tag_name,'tag_id'=>$re_create['tag']['id']))->add();
                }
            }
            if($re){
                $this->success('操作成功',U('Admin/Wechat/tagList'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $tag = M('wx_tags')->where(array('tag_id'=>$tag_id))->find();
            $this->assign('tag',$tag);
            $this->display();
        }

    }

    //删除分组
    public function delTag(){
        $tag_id = I("tag_id");
        $find_use = M("business_user_role")->where(array('tag_id'=>$tag_id,'status'=>1,'is_del'=>0))->find();
        if($find_use){
            $this->error("分组正在使用，不允许删除");
        }else{
            //同步操作公众平台
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->getAccessTokenWithWxMp();
            $post_data = array(
                "tag"=>array(
                    "id"=>$tag_id
                )
            );
            $re_del = httpRequest($url,"POST",json_encode($post_data,JSON_UNESCAPED_UNICODE));
            $re_del = json_decode($re_del,true);
            if($re_del['errmsg'] == "ok"){
                $re = M("wx_tags")->where(array('tag_id'=>$tag_id))->delete();
                if($re){
                    $this->success("删除成功",U('Admin/Wechat/tagList'));
                }
            }else{
                //var_dump($re_del);
                $this->error("删除失败请重试");
            }

        }
    }
    //读取当前微信公众账号拿到的access_token
    private function getAccessTokenWithWxMp(){
        $wechat = M('wx_user')->find();
        $access_token = $this->get_access_token($wechat['appid'],$wechat['appsecret']);
        if(!$access_token){
            //$this->error('获取access_token失败',U('Wechat/menu')); //  http://www.tpshop.com/index.php/Admin/Wechat/menu
            return false;
            exit;
        }
        return $access_token;
    }

//////////////////////////////////////////////
}