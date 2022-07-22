<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:23:04
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_lt_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:1401162c7e96884b9b9-47509275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ecf1406ecb88beff4e1dab59b3653788b7633db2' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_lt_config.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1401162c7e96884b9b9-47509275',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'lt_single_can' => 0,
    'lt_rows' => 0,
    'v' => 0,
    'lt_rating_add' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e9688f9563_90755161',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e9688f9563_90755161')) {function content_62c7e9688f9563_90755161($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<link href="images/reset.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/system.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="images/table_form.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">
		
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		
		<title>后台管理</title>
	</head>

	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="tabs_info">
					<ul>
						<li class="curr"><a href="index.php?m=admin_ltset">猎头设置</a></li> 
						<li><a href="index.php?m=admin_ltset&c=logo">头像设置</a></li> 
					</ul>
				</div>

				<div class="clear"></div>
		  
				<div id="subboxdiv" style="width:100%;height:100%;display:none;position:absolute;"></div>
				
				<div class="tag_box">
					<div>
						<form class="layui-form">
							<table width="100%" class="table_form">

								<tr>
									<th width="220" style="float: left;">审核信息：</th>
									<td>
										<div class="layui-input-block" style="width: 550px;">
											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_status" title="猎头会员" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_status']=='0') {?>checked<?php }?> />
											</div>
											
											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_logo_status" title="猎头头像" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_logo_status']=='1') {?>checked<?php }?> />
											</div>

											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_job_status" title="发布职位" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_job_status']=='0') {?>checked<?php }?> />
											</div>

											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_cert_status" title="猎头认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_cert_status']=='1') {?>checked<?php }?> />
											</div>

										</div>
									</td>
								</tr>
									
								<tr>
									<th width="220" style="float: left;">强制操作：</th>
									<td>
										<div class="layui-input-block" style="width: 550px;">
											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_enforce_info" title="完善信息" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_enforce_info']=='1') {?>checked<?php }?> />
											</div>

											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_enforce_mobilecert" title="手机认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_enforce_mobilecert']=='1') {?>checked<?php }?> />
											</div>

											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_enforce_emailcert" title="邮箱认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_enforce_emailcert']=='1') {?>checked<?php }?> />
											</div>

											<div class="layui-input-inline" style="margin:0 20px 14px 0;">
												<input name="lt_enforce_licensecert" title="猎头认证" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_enforce_licensecert']=='1') {?>checked<?php }?> />
											</div>
											
										</div>
									</td>
								</tr>
								<tr>
									<th width="220" style="float: left;">单独购买：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline" style="margin: 0px 20px 14px 0;">
												<input type="checkbox" class="singleCtr" name="lt_single_can[]" value="issuejob" lay-skin="primary" title="发布职位" <?php if (in_array("issuejob",$_smarty_tpl->tpl_vars['lt_single_can']->value)) {?> checked <?php }?> >
												
											</div>
											
											<div class="layui-input-inline" style="margin: 0px 20px 14px 0;">
												<input type="checkbox" class="singleCtr" name="lt_single_can[]" value="sxjob" lay-skin="primary" title="刷新职位" <?php if (in_array("sxjob",$_smarty_tpl->tpl_vars['lt_single_can']->value)) {?> checked <?php }?>>
												
											</div>
											
											<div class="layui-input-inline" style="margin: 0px 20px 14px 0;">
												<input type="checkbox" class="singleCtr" name="lt_single_can[]" value="downresume" lay-skin="primary" title="下载简历" <?php if (in_array("downresume",$_smarty_tpl->tpl_vars['lt_single_can']->value)) {?> checked <?php }?>>
											</div>
											<div class="layui-input-inline" style="margin: 0px 20px 14px 0;">
												<input type="checkbox" class="singleCtr" name="lt_single_can[]" value="chat" lay-skin="primary" title="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_chat_name'];?>
" <?php if (in_array("chat",$_smarty_tpl->tpl_vars['lt_single_can']->value)) {?> checked <?php }?>>
											</div>
										</div>
										<span class="admin_web_tip">提示：已选中的项目可以在套餐外单独使用金额、积分等购买，未选中则必须购买相应的套餐或增值包。</span>
									</td>

								</tr>
								<tr>
									<th width="220">推荐人才返利：</th>
									<td>
										<input type="checkbox" name="lt_rec_rebates" id="lt_rec_rebates" lay-filter="ltRecRebates" lay-skin="switch" lay-text="开启|关闭" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_rec_rebates']=="1") {?> checked <?php }?> />
									</td>
								</tr>
								
								<tr class="admin_table_trbg" id='rebates_name' <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_rec_rebates']==0) {?>style="display:none"<?php }?>>
									<th width="220" class="t_fl">返利单位：</th>
									<td>
										<input type="text " name="lt_rebates_name" class="layui-input t_w480" id="lt_rebates_name" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['lt_rebates_name'];?>
" >
										<span class="admin_web_tip">提示：默认为元，例：金币</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fl">购买会员套餐累加：</th>
									<?php if (is_array($_smarty_tpl->tpl_vars['lt_rows']->value)) {?>
									<td>
										<div class="layui-form-item">
											<div class="layui-input-block">
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lt_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
												<input type="checkbox" name="lt_rating_add" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" lay-skin="primary" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
"
													   <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['id'],$_smarty_tpl->tpl_vars['lt_rating_add']->value)) {?>checked<?php }?>> <?php } ?>
											</div>
											<span class="admin_web_tip">当前会员套餐未到期，购买新会员，选中的套餐数据按累加计算（套餐数量和套餐时间）。</span>
										</div>
									</td>
									<?php } else { ?>
									<td>
										<div class="iradio_flat_height">
											暂无等级，
											<a href="index.php?m=userconfig&c=comclass" style="color:red;">添加会员等级</a>
											<input type="hidden" name="com_rating" value="0">
										</div>
									</td>
									<?php }?>
								</tr>
								<tr>
									<th width="220">猎头注册默认等级：</th>
									<?php if (is_array($_smarty_tpl->tpl_vars['lt_rows']->value)) {?>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline">
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lt_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
														<input name="lt_rating" id="lt_rating_0"  value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_rating']==$_smarty_tpl->tpl_vars['v']->value['id']) {?> checked <?php }?> type="radio"/>
													<?php } ?>
												</div>
											</div>
										</td>
									<?php } else { ?>
										<td>
											暂无等级，<a href="index.php?m=userconfig&c=comclass" style="color:red;">添加会员等级</a>
											<input type="hidden" name="com_rating" value="0">
										</td>
									<?php }?>
								</tr>
								<tr>
									<th width="220" class="t_fl">猎头会员到期后默认为：</th>
									<?php if (is_array($_smarty_tpl->tpl_vars['lt_rows']->value)) {?>
										<td>
											<div class="layui-input-block">
												<div class="layui-input-inline">		
													<select name="lt_vip_done" id="lt_vip_done">
													<option value="0">过期会员</option>
													<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lt_rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['config']->value['lt_vip_done']==$_smarty_tpl->tpl_vars['v']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
													<?php } ?>
													</select>  
												</div>
											</div>
											<span class="admin_web_tip">如设置的不是过期会员，用户现有会员等级到期后按选择的等级设置套餐数量、到期时间</span>
										</td>
									<?php } else { ?>
										<td>
											暂无等级，<a href="index.php?m=userconfig&c=comclass" style="color:red;">添加会员等级</a>
											<input type="hidden" name="com_rating" value="0">
										</td>
									<?php }?>
								</tr>
								<tr class="admin_table_trbg">
									<th style="border-bottom:none;">&nbsp;</th>
									<td align="left" style="border-bottom:none;"> 
										<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
										<input class="tty_sub" id="ltconfig" type="button" name="config" value="提交" />&nbsp;&nbsp;
										<input class="tty_cz" type="reset" value="重置" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function(){
				var layer = layui.layer
					,form = layui.form
					,$ = layui.$;

				form.on('switch(ltRecRebates)', function(data) {
					if(data.elem.checked) {
						$('#rebates_name').show();
					}else{
						$('#rebates_name').hide();
					}
				});
			});

			$(function(){
				$("#ltconfig").click(function(){

					var lt_single_can = [], lt_rating_add = '';

					$('.singleCtr').each(function(){
						if($(this).is(":checked")){
							lt_single_can.push($(this).val());
						}
					})

					$('input[name="lt_rating_add"]:checked').each(function() {
						if(lt_rating_add == "") {
							lt_rating_add = $(this).val();
						} else {
							lt_rating_add = lt_rating_add + "," + $(this).val();
						}
					});
					
					loadlayer();
					$.post("index.php?m=admin_ltset&c=save",{
						
						config : $("#ltconfig").val(),
						pytoken : $("#pytoken").val(),

						lt_status : $("input[name=lt_status]").is(":checked") ? 0:1,
						lt_logo_status : $("input[name=lt_logo_status]").is(":checked") ? 1:0,
						lt_job_status : $("input[name=lt_job_status]").is(":checked") ? 0:1,
						lt_cert_status : $("input[name=lt_cert_status]").is(":checked") ? 1:0,

						lt_enforce_info : $("input[name=lt_enforce_info]").is(":checked") ? 1:0,
						lt_enforce_emailcert : $("input[name=lt_enforce_emailcert]").is(":checked") ? 1:0,
						lt_enforce_mobilecert : $("input[name=lt_enforce_mobilecert]").is(":checked") ? 1:0,
						lt_enforce_licensecert : $("input[name=lt_enforce_licensecert]").is(":checked") ? 1:0,
						lt_vip_done: $("#lt_vip_done").val(),
						
						lt_rec_rebates : $("input[name=lt_rec_rebates]").is(":checked") ? 1:0,
						lt_rebates_name : $("#lt_rebates_name").val(),
						lt_rating : $("input[name=lt_rating]:checked").val(),
						lt_single_can:lt_single_can,
						lt_rating_add:lt_rating_add

					},function(data,textStatus){
						parent.layer.closeAll('loading');
						config_msg(data);
					});
				});

				$("input[name='lt_rec_rebates']").click(function(){

					$("#rebates_name").toggle();
				});

			})
		<?php echo '</script'; ?>
>
</body>
</html><?php }} ?>
