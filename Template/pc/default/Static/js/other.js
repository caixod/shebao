/**
 * Created by Administrator on 2017-09-14.
 */
function displayDate(){
    document.getElementById("nav_top").style.display="none";
    document.getElementById("za").style.display="block";
    document.getElementById("nav_top_div").style.display="block";
}
function displayDate2(){
    document.getElementById("za").style.display="none";
    document.getElementById("nav_top_div").style.display="none";
    document.getElementById("nav_top").style.display="block";
}
function tabs(){
    document.getElementById("tab_li2").classList.remove("tab_li_cur");
    document.getElementById("tab_li1").classList.add("tab_li_cur");
    document.getElementById("tab2").style.display="none";
    document.getElementById("tab1").style.display="block";
}
function tabs2(){
    document.getElementById("tab_li1").classList.remove("tab_li_cur");
    document.getElementById("tab_li2").classList.add("tab_li_cur");
    document.getElementById("tab1").style.display="none";
    document.getElementById("tab2").style.display="block";
}


$(function (){
    $(".nav_top_li").click(function(){
        $(this).children(".nav_top_div").css("display","block");
    });
});