<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>订单支付确认页</title>
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/reset.css">
    <script src="/Template/pc/default/Static/js/new_js/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--<script src="/Template/pc/default/Static/js/other.js"></script>-->
    <!--<script src="/Template/pc/default/Static/js/global_no.js"></script>-->
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/style.css">
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/comeon.css">
    <link rel="stylesheet" href="/Template/pc/default/Static/css/new_css/bootstrap-switch.css">
    <script src="/Template/pc/default/Static/js/new_js/bootstrap-switch.min.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/plupload.full.min.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/laydate/laydate.js"></script>
    <script src="/Template/pc/default/Static/js/new_js/layer/layer.js"></script>
    <link type="text/css" rel="stylesheet" href="/Template/pc/default/Static/css/new_css/jquery-ui-1.9.2.custom.css">
    <script src="/Template/pc/default/Static/js/other.js"></script>
    <script src="/Template/pc/default/Static/js/global_no.js"></script>
    <link rel="stylesheet" type="text/css" href="/Template/pc/default/Static/js/uploader/webuploader.css">
    <!--引入JS-->
    <script type="text/javascript" src="/Template/pc/default/Static/js/uploader/webuploader.js"></script>
    <script>



    </script>
    <style>
        .main-content-fun h4{
            color:grey;
            font-weight:blod;
        }
        .g_on_off {
            position: absolute !important;
            left: 600px;
            top: 67px;
        }
        .i_agree {
            margin-left: 100px;
            margin-top: 30px;
            font-size: 15px;
            color: grey;
        }
        .i_agree>label {
            margin-left: 10px;
        }
        .g_wxd {
            margin-bottom: 30px;
        }
        .pop-content-left p{
            margin-top:20px;
        }
        .g_tips{
            border-radius:10px;
        }
        .main-article-tips{
            border-radius:10px;
        }
        /* .g_titel_2>span{
        color:grey;

        }
        .g_in>label{
        color:#333;
        } */
    </style>
    <script type="text/javascript" src="/Template/pc/default/Static/js/new_js/jquery-ui-1.9.2.custom.js" language="javascript"></script>
    <script type="text/javascript" src="/Template/pc/default/Static/js/new_js/share.js"></script>
    <script type="text/javascript">
        var loadIndex;
        $(document).ajaxStart(function(){
            loadIndex=layer.load(1)
        }).ajaxStop(function(){
            layer.close(loadIndex);
        });
    </script>
    <script>
        $(function () {
            var n = 1;
            $(".ggy").bind("click", function () {
                var $html = $("<li class='g_li'><span class='g_name'></span><input class='g_sbjs' type='text'><input class='g_gjjjs' type='text'><button style='margin-left:20px;vertical-align:top;float:left;' class='btn btn-md btn-success g_zuidi' onmouseover='add()'>最低基数</button><a href='#'><span style='width:14px;height:16px;margin-left:20px;' class='glyphicon glyphicon-remove g_delete'></span></a></li>");
                $("#g_put").append($html);
                n++;
            });
            $("#g_put").on("click", ".g_delete", function () {
                $(this).parents("li").remove();
            });
        });
    </script>

</head>
<body>
<!--//导航栏-->

<!--导航栏end-->
<div class="content clear">
    <form action="<?php echo U('Checklogin/sure_order_info');?>" method="post" id="form1" >
        <div class="left">

            <div class="main-content-fun">
                <h4>您办理的服务是：<?php echo ($service_name); ?></h4>

                <div class="main-content-fun-select g_padd new">
                    <h4>订单金额</h4>
                    <span>订单金额：</span>
                    <div class="bdbox">
                        <div class="xlbox">
                            <?php echo ($total_fee); ?>&nbsp;&nbsp;元
                        </div>
                    </div>
                </div>
                <div class="main-content-fun-select g_padd new">
                    <h4>可用代金券</h4>
                    <div class="bdbox">
                        <div class="xlbox">
                            <?php if($coupon != null): ?><select class="dqxl" name="coupon_id" id="v" style="width: 200px;">
                                <option  value="0">选择代金券</option>
                                <?php if(is_array($coupon)): $i = 0; $__LIST__ = $coupon;if( count($__LIST__)==0 ) : echo "暂无可用代金券" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($vo["id"]); ?>">满<?php echo ($vo["max_fee"]); ?>元减<?php echo ($vo["money"]); ?>元</option><?php endforeach; endif; else: echo "暂无可用代金券" ;endif; ?>
                            </select>

                                <?php else: ?>
                                暂无可用代金券<?php endif; ?>

                        </div>
                    </div>
                </div>


                <div class="main-content-fun-tips new" style="height: 10px;">
                    <h4></h4>

                </div>

                <!--<div class="g_button">-->
                    <!--<button  type="button" onclick="to_jisuanfee();" class="btn btn-lg btn-success now_buy">下一步</button>-->
                    <!--&lt;!&ndash;<button class="btn btn-lg btn-success">计算明细</button>&ndash;&gt;-->
                <!--</div>-->
            </div>


            <div class="g_button">

                <button type="submit" id="submit_order"  class="btn btn-lg btn-success now_buy">确认支付</button>

            </div>
        </div>
    </form>
    <div class="right">
        <div class="main-article">
            <div class="g_tips">
                <p>当前已开通服务城市</p>

                <ul class="g_city">
                    <?php if(is_array($area_list)): foreach($area_list as $k=>$vo): ?><li>
                            <p><?php echo ($k); ?></p>
                            <?php if(is_array($vo)): foreach($vo as $key=>$v): ?><span><?php echo ($v["name"]); ?></span><?php endforeach; endif; ?>
                        </li><?php endforeach; endif; ?>
                </ul>

            </div>
            <div class="main-article-tips">
                <div class="default">
                    <h4>社保小贴士</h4>
                    <p>请选择您的参保城市</p>
                    <p>根据您选择的参保城市，提供以下信息：</p>
                    <p>1、下单截止日期</p>
                    <p>2、参保规则说明</p>
                    <p>3、需要提供的参保资料</p>
                    <p>4、服务费收取规则</p>
                </div>
                <div class="social_tips">
                    <p>特别提示:</p>
                    <div>
                        1、 因客户自身原因（未了解清楚规则、无故撤单）退费的，服务费不予退还！<br>
                        2、不承接现已怀孕、重病等特殊人员的社保代缴业务。如客户隐瞒孕情、病情下单，我司无法为其办理相应的社保待遇。如有生育计划，请在孕前3个月，即生育前13个月提前购买社保。<br>
                        3、关于生育待遇的申领，我司仅承接异地分娩，生育备案，医疗报销等业务。涉及生育津贴、产假工资的申领我司概不接受。<br>
                        4、首次支付时系统会提示上传身份证正反面材料，填写好个人信息支付订单后，我司会有人跟进，如后续需要其它材料补充，我司会再联系您。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ft-footer">
    <div class="ft-footer-nav page">
        <div class="ft-footer-nav-l fl">
            <ul class="about-us">
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/2.html" >关于我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/33.html">联系我们</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/list/index/cid/4.html">大事记</a></li>
                <li style="border-right:none;"><a href="http://www.zhongguoshebaodaili.cn/index.php/page/index/cid/16.html">加入我们</a></li>
            </ul>
            <div class="friendly-url" style="width:643px;overflow:hidden;">
                <span>相关链接：</span>
                <div style="width:583px; float:right;">
                    <a href="http://www.mohrss.gov.cn/">中华人民共和国人力资源和社会保障部</a>
                    <a href="http://www.spicezee.com/">中国社保网</a>
                    <a href="http://www.bjrbj.gov.cn/">北京市人力资源和社会保障局</a>
                    <a href="http://www.szsi.gov.cn/">深圳市社会保险基金管理局</a>
                    <a href="http://www.12333sh.gov.cn/index.shtml">上海市人力资源和社会保障局</a>
                </div>
            </div>
        </div>
        <div class="ft-footer-nav-r fr">
            <div class="contact fr">
                <h2>400-086-4500</h2>
                <p class="email">
                    <span>hzbs001@163.com</span>
                </p>
                <p class="ads">版权所有(C)2018-2020 慧智博思&nbsp;</p>
            </div>
        </div>
    </div>
</div>
<script>

</script>
</body>

<script src="/Template/pc/default/Static/js/new_js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/diqu.js"></script>-->
<!--<script type="text/javascript" src="/Template/pc/default/Static/js/new_js/not3.js"></script>-->
<script>
    $(function(){

        $("#btn2").click(function(){

            $("#show2").modal("show");
        });
        $(".g_quxiao").click(function(){
            $("#show2").modal("hide");
        })
        $(".g_close").click(function() {
            $("#show2").modal("hide");
        });
    })

</script>
<script>
    $(document).ready(function () {
        //alert($('#my_sb_Switch').attr('checked'));
        //alert($('#my_gjj_Switch').attr('checked'));

        $('#mss').click(function () {
            if($('#my_sb_Switch').attr('checked') == 'checked'){
                $('#my_sb_Switch').attr('checked',false);
                $('#date1').attr('disabled','disabled');
                $('#date2').attr('disabled','disabled');

            }else{
                $('#my_sb_Switch').attr('checked','checked');
                $('#date1').attr('disabled',false);
                $('#date2').attr('disabled',false);
            }


        });

        $('#mgs').click(function () {
            if($('#my_gjj_Switch').attr('checked') == 'checked'){
                $('#my_gjj_Switch').attr('checked',false);
                $('#date3').attr('disabled','disabled');
                $('#date4').attr('disabled','disabled');
            }else{
                $('#my_gjj_Switch').attr('checked','checked');
                $('#date3').attr('disabled',false);
                $('#date4').attr('disabled',false);
            }
        });


        //开发中提示
        /*$("a").click(function () {
            if($(this).attr("href") == '#'){
                alert('开发中...敬请期待');
            }
        });*/

    });
</script>
<script>


    //执行一个laydate实例
    laydate.render({
        elem: '#date1' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date2' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date3' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });
    laydate.render({
        elem: '#date4' //指定元素
        ,type: 'month'
        ,min: 0
        ,max: 2000
    });

    $("#to_top").click(function(){
        $("html,body").animate({scrollTop:0},500);//返回顶部
    })
</script>
</html>