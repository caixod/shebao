/**
 * Created by 易启东方-888 on 2017/2/28.
 * 点餐页面的js代码
 */
$(function(){
    $('div, html, body, img, li, ul, p, button, span').unbind('dblclick');
    $('div, html, body, img, li, ul, p, button, span').unbind('scroll');

    /* [ 水平向左滚动 begin ] */
    function scroll_left() {
        var textwidth1 = $('#scroll_text1').width(); //第一个文本宽度
        scrollLeft1 = $('#scroll_text1').scrollLeft(); //第一个文本向左滚动的数值
        //复制第一个文本放到scroll_text2中去
        $('#scroll_text2').css({left: textwidth1}).html($('#scroll_text1').html());

        //设置实时执行
        setInterval(function(){
            //第一个文本向左移动宽度与自身的宽度一致时
            if ((scrollLeft1 + textwidth1) <= 0) {
                scrollLeft1 = 0; //设置向左移动的数值为零
            } else {
                scrollLeft1--;
            }
            $('#out div').eq(0).css({left: scrollLeft1}); //第一个文本向左移动的数值
            $('#out div').eq(1).css({left: scrollLeft1 + textwidth1}); //第二个文本向左移动的数值
        }, 20);
    }
    /* [ /水平向左滚动 end ] */
    scroll_left();



    //  菜单点选
    $('.menu_ul li').click(function(){
        //var n = $(this).index();
        var n = $(this).attr("cate_id");
        //alert(n);return false;
        $('.menu_ul li').removeClass('top_li_cur');
        $(this).addClass('top_li_cur');
        $('.one_tab').css({display:'none'});
        $('#con_ones_'+ n).css({display:'block'});
        $('.menu_ul2 li').removeClass('left_li_cur');
        $('.menu_ul2 li').eq(n).addClass('left_li_cur');
        $('.twos_tab').css({display:'none'});
        $('#con_twos_'+ n).css({display:'block'});
        $('.ilike').removeClass('top_li_cur');
        $('.ilike2').removeClass('left_li_cur');
        $('#con_ones_ilike').css({display:'none'});
        $('#con_twos_ilike').css({display:'none'});
    });

    $('.ilike').click(function(){
        $('.menu_ul li').removeClass('top_li_cur');
        $('.menu_ul2 li').removeClass('left_li_cur');
        $(this).addClass('top_li_cur');
        $('.ilike2').addClass('left_li_cur');
        $('.twos_tab').css({display:'none'});
        $('.one_tab').css({display:'none'});
        $('#con_ones_ilike').css({display:'block'});
        $('#con_twos_ilike').css({display:'block'});
    });
    $('.ilike2').click(function(){
        $('.menu_ul li').removeClass('top_li_cur');
        $('.menu_ul2 li').removeClass('left_li_cur');
        $(this).addClass('left_li_cur');
        $('.ilike').addClass('top_li_cur');
        $('.twos_tab').css({display:'none'});
        $('.one_tab').css({display:'none'});
        $('#con_ones_ilike').css({display:'block'});
        $('#con_twos_ilike').css({display:'block'});
    });


});

//初始化
window.onload=function auhi(){

    //风格1 图片高度自动获取
    // var li_width = $('.smo_li').width();
    // var div_width = $('.one_m_big').width();
    //  var li_height = $('.smo_li').height();
    //  $('.big_img').css('width', div_width);
    //  $('.smo_img').css('width',li_width);
    //  $('.smo_img').css('height',li_height);

    //菜品数量和减号隐藏
    var shuliang_n = $('.food_p3').html();
    if (shuliang_n == 0) {
        $('.line2').css({display: 'none'});
        $('.food_p3').css({display: 'none'});
    }


};


//购物车点击弹出点击关闭功能
$(function(){
    //$('.footer2').click(function(){
    $('.foot_left').click(function(){

        if($('.gouwuche_t').is(':hidden')) {

            var footer2_height = $('.footer2').height();
            var gouwuche_t_top_height = $(window).height()/2-footer2_height;
            $('.z_div').css({display: 'block'});
            $('.gouwuche_t').css({display: 'block',top:gouwuche_t_top_height});

        }else{
            $('.z_div').css({display: 'none'});
            $('.gouwuche_t').css({display: 'none'});

        }
    });

    $('.z_div').click(function(){
        $('.z_div').css({display: 'none'});
        $('.gouwuche_t').css({display: 'none'});
    });

    //document.addEventListener('touchmove', function(event) {
    //判断条件,条件成立才阻止背景页面滚动,其他情况不会再影响到页面滚动
    //  if(!$(".gouwuche_t").is(":hidden")){
    //   event.preventDefault();
    //  }
    //    })
});








// 点击菜品出现弹窗 加关闭弹窗
$(function(){

    $('.big_img').click(function(){
        $(this).parent('.big_div').nextAll('.tanchuang').css({display: 'block'});
    });
    $('.smo_img').click(function(){
        $(this).parent('.smo_div').nextAll('.tanchuang').css({display: 'block'});
    });
    $('.img_p1').click(function(){
        $(this).parent('.food_img').nextAll('.tanchuang').css({display: 'block'});
    });
    $('.close').click(function(){
        $(this).parent('.title_div').parent('.tangc_top').parent('.tanchuang').css({display: 'none'});
    });

});





$(function(){
    var shuliang_n;  //菜品数量
    var jiage = 0;  //菜品价格
    var jiages;    //菜品价格字符串
    var caiping_name;  //菜品名称
    var g_tr_id = 0;   //购物车内增加计数（用于购物车内增加动态ID 保证唯一性）
    var goods_id ;   //当前菜品的goods_id
    var guige;    //菜品的规格（大份 标准）
    var caiping_name_id; //插入的菜品id赋值
    var guige_wz;  //菜品的规格文字（大份 标准）
    var shuliang_div_class;    //显示数量的div的class (用于风格1 风格2 购物车的数据同步)
    var cate_id;    //当前菜品的分类cate_id
    var zhekou;     //当前菜品的折扣


    //清空购物车
    $(function(){
        $('#qingkong').click(function(){

            $('.names_g').css({display: 'none'});
            $('.qingkong_g').empty();
            //风格1风格2 弹窗 数据清除
            $('.food_right').children('.shuliang').children('.food_p3').html(0);
            $('.food_right').children('.shuliang').children('.food_p3').css({display: 'none'});
            $('.food_right').children('.shuliang').children('.line2').css({display: 'none'});
            $('.one_divs').children('.shuliang').children('.food_p3').html(0);
            $('.one_divs').children('.shuliang').children('.food_p3').css({display: 'none'});
            $('.one_divs').children('.shuliang').children('.line2').css({display: 'none'});
            $('.tanc_main').children('.shuliang').children('.food_p3').html(0);
            $('.tanc_main').children('.shuliang').children('.food_p3').css({display: 'none'});
            $('.tanc_main').children('.shuliang').children('.line2').css({display: 'none'});

            $('.p_shuzi').html(0);
            $('#zhongjia').html(0);
            //页脚购物车显示无菜品时
            $('.footer').css({display: 'block'});
            $('.footer2').css({display: 'none'});

        });
    });

    //购物车数量金额计算(加法)
    function gouwuches_jia(zhekou){
        var prcce_zhekou;
        var num = $('.p_shuzi').html();    //购物车菜品的总数量
        var price = parseFloat(jiage.substring(1));     //菜品的单价
        var zhongjia = $('#zhongjia').html().substring(1);     //购物车菜品总价格
        if(zhekou == null || zhekou == 'null' || zhekou==0){
            zhekou = 0;
        }
        if(zhongjia == '' && zhekou == 0 ){
            num =1;
            zhongjia = 0;
            zhongjia +=price;
            $('#zhongjia').html('&yen;'+zhongjia);
            $('.p_shuzi').html(num);
        }else if(zhongjia == '' && zhekou != 0 ){
            num =1;
            zhongjia = 0;
            prcce_zhekou = price * (zhekou/10);
            zhongjia +=prcce_zhekou;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia));
            $('.p_shuzi').html(num);
        }else if(zhongjia != '' && zhekou != 0 ){
            prcce_zhekou = price * (zhekou/10);
            var zhongjia3 = parseFloat(zhongjia);
            zhongjia3 += prcce_zhekou;
            num++;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia3));
            $('.p_shuzi').html(num);
        }else{
            num++;
            var zhongjia2 = parseFloat(zhongjia);
            zhongjia2 += price;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia2));
            $('.p_shuzi').html(num);
        }

    };


    //购物车数量金额计算(减法)
    function gouwuches_jian(zhekou){
        var prcce_zhekou;
        var num = $('.p_shuzi').html();    //购物车菜品的总数量
        var price = parseFloat(jiage.substring(1));      //菜品的单价
        var zhongjia = parseFloat($('#zhongjia').html().substring(1));    //购物车菜品总价格
        if(zhekou == null || zhekou == 'null'){
            zhekou = 0;
        }
        if(zhongjia == '' && zhekou == 0 ){
            num =0;
            zhongjia = 0;
            zhongjia +=price;
            $('#zhongjia').html('&yen;'+zhongjia);
            $('.p_shuzi').html(num);
        }else if(zhongjia == '' && zhekou != 0 ){
            num--;
            zhongjia = 0;
            prcce_zhekou = price * (zhekou/10);
            zhongjia -=prcce_zhekou;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia));
            $('.p_shuzi').html(num);
        }else if(zhongjia != '' && zhekou != 0 ){
            prcce_zhekou = price * (zhekou/10);
            var zhongjia3 = parseFloat(zhongjia);
            zhongjia3 -= prcce_zhekou;
            num--;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia3));
            $('.p_shuzi').html(num);
        }else{
            num--;
            var zhongjia2 = parseFloat(zhongjia);
            zhongjia2 -= price;
            $('#zhongjia').html('&yen;'+changeTwoDecimal_f(zhongjia2));
            $('.p_shuzi').html(num);
        }

    };

    //保留小数后两位
    function changeTwoDecimal_f(x) {
        var f_x = parseFloat(x);
        if (isNaN(f_x)) {
            return false;
        }
        var f_x = Math.round(x * 100) / 100;
        var s_x = f_x.toString();
        var pos_decimal = s_x.indexOf('.');
        if (pos_decimal < 0) {
            pos_decimal = s_x.length;
            s_x += '.';
        }
        while (s_x.length <= pos_decimal + 2) {
            s_x += '0';
        }
        return s_x;
    }

});

$(function(){
    $(".gui_ge").click(function(){
        dish_id = $(this).attr("data-dish-id");
        k = $(this).attr("data-key");
        k2 = (k==1) ? 2: 1;
        $(this).addClass("m1");
        $(".guige_self_"+dish_id+"_"+k2).removeClass("m1");
        $(".guige_"+k+"_"+dish_id).css("display","block");
        $(".guige_"+k2+"_"+dish_id).css("display","none");
    });
});








