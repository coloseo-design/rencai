<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:21:51
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_com_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:2567662c5461f64bc38-40518471%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f906e203d44702787185d3b33c630a0b8d73ef1d' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_com_config.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2567662c5461f64bc38-40518471',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'qy_rows' => 0,
    'com_link_no' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c5461f71f213_74485577',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c5461f71f213_74485577')) {function content_62c5461f71f213_74485577($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
	<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet"
	 type="text/css" />
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
		var weburl = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
';
	<?php echo '</script'; ?>
>
	<title>后台管理</title>
</head>

<style>
	.layui-form-item{ margin-bottom:0px;}
</style>

<body class="body_ifm">
	<form class="layui-form">
		<div class="infoboxp">
			<div class="tty-tishi_top">

				<div class="tabs_info">
					<ul>
						<li class="curr"><a href="index.php?m=admin_comset">企业设置</a></li>
						<li><a href="index.php?m=admin_comset&c=logo">头像设置</a></li>
						<li><a href="index.php?m=admin_comset&c=comspend">消费设置</a></li>
						<li><a href="index.php?m=admin_comset&c=rating">套餐设置</a></li>
						<li><a href="index.php?m=admin_comset&c=reward">职位推广设置</a></li>
					</ul>
				</div>
				
				<div class="clear"></div>

				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">管理员可以部署网站企业会员相关信息的审核、强制完善信息等设置！</div>
						<div class="admin_new_tip_list">管理员也可以设置企业相关功能的开启或关闭！</div>
						<div class="admin_new_tip_list">具体信息部署，可以根据实际运营需求设置！</div>
					</div>
				</div>

				<div class="clear"></div>
			
				<div class="tag_box tty_qiyesSet">

					<div>
						<table width="100%" class="table_form">

							<tr>
								<th width="220" style="float: left;">审核信息：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_status" title="企业会员" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_status']=='0') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_job_status" title="发布职位" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_status']=='0') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_partjob_status" title="发布兼职" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_partjob_status']=='0') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_cert_status" title="企业资质" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_status']=='1') {?>checked<?php }?> />
										</div>
									 
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_logo_status" title="企业LOGO" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_logo_status']=='1') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_show_status" title="企业环境" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_show_status']=='1') {?>checked<?php }?> />
										</div>

										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_banner_status" title="企业横幅" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_banner_status']=='1') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_revise_status" title="企业修改" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_revise_status']=='0') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_comment_status" title="面试评价" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_comment_status']=='0') {?>checked<?php }?> />
										</div>
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_yqmb_status" title="邀请面试模板" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_yqmb_status']=='0') {?>checked<?php }?> />
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<th width="220" style="float: left;">强制操作：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_enforce_info" title="信息完善" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_enforce_info']=='1') {?>checked<?php }?> />
										</div>
										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_enforce_mobilecert" title="手机认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_enforce_mobilecert']=='1') {?>checked<?php }?> />
										</div>
										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_enforce_emailcert" title="邮箱认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_enforce_emailcert']=='1') {?>checked<?php }?> />
										</div>
									</div>

									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_enforce_licensecert" title="企业资质" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_enforce_licensecert']=='1') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_enforce_setposition" title="地理位置" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_enforce_setposition']=='1') {?>checked<?php }?> />
										</div>
									
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_gzgzh" title="关注微信公众号" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_gzgzh']=='1') {?>checked<?php }?> />
										</div>
									</div>
									<span class="admin_web_tip">提示：强制操作完成才能发布招聘信息</span>	
								</td>
							</tr>
							<tr>
								<th width="220" style="float: left;">企业资质上传项：</th>
								<td>
									<div class="layui-input-block">

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_social_credit" title="统一社会信用代码" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_social_credit']=='1') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_cert_owner" title="经办人身份证件" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_owner']=='1') {?>checked<?php }?> />
										</div>
										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_cert_wt" title="承诺函" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_wt']=='1') {?>checked<?php }?> />
										</div>
										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_cert_other" title="其他材料" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_cert_other']=='1') {?>checked<?php }?> />
										</div>
									</div>

									<span class="admin_web_tip" style=" padding-top:0px;">提示：除了企业执照外,须上传的企业资质。</span>	
                                   
									
								</td>
								
							</tr>
                            <tr>
								<th width="220" style="float: left;">委托书/承诺函范本：</th>
								<td>
									<div class="layui-input-block">
										<button type="button" class="yun_bth_pic  noupload"  >上传范本</button>
		                                <?php if ($_smarty_tpl->tpl_vars['config']->value['exa_cert_wt']) {?>
		                                <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['exa_cert_wt'];?>
" style="font-size:12px;color:#2d8cf0; display:inline-block; margin-left:10px; line-height:30px; text-decoration:underline">查看范本</a>
										<?php }?>

										<input type="hidden" id="laynoupload" value="1"/> 
										<input type="hidden" id="layfiletype" value="2"/>
									</div>
									<span  class="admin_web_tip">提示：请上传文档类型文件。</span>	
                              	</td>  
                            </tr>
							<tr>
								<th width="220" style="float: left;">功能开关：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_message" title="求职咨询" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_message']=='1') {?>checked<?php }?> />
										</div>

										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="sy_com_invoice" title="发票申请" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_com_invoice']=='1') {?>checked<?php }?> />
										</div>
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_msg_status" title="面试评价" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_msg_status']=='1') {?>checked<?php }?> />
										</div>
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_free_status" title="认证企业职位免审核" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_free_status']=='1') {?>checked<?php }?> />
										</div>
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_job_myswitch" title="薪资面议" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_myswitch']=='1') {?>checked<?php }?> />
										</div>
									</div>
								</td>
							</tr>

							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">职位刷新：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" lay-filter="com_job_reserve" name="com_job_reserve" value="1" title="预约刷新" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_reserve']==1) {?>checked<?php }?>>
											<input type="radio" lay-filter="com_job_reserve" name="com_job_reserve" value="0" title="自动刷新" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_reserve']==0) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">预约刷新：根据会员刷新套餐数量，设置刷新次数，每N分钟刷新一次</span><br>
										<span class="admin_web_tip">自动刷新：企业会员选择不同天数，支付一定金额，每日刷新一次</span>
									</div>
								</td>
							</tr>

							<tr class="admin_table_trbg upJobSon" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_reserve']!=1) {?>style="display: none;"<?php }?>>
								<th width="200">预约刷新时间间隔：</th>
								<td>
									<input class="input-text" type="text" name="sy_reserve_refresh_interval" id="sy_reserve_refresh_interval" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reserve_refresh_interval'];?>
" size="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')"  onblur="checkInterval(this);" />分&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">最低N分钟，企业可自定义，不得低于后台设置参数</span>
								</td>
							</tr>

							<tr class="admin_table_trbg upJobSon" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_reserve']!=1) {?>style="display: none;"<?php }?>>
								<th width="200">预约刷新消费套餐：</th>
								<td>
									<input class="input-text" type="text" name="sy_reserve_refresh_price" id="sy_reserve_refresh_price" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reserve_refresh_price'];?>
" size="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')"  />份&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip" style="margin-left:0px;">单个职位一次刷新所需消耗套餐数量；</span>
								</td>
							</tr>

							<tr class="admin_table_trbg upJobSon" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_job_reserve']!=1) {?>style="display: none;"<?php }?>>
								<th width="200">刷新职位增值服务：</th>
								<td>
									<input class="input-text" type="text" name="sy_reserve_service_id" id="sy_reserve_service_id" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reserve_service_id'];?>
" size="10" onKeyUp="this.value=this.value.replace(/[^0-9]/g,'')"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip" style="margin-left:0px;">请填写刷新套餐增值服务编号；<a href="index.php?m=admin_comrating&c=server"> 查看>></a></span>
								</td>
							</tr>
							<tr>
								<th width="220" style="float: left;">人才搜索：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_search" id="com_search" title="已登录会员" type="checkbox" lay-skin="primary" lay-filter="comSearch" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_search']=='1') {?>checked<?php }?> />
										</div>
										
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;width: 150px;">
											<input name="com_status_search" id="com_status_search" title="已审核会员" type="checkbox" lay-skin="primary" lay-filter="statusSearch"<?php if ($_smarty_tpl->tpl_vars['config']->value['com_status_search']=='1') {?>checked<?php }?> />
										</div>
									</div>
									<span class="admin_web_tip">会员已登录、会员已审核才能搜索人才</span>	
								</td>
							</tr>

							<tr>
								<th width="220" style="float: left;">人才下载：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline" style="margin: 0px 30px 15px 0;">
											<input name="com_lietou_job" title="在招职位" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_lietou_job']=='1') {?>checked<?php }?> />
										</div>
									</div>
									<span class="admin_web_tip">有正在招聘的职位才能下载简历</span>	

								</td>
							</tr>
											 
							<tr class="admin_table_trbg">
								<th width="200">企业搜索器：</th>
								<td >
									<input class="input-text" type="text" name="com_finder" id="com_finder" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['com_finder'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9.]/g,'')" />个&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">数量太多，发送订阅邮件会很慢，为空则不限</span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="200">邀请面试模板数：</th>
								<td >
									<input class="input-text" type="text" name="com_yqmb_num" id="com_yqmb_num" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['com_yqmb_num'];?>
" size="20" maxlength="255" onKeyUp="this.value=this.value.replace(/[^0-9.]/g,'')" />个&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">企业邀请面试可保存的模板数</span>
								</td>
							</tr> 
							<tr>
								<th width="200">会员到期提醒：</th>
								<td>
									<input class="input-text tips_class input_text_rp" type="text" name="sy_maturityday" id="sy_maturityday" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_maturityday'];?>
" size="10" />天&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">默认为30天,此设置将向站长发送邮件，请先配置站长Email</span>
								</td>
							</tr>
							<tr>
								<th width="200">优惠券到期提醒：</th>
								<td>
									<input class="input-text tips_class input_text_rp" type="text" name="sy_couponday" id="sy_couponday" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_couponday'];?>
" size="10" />天&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">默认为30天</span>
								</td>
							</tr>
							 
							<tr>
								<th width="200">申请消费发票金额：</th>
								<td>
									<input class="input-text tips_class input_text_rp" type="text" name="sy_com_invoice_money" id="sy_com_invoice_money" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_com_invoice_money'];?>
" size="10" />元&nbsp;&nbsp;&nbsp;
									<span class="admin_web_tip">大于等于此金额才能申请发票</span>
								</td>
							</tr>

							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">职位列表置顶：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" name="joblist_top" value="1" title="全部显示" <?php if ($_smarty_tpl->tpl_vars['config']->value['joblist_top']==1) {?>checked<?php }?>>
											 <input type="radio" name="joblist_top" value="0" title="随机5条" <?php if ($_smarty_tpl->tpl_vars['config']->value['joblist_top']==0) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">若选择“全部显示”，则职位列表会将置顶职位全部显示完之后再显示其他职位</span>
									</div>
								</td>
							</tr>
							
							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">职位名称锁定：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" name="joblock" value="1" title="锁定" <?php if ($_smarty_tpl->tpl_vars['config']->value['joblock']==1) {?>checked<?php }?>>
											 <input type="radio" name="joblock" value="0" title="不锁定" <?php if ($_smarty_tpl->tpl_vars['config']->value['joblock']==0) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">若选择“锁定”，则职位名称发布后不可修改</span>
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">名企排序：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" name="hotcom_top" value="0" title="后台手动设置" <?php if ($_smarty_tpl->tpl_vars['config']->value['hotcom_top']==0) {?>checked<?php }?>>
											<input type="radio" name="hotcom_top" value="1" title="职位更新时间" <?php if ($_smarty_tpl->tpl_vars['config']->value['hotcom_top']==1) {?>checked<?php }?>>
											<input type="radio" name="hotcom_top" value="2" title="随机" <?php if ($_smarty_tpl->tpl_vars['config']->value['hotcom_top']==2) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">“后台手动设置”是指添加后台添加名企时设置的排序</span>
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">会员到期职位下架：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" name="jobunder" value="1" title="下架" <?php if ($_smarty_tpl->tpl_vars['config']->value['jobunder']==1) {?>checked<?php }?>>
											 <input type="radio" name="jobunder" value="0" title="保持" <?php if ($_smarty_tpl->tpl_vars['config']->value['jobunder']==0) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">若选择“下架”，则会员到期后职位自动下架</span>
									</div>
								</td>
							</tr>


							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">查看企业联系方式：</th>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="radio" name="com_link_look" value="1" title="普通模式" lay-filter="com_link_look" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_link_look']==1) {?>checked<?php }?>>
											 <input type="radio" name="com_link_look" value="2" title="微信扫码模式" lay-filter="com_link_look" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_link_look']==2) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">微信扫码模式，PC和微信客户端内扫码后，会将联系方式通过配置的微信公众号发送</span>
									</div>
									<div id="ptlook" class="layui-form-item" style="<?php if ($_smarty_tpl->tpl_vars['config']->value['com_link_look']==2) {?>display: none<?php }?>">
										<div class="layui-input-block">
											<input type="radio" name="com_login_link" value="1" title="开放" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']==1) {?>checked<?php }?>>
											 <input type="radio" name="com_login_link" value="2" title="不开放" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']==2) {?>checked<?php }?>>
											 <input type="radio" name="com_login_link" value="3" title="登录后显示" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']==3) {?>checked<?php }?>>
											 <input type="radio" name="com_login_link" value="4" title="拥有简历" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']==4) {?>checked<?php }?>>
											 <input type="radio" name="com_login_link" value="5" title="投递简历" <?php if ($_smarty_tpl->tpl_vars['config']->value['com_login_link']==5) {?>checked<?php }?>>
										</div>
										<span class="admin_web_tip">若选择“开放”，则进入企业自身联系方式设置条件判断</span>
									</div>
								</td>
							</tr>

							<tr class="admin_table_trbg">
								<th width="200" class="t_fr">屏蔽企业联系方式：</th>
								<?php if (is_array($_smarty_tpl->tpl_vars['qy_rows']->value)) {?>
								<td>
									<div class="layui-form-item">
										<div class="layui-input-block">
											<input type="checkbox" name="com_link_no" value="0" lay-skin="primary" title="过期会员"
											 <?php if ($_smarty_tpl->tpl_vars['com_link_no']->value&&in_array('0',$_smarty_tpl->tpl_vars['com_link_no']->value)) {?>checked<?php }?>>
											<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['qy_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
											<input type="checkbox" name="com_link_no" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" lay-skin="primary" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
											 <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['id'],$_smarty_tpl->tpl_vars['com_link_no']->value)) {?>checked<?php }?>> <?php } ?> 
										</div>
										<span class="admin_web_tip">选中会员等级，对应的的企业联系方式即为不开放状态。</span>
									</div>
								</td>
								<?php } else { ?>
								<td>
									<div class="iradio_flat_height">暂无等级，
										<a href="index.php?m=userconfig&c=comclass" style="color:red;">添加会员等级</a>
										<input type="hidden" name="com_rating" value="0">
									</div>
								</td>
								<?php }?>

							</tr>

							<tr class="admin_table_trbg">
								<th style="border-bottom:none;" width="200">&nbsp;</th>
								<td align="left" style="border-bottom:none;">
									<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									<input class="layui-btn tty_sub" id="mconfig" type="button" name="config" value="提交" />&nbsp;&nbsp;
									<input class="layui-btn tty_cz" type="reset" value="重置" /></td>
							</tr>
						</table>
					</div>

				</div>
			</div>
			<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui.upload.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type='text/javascript'><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
>
				layui.use(['layer', 'form'], function() {
					var layer = layui.layer,
						form = layui.form,
						$ = layui.$;

					form.on('checkbox(comSearch)', function(data){
						if(!data.elem.checked){
							$("#com_status_search").prop("checked", false);
							form.render('checkbox');
						}
					}); 
					form.on('checkbox(statusSearch)', function(data){
						if(data.elem.checked){
							$("#com_search").prop("checked", true);
							form.render('checkbox');
						}
					}); 
					form.on('radio(com_link_look)', function(data){
						if(data.value == 1){
							$("#ptlook").show();
						}else{
							$("#ptlook").hide();
						}
					});
					form.on('radio(com_job_reserve)', function (data) {

						if (data.value == 1){
							$('.upJobSon').show();
						}else{
							$('.upJobSon').hide();
						}
					});
				});

				function checkInterval(obj){

					if (parseInt(obj.value) == 0){
						parent.layer.msg('请填写时间间隔！', 2, 8);
						$('#sy_reserve_refresh_interval').val(20);
						return false;
					}
				}

				$(function() {
					$("#mconfig").click(function() {

						var com_link_no = "";

						$('input[name="com_link_no"]:checked').each(function() {
							if (com_link_no == "") {
								com_link_no = $(this).val();
							} else {
								com_link_no = com_link_no + "," + $(this).val();
							}
						});

						var formdata = new FormData();

						formdata.append('config',$("#mconfig").val());
						// 审核信息
						formdata.append('com_status',$("input[name=com_status]").is(":checked") ? 0 : 1);
						formdata.append('com_job_status',$("input[name=com_job_status]").is(":checked") ? 0 : 1);
						formdata.append('com_partjob_status',$("input[name=com_partjob_status]").is(":checked") ? 0 : 1);
						formdata.append('com_cert_status',$("input[name=com_cert_status]").is(":checked") ? 1 : 0);
						formdata.append('com_logo_status',$("input[name=com_logo_status]").is(":checked") ? 1 : 2);
						formdata.append('com_show_status',$("input[name=com_show_status]").is(":checked") ? 1 : 0);
						formdata.append('com_banner_status',$("input[name=com_banner_status]").is(":checked") ? 1 : 0);
						formdata.append('com_revise_status',$("input[name=com_revise_status]").is(":checked") ? 0 : 1);
						formdata.append('com_comment_status',$("input[name=com_comment_status]").is(":checked") ? 0 : 1);
						formdata.append('com_yqmb_status',$("input[name=com_yqmb_status]").is(":checked") ? 0 : 1);
						//企业资质必传项
						formdata.append('com_social_credit',$("input[name=com_social_credit]").is(":checked") ? 1 : 0);
						formdata.append('com_cert_owner',$("input[name=com_cert_owner]").is(":checked") ? 1 : 0);
						formdata.append('com_cert_wt',$("input[name=com_cert_wt]").is(":checked") ? 1 : 0);
						formdata.append('com_cert_other',$("input[name=com_cert_other]").is(":checked") ? 1 : 0);
						// 强制操作
						formdata.append('com_enforce_info',$("input[name=com_enforce_info]").is(":checked") ? 1 : 0);
						formdata.append('com_enforce_mobilecert',$("input[name=com_enforce_mobilecert]").is(":checked") ? 1 : 0);
						formdata.append('com_enforce_emailcert',$("input[name=com_enforce_emailcert]").is(":checked") ? 1 : 0);
						formdata.append('com_enforce_licensecert',$("input[name=com_enforce_licensecert]").is(":checked") ? 1 : 0);
						formdata.append('com_enforce_setposition',$("input[name=com_enforce_setposition]").is(":checked") ? 1 : 0);
						formdata.append('com_gzgzh',$("input[name=com_gzgzh]").is(":checked") ? 1 : 0);

						// 功能开关
						formdata.append('com_message',$("input[name=com_message]").is(":checked") ? 1 : 0);
						formdata.append('sy_com_invoice',$("input[name=sy_com_invoice]").is(":checked") ? 1 : 0);
						formdata.append('com_free_status',$("input[name=com_free_status]").is(":checked") ? 1 : 0);
						formdata.append('com_job_myswitch',$("input[name=com_job_myswitch]").is(":checked") ? 1 : 0);

						formdata.append('com_job_reserve',$("input[name=com_job_reserve]:checked").val());
						formdata.append('sy_reserve_refresh_interval',$("#sy_reserve_refresh_interval").val());
						formdata.append('sy_reserve_refresh_price',$("#sy_reserve_refresh_price").val());
						formdata.append('sy_reserve_service_id',$("#sy_reserve_service_id").val());

						formdata.append('com_msg_status',$("input[name=com_msg_status]").is(":checked") ? 1 : 0);
						formdata.append('com_search',$("input[name=com_search]").is(":checked") ? 1 : 0);
						formdata.append('com_status_search',$("input[name=com_status_search]").is(":checked") ? 1 : 0);
						formdata.append('com_lietou_job',$("input[name=com_lietou_job]").is(":checked") ? 1 : 0);
						formdata.append('com_finder',$("#com_finder").val());
						formdata.append('sy_maturityday',$("#sy_maturityday").val());
						formdata.append('com_yqmb_num',$("#com_yqmb_num").val() ? $("#com_yqmb_num").val() : 0);
						formdata.append('sy_couponday',$("#sy_couponday").val());
						formdata.append('sy_com_invoice_money',$("#sy_com_invoice_money").val());

						formdata.append('joblist_top',$("input[name=joblist_top]:checked").val());
						formdata.append('hotcom_top',$("input[name=hotcom_top]:checked").val());
						formdata.append('joblock',$("input[name=joblock]:checked").val());
						formdata.append('jobunder',$("input[name=jobunder]:checked").val());
						formdata.append('com_link_look',$("input[name=com_link_look]:checked").val());
						formdata.append('com_login_link',$("input[name=com_login_link]:checked").val());
						formdata.append('com_link_no',com_link_no);
						formdata.append('pytoken',$("#pytoken").val());
						formdata.append('exa_cert_wt_files',$("input[name=file]")[0].files[0]);
						loadlayer();

						$.ajax({
					        url:'index.php?m=admin_comset&c=save',
					        type:'post',

					        processData:false,
					        contentType:false,

					        data:formdata,
					        success:function (data) {
					            parent.layer.closeAll('loading');
								config_msg(data);
					        }
					    })
						
					});
				})
			<?php echo '</script'; ?>
>
		</div>
	</form>
</body>

</html>
<?php }} ?>