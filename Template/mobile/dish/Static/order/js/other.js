/**
 * Created by 易启东方-888 on 2017/4/13.
 */

$('.dingdan_top li').click(function(){

    var li_num;
    var jiankuohao_html =
        '<span class="sp1">' +
        '<span class="sp2"></span>' +
        '</span>';
    li_num = $(this).attr('li_num');
    $('.dingdan').hide();
    $('.dingdan_top li').children('.sp1').remove();
    $('.dingdan_'+li_num).show();
    $(this).append(jiankuohao_html);


});
