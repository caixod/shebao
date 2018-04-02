<?php if (!defined('THINK_PATH')) exit();?>
<table class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
        <th>名称</th>
        <th colspan="2">缴纳项目</th>
        <th>养老保险</th>
        <th>失业保险</th>
        <th>生育保险	</th>
        <th>工伤保险</th>
        <th>医疗保险</th>
        <th>公积金</th>
        <th>小计</th>
    </tr>
    <!--<tr>-->
    <!--<th>缴纳比例</th>-->
    <!--<th>缴纳金额</th>-->
    <!--<th>缴纳比例</th>-->
    <!--<th>缴纳金额</th>-->
    <!--</tr>-->
    </thead>
    <tbody id="first_tbody">
    <?php if(is_array($fee_data)): foreach($fee_data as $key=>$vo): ?><tr>
        <td>姓名</td>
        <td rowspan="2">企业缴纳</td>
        <td>比例(%)</td>
        <td><?php echo ($sb_bilie["c_xian_one"]); ?></td>
        <td><?php echo ($sb_bilie["c_xian_two"]); ?></td>
        <td><?php echo ($sb_bilie["c_xian_three"]); ?></td>
        <td><?php echo ($sb_bilie["c_xian_four"]); ?></td>
        <td><?php echo ($sb_bilie["c_xian_five"]); ?></td>
        <td><?php echo ($sb_bilie["c_gjj_bilie"]); ?></td>
        <td>
            -
        </td>
    </tr>
    <tr>

        <td><?php echo ($vo["username"]); ?></td>
        <td>金额(元)</td>
        <td><?php echo ($vo["xian_one_company"]); ?></td>
        <td><?php echo ($vo["xian_two_company"]); ?></td>
        <td><?php echo ($vo["xian_three_company"]); ?></td>
        <td><?php echo ($vo["xian_four_company"]); ?></td>
        <td><?php echo ($vo["xian_five_company"]); ?></td>
        <td><?php echo ($vo["gjj_company"]); ?></td>
        <td><?php echo ($vo["company_fee"]); ?></td>

    </tr>
    <tr>
        <td>缴纳基数</td>
        <td rowspan="2">个人缴纳</td>
        <td>比例(%)</td>
        <td><?php echo ($sb_bilie["xian_one"]); ?></td>
        <td><?php echo ($sb_bilie["xian_two"]); ?></td>
        <td><?php echo ($sb_bilie["xian_three"]); ?></td>
        <td><?php echo ($sb_bilie["xian_four"]); ?></td>
        <td><?php echo ($sb_bilie["xian_five"]); ?></td>
        <td><?php echo ($sb_bilie["gjj_bilie"]); ?></td>
        <td>
            -
        </td>
    </tr>
    <tr>

        <td>社:<?php echo ($vo["sb_old_base"]); ?>元/公:<?php echo ($vo["gjj_old_base"]); ?>元</td>
        <td>金额(元)</td>
        <td><?php echo ($vo["xian_one_own"]); ?></td>
        <td><?php echo ($vo["xian_two_own"]); ?></td>
        <td><?php echo ($vo["xian_three_own"]); ?></td>
        <td><?php echo ($vo["xian_four_own"]); ?></td>
        <td><?php echo ($vo["xian_five_own"]); ?></td>
        <td><?php echo ($vo["gjj_own"]); ?></td>
        <td><?php echo ($vo["own_fee"]); ?></td>

    </tr>
        <tr>
            <td colspan="10" style="text-align:left;padding-left:85%;background-color:#fff;">服务费：<span class="t-allTotal"><?php echo ($vo["service_fee"]); ?></span></td>
        </tr>
        <tr>
            <td colspan="10" style="text-align:left;padding-left:85%;background-color:#fff;">滞纳金：<span class="t-allTotal"><?php echo ($vo["zhina_fee"]); ?></span></td>
        </tr><?php endforeach; endif; ?>


    <tr>
        <td colspan="10" style="text-align:left;padding-left:85%;background-color:#fff;">总费用：<span class="t-allTotal"><?php echo ($all_total); ?></span></td>
    </tr>
    </tbody>
</table>