<?php if (!defined('THINK_PATH')) exit();?><table border="0" cellspacing="0" class="sbao_box">
	<tr bgcolor="#F9F9F9" align="center">
		<td height="56" rowspan="2" width="66">户口类别</td>
		<td  colspan='2'>社保</td>
		<td  colspan='2'>公积金</td>
		<td rowspan="2" >企业合计</td>
		<td rowspan="2" >个人合计</td>
		<td rowspan="2" >总合计</td>
	</tr>
	<tr bgcolor="#F9F9F9" align="center">
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
	</tr>
	<tr align="center">
		<td height="56">城镇户口</td>
		<td id="v1"><?php echo ($data["sb_fee_company_city"]); ?></td>
		<td id="v2"><?php echo ($data["sb_fee_own_city"]); ?></td>
		<td id="v3"><?php echo ($data["gjj_company"]); ?></td>
		<td id="v4"><?php echo ($data["gjj_own"]); ?></td>
		<td id="v5"><?php echo ($data["company_fee"]); ?></td>
		<td id="v6"><?php echo ($data["own_fee"]); ?></td>
		<td id="v7"><?php echo ($data["total_fee"]); ?></td>
	</tr>
	<tr align="center">
		<td height="56">农村户口</td>
		<td id="v16"><?php echo ($data["sb_fee_company_n"]); ?></td>
		<td id="v17"><?php echo ($data["sb_fee_own_n"]); ?></td>
		<td id="v18"><?php echo ($data["gjj_company"]); ?></td>
		<td id="v19"><?php echo ($data["gjj_own"]); ?></td>
		<td id="v20"><?php echo ($data["company_fee"]); ?></td>
		<td id="v21"><?php echo ($data["own_fee_n"]); ?></td>
		<td id="v22"><?php echo ($data["total_fee_n"]); ?></td>
	</tr>
	<tr>
		<td align="center">备注</td>
		<td colspan="15" style="padding:15px; line-height:24px; text-align:left;">1、养老基数下限是<?php echo ($info["xian_one_min"]); ?>、失业基数下限是<?php echo ($info["xian_two_min"]); ?>、医疗基数下限是<?php echo ($info["xian_five_min"]); ?>、生育基数下限是<?php echo ($info["xian_three_min"]); ?>、工伤基数下限是<?php echo ($info["xian_four_min"]); ?>，<br /></td>
	</tr>
</table>