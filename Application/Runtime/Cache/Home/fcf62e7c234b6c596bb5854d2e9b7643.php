<?php if (!defined('THINK_PATH')) exit();?><table border="0" cellspacing="0" class="sbao_box">
	<tr bgcolor="#F9F9F9">
		<td height="56" rowspan="2" width="66">户口类别</td>
		<td  colspan='2'>养老保险</td>
		<td  colspan='2'>失业保险</td>
		<td  colspan='2'>生育保险</td>
		<td  colspan='2'>工伤保险</td>
		<td  colspan='2'>医疗保险</td>
		<td  colspan='2'>公积金</td>
		<td rowspan="2" >企业合计</td>
		<td rowspan="2" >个人合计</td>
		<td rowspan="2" >总合计</td>
	</tr>
	<tr bgcolor="#F9F9F9">
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
		<td>企业</td>
		<td>个人</td>
	</tr>
	<tr>
		<td height="56">城镇户口</td>
		<td id="v1"><?php echo ($fee_data["xian_one_company"]); ?></td>
		<td id="v2"><?php echo ($fee_data["xian_one_own"]); ?></td>
		<td id="v3"><?php echo ($fee_data["xian_two_company"]); ?></td>
		<td id="v4"><?php echo ($fee_data["xian_two_own"]); ?></td>
		<td id="v5"><?php echo ($fee_data["xian_three_company"]); ?></td>
		<td id="v6"><?php echo ($fee_data["xian_three_own"]); ?></td>
		<td id="v7"><?php echo ($fee_data["xian_four_company"]); ?></td>
		<td id="v8"><?php echo ($fee_data["xian_four_own"]); ?></td>
		<td id="v9"><?php echo ($fee_data["xian_five_company"]); ?></td>
		<td id="v10"><?php echo ($fee_data["xian_five_own"]); ?></td>

		<td id="v11"><?php echo ($fee_data["gjj_company"]); ?></td>
		<td id="v12"><?php echo ($fee_data["gjj_own"]); ?></td>
		<td id="v13"><?php echo ($fee_data["company_fee"]); ?></td>

		<td id="v14"><?php echo ($fee_data["own_fee"]); ?></td>
		<td id="v15"><?php echo ($fee_data["total_fee"]); ?></td>
	</tr>
	<tr>
		<td height="56">农村户口</td>
		<td id="v16"><?php echo ($fee_data["xian_one_company"]); ?></td>
		<td id="v17"><?php echo ($fee_data["xian_one_own"]); ?></td>
		<td id="v18"><?php echo ($fee_data["xian_two_company"]); ?></td>
		<td id="v19">0.00</td>
		<td id="v20"><?php echo ($fee_data["xian_three_company"]); ?></td>
		<td id="v21"><?php echo ($fee_data["xian_three_own"]); ?></td>
		<td id="v22"><?php echo ($fee_data["xian_four_company"]); ?></td>
		<td id="v23"><?php echo ($fee_data["xian_four_own"]); ?></td>
		<td id="v24"><?php echo ($fee_data["xian_five_company"]); ?></td>
		<td id="v25"><?php echo ($fee_data["xian_five_own"]); ?></td>

		<td id="v26"><?php echo ($fee_data["gjj_company"]); ?></td>
		<td id="v27"><?php echo ($fee_data["gjj_own"]); ?></td>
		<td id="v28"><?php echo ($fee_data["company_fee"]); ?></td>

		<td id="v29"><?php echo ($fee_data["own_fee_n"]); ?></td>
		<td id="v30"><?php echo ($fee_data["total_fee_n"]); ?></td>
	</tr>
	<tr>
		<td>备注</td>
		<td colspan="15" style="padding:15px; line-height:24px; text-align:left;">1、养老基数下限是<?php echo ($info["xian_one_min"]); ?>、失业基数下限是<?php echo ($info["xian_two_min"]); ?>、医疗基数下限是<?php echo ($info["xian_five_min"]); ?>、生育基数下限是<?php echo ($info["xian_three_min"]); ?>、工伤基数下限是<?php echo ($info["xian_four_min"]); ?>，<br />
			</td>
	</tr>
</table>