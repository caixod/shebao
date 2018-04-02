
//页面加载时动态获取导航高度 并赋值给margin-top
$(document).ready(function(){
    $(function TopHeight(){

        var topheight =$('.navbar').height();

        $(".topheight").css("margin-top",topheight);


    });
});


//提现页面js
$(function (){

    var imgshtml= '<img class="tixian_img2" src="images/2.png">';
    var addhtml = '<a href="add_bank_card.html"><img src="images/add.png"/></a>';

    var bodyheight = $(document).height();

    $(".bank").css("height",bodyheight);

    $('.yhk_div1').click(function(){

        $(".nav_li1").addClass('bank_fanhui');
        $(".nav_title").text("选择银行卡");
        $(".nav_li3").append(addhtml);
        $("#bank_card").animate({left: '-100%'}, 200);
        $("#bank_card_xuanze").animate({left: '0%'}, 200);

        $('.bank_fanhui').click(function(){
            quxiaos();
        });

    });

    function quxiaos(){
        $(".nav_li1").removeClass('bank_fanhui');
        $(".nav_title").text("提现");
        $(".nav_li3 a").remove();
        $("#bank_card").animate({left: '0%'}, 200);
        $("#bank_card_xuanze").animate({left: '100%'}, 200);
    };

    $('.yhk_div2').click(function(){
        quxiaos();
        $('.tixian_img2').remove();
        $(this).children('.tixian_div3').append(imgshtml);
    });

});

