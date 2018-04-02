//地区选择
new PCAS("province","city","area");


function changeprice(){
	var danjia=$("#danjia").val();
	var mun=$("#mun").val();
	$("#price").val((parseInt(mun) * parseInt(danjia)).toFixed(0));
	$("#total1").html((parseInt(mun) * parseInt(danjia)).toFixed(0));
}

function addnumber(){
	$('#mun').val(parseInt($('#mun').val())+1);
	changeprice();
}

function minnumber(){
	if($('#mun').val()>1){
	$('#mun').val(parseInt($('#mun').val())-1);
	changeprice();
	}
}
function inputnumber(){
	var number=parseInt($('#mun').val());
	if(isNaN(number)||number<1){
		$('#mun').val('1');
	changeprice();
	}else{
		$('#mun').val(number);
	}
        changeprice();
}


$(function(){

	function scollDown(id,time){
          var liHeight=$("#"+id+" ul li").height();
          var time=time||2500;
          setInterval(function(){
          $("#"+id+" ul").prepend($("#"+id+" ul li:last").css("height","0px").animate({
          	height:liHeight+"px"
          },"slow"));
          },time);
        

	}
	scollDown("fahuo",6000);
});