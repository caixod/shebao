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
        var n = $(this).index();
        $('.menu_ul li').removeClass('top_li_cur');
        $(this).addClass('top_li_cur');
        $('.one_tab').hide();
        $('#con_ones_'+ n).show();
        $('.menu_ul2 li').removeClass('left_li_cur');
        $('.menu_ul2 li').eq(n).addClass('left_li_cur');
        $('.twos_tab').hide();
        $('#con_twos_'+ n).show();
        $('.ilike').removeClass('top_li_cur');
        $('.ilike2').removeClass('left_li_cur');
        $('#con_ones_ilike').hide();
        $('#con_twos_ilike').hide();
    });
    $('.menu_ul2 li').click(function(){
        var n = $(this).index();
        $('.menu_ul2 li').removeClass('left_li_cur');
        $(this).addClass('left_li_cur');
        $('.twos_tab').hide();
        $('#con_twos_'+ n).show();
        $('.menu_ul li').removeClass('top_li_cur');
        $('.menu_ul li').eq(n).addClass('top_li_cur');
        $('.one_tab').hide();
        $('#con_ones_'+ n).show();
        $('.ilike').removeClass('top_li_cur');
        $('.ilike2').removeClass('left_li_cur');
        $('#con_ones_ilike').hide();
        $('#con_twos_ilike').hide();
    });
    $('.ilike').click(function(){
        $('.menu_ul li').removeClass('top_li_cur');
        $('.menu_ul2 li').removeClass('left_li_cur');
        $(this).addClass('top_li_cur');
        $('.ilike2').addClass('left_li_cur');
        $('.twos_tab').hide();
        $('.one_tab').hide();
        $('#con_ones_ilike').show();
        $('#con_twos_ilike').show();
    });
    $('.ilike2').click(function(){
        $('.menu_ul li').removeClass('top_li_cur');
        $('.menu_ul2 li').removeClass('left_li_cur');
        $(this).addClass('left_li_cur');
        $('.ilike').addClass('top_li_cur');
        $('.twos_tab').hide();
        $('.one_tab').hide();
        $('#con_ones_ilike').show();
        $('#con_twos_ilike').show();
    });


});

//初始化
window.onload=function auhi(){

    //菜品数量和减号隐藏
    var shuliang_n = $('.food_p3').html();
    if (shuliang_n == 0) {
        $('.line2').hide();
        $('.food_p3').hide();
    }


};



// 风格1风格2 点击切换
$(document).ready(function(){


    //点击切换
    $('#cut').click(function(){
        if($('#main_1').is(':hidden')){
            $('#main_2').hide();
            $('#main_1').show();
            $('#cut').attr({src:'/Template/mobile/dish/Static/new-20170414/images/navs2.png'});
        }else{
            $('#main_1').hide();
            $('#main_2').show();
            $('#cut').attr({src:'/Template/mobile/dish/Static/new-20170414/images/navs.png'});
        }
    });
});





//购物车点击弹出点击关闭功能
function gouwuche_show_hide(){
    $('.footer').click(function(){

        if($('.gouwuche_t').is(':hidden')) {

            var footer2_height = $('.footer').height();
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

};

//点击加号购物车从无到有
$('.line1').click(function(){
    $('.foot_left img').attr({ src: "images/gouwuche2.png"});
    $('.p_wu').hide();
    $('.p_zongji').show();
    $('.p_shuzi').show();
    $('.foot_right button').css({ background: '#e60000'});
    gouwuche_show_hide();
});
$('.line2').click(function(){
    $('.foot_left img').attr({ src: "images/gouwuche.png"});
    $('.p_zongji').hide();
    $('.p_shuzi').hide();
    $('.p_wu').show();
    $('.foot_right button').css({ background: '#aaaaaa'});
});







// 点击菜品出现弹窗 加关闭弹窗
$(function(){

    $('.big_img').click(function(){
        $('.tanchuang').show();
    });
    $('.smo_img').click(function(){
        $('.tanchuang').show();
    });
    $('.img_p1').click(function(){
        $('.tanchuang').show();
    });
    $('.close').click(function(){
        $('.tanchuang').hide();
    });

});







    ////清空购物车
    //$(function(){
    //    $('#qingkong').click(function(){
    //
    //        $('.names_g').css({display: 'none'});
    //        $('.qingkong_g').empty();
    //        //风格1风格2 弹窗 数据清除
    //        $('.food_right').children('.shuliang').children('.food_p3').html(0);
    //        $('.food_right').children('.shuliang').children('.food_p3').hide();
    //        $('.food_right').children('.shuliang').children('.line2').hide();
    //        $('.one_divs').children('.shuliang').children('.food_p3').html(0);
    //        $('.one_divs').children('.shuliang').children('.food_p3').hide();
    //        $('.one_divs').children('.shuliang').children('.line2').hide();
    //        $('.tanc_main').children('.shuliang').children('.food_p3').html(0);
    //        $('.tanc_main').children('.shuliang').children('.food_p3').hide();
    //        $('.tanc_main').children('.shuliang').children('.line2').hide();
    //
    //        $('.p_shuzi').html(0);
    //        $('#zhongjia').html(0);
    //        //页脚购物车显示无菜品时
    //        $('.footer').css({display: 'block'});
    //        $('.footer2').css({display: 'none'});
    //
    //    });
    //});


////大份和标准的点击切换价格切换相对应的数量和加减号
//    $(function guige_fun(){
//
//        $('.food_p4').click( function(){
//
//            var price;
//            var goods_id;
//            var guige;
//            var shuliang_div_class;
//
//            //分别获取两个风格的数据
//            if($('.tanchuang').is(':visible')){
//                goods_id = $(this).parent('.guige').parent('.tanc_main').prevAll('.tangc_top').children('.title_div').children('.p_title').attr('goods_id');
//                guige = 'guige' + $(this).attr('geige_num');
//                price = $(this).attr('price_num');
//
//            }else if($('#main_1').is(':visible')){
//                goods_id = $(this).parent('.guige').prevAll('h3').attr('goods_id');   //用户当前点击加号对应的菜品goods_id
//                guige = 'guige' + $(this).attr('geige_num');
//                price = $(this).attr('price_num');
//
//            }else if($('#main_2').is(':visible')){    //当用户在风格2中点击的时候
//                goods_id = $(this).parent('.guige').parent('.food_right').prev('.food_img').children('.food_wz').children('h3').attr('goods_id');   //用户当前点击加号对应的菜品goods_id
//                guige = 'guige' + $(this).attr('geige_num');
//                price = $(this).attr('price_num');
//            }
//            shuliang_div_class = 'shuliang_div_' + guige + '_' + goods_id;
//
//            //标准和大份 点击切换 以及两个风格页面的规格同步
//            $('.food_right').children('.'+shuliang_div_class).nextAll('.guige').children('.food_p4').removeClass('m1');
//            $('.food_right').children('.'+shuliang_div_class).nextAll('.guige').children('.'+guige).addClass('m1');
//            $('.food_right').children('.'+shuliang_div_class).prevAll('.guige_1').html(price);
//            $('.food_right').children('.'+shuliang_div_class).next('.shuliang').hide();
//            $('.food_right').children('.'+shuliang_div_class).prev('.shuliang').hide();
//            $('.food_right').children('.'+shuliang_div_class).show();
//
//
//            $('.one_divs').children('.'+shuliang_div_class).nextAll('.guige').children('.food_p4').removeClass('m1');
//            $('.one_divs').children('.'+shuliang_div_class).nextAll('.guige').children('.'+guige).addClass('m1');
//            $('.one_divs').children('.'+shuliang_div_class).prevAll('.guige_1').children('span').html(price);
//            $('.one_divs').children('.'+shuliang_div_class).next('.shuliang').hide();
//            $('.one_divs').children('.'+shuliang_div_class).prev('.shuliang').hide();
//            $('.one_divs').children('.'+shuliang_div_class).show();
//
//            $('.tanc_main').children('.'+shuliang_div_class).nextAll('.guige').children('.food_p4').removeClass('m1');
//            $('.tanc_main').children('.'+shuliang_div_class).nextAll('.guige').children('.'+guige).addClass('m1');
//            $('.tanc_main').children('.'+shuliang_div_class).prevAll('.guige_1').children('span').html(price);
//            $('.tanc_main').children('.'+shuliang_div_class).next('.shuliang').hide();
//            $('.tanc_main').children('.'+shuliang_div_class).prev('.shuliang').hide();
//            $('.tanc_main').children('.'+shuliang_div_class).show();
//
//        });
//
//    });




    // 点击心形图片收藏菜品和再次点击取消收藏菜品
    //$(function(){
    //
    //    var goods_id;
    //    var guige;
    //    var shuliang_div_class;
    //
    //    $('.one_wsc').click(function(){
    //        //分别获取两个风格的数据
    //        if($('#main_1').is(':visible')){
    //            goods_id = $(this).parent('.big_p2').prevAll('h3').attr('goods_id');   //用户当前点击加号对应的菜品goods_id
    //
    //        }else if($('#main_2').is(':visible')){    //当用户在风格2中点击的时候
    //            goods_id = $(this).parent('p').prevAll('h3').attr('goods_id');   //用户当前点击加号对应的菜品goods_id
    //        }
    //        guige = 'guige1';
    //        shuliang_div_class = 'shuliang_div_' + guige + '_' + goods_id;
    //
    //        if($(this).attr('src')=='images/sc_3.png'){
    //
    //            $('.food_right').children('.'+shuliang_div_class).parent('.food_right').prevAll('.food_img').children('.food_wz').children('p').children('.one_wsc').attr( {src: "images/tp_sc.png"});
    //
    //            $('.one_divs').children('.'+shuliang_div_class).prevAll('.big_p2').children('.one_wsc').attr( {src: "images/tp_sc.png"});
    //
    //        }else if($(this).attr('src')=='images/tp_sc.png') {
    //
    //            $('.food_right').children('.' + shuliang_div_class).parent('.food_right').prevAll('.food_img').children('.food_wz').children('p').children('.one_wsc').attr({src: "images/choucang2.png"});
    //
    //            $('.one_divs').children('.' + shuliang_div_class).prevAll('.big_p2').children('.one_wsc').attr({src: "images/sc_3.png"});
    //
    //        }else if($(this).attr('src')=='images/choucang2.png') {
    //
    //            $('.food_right').children('.' + shuliang_div_class).parent('.food_right').prevAll('.food_img').children('.food_wz').children('p').children('.one_wsc').attr({src: "images/tp_sc.png"});
    //
    //            $('.one_divs').children('.' + shuliang_div_class).prevAll('.big_p2').children('.one_wsc').attr({src: "images/tp_sc.png"});
    //
    //        }
    //    });
    //
    //});
    //
    //













