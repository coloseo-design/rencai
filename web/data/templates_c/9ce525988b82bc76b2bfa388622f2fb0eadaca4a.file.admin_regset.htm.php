<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:22:06
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_regset.htm" */ ?>
<?php /*%%SmartyHeaderCode:2808962c7e92e52ff02-35063708%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ce525988b82bc76b2bfa388622f2fb0eadaca4a' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_regset.htm',
      1 => 1643012867,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2808962c7e92e52ff02-35063708',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'rows' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e92e5d2e00_01057271',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e92e5d2e00_01057271')) {function content_62c7e92e5d2e00_01057271($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="../js/jquery-1.8.0.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet">
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
		<form class="layui-form">
			<div class="infoboxp">
				<div class="tty-tishi_top">
					<div class="admin_new_tip">
						<a href="javascript:;" class="admin_new_tip_close"></a>
						<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
						<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
						<div class="admin_new_tip_list_cont">
							<div class="admin_new_tip_list">该页面展示了网站的注册设置信息，可对注册设置操作。</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="tag_box">
						<div>
							<table width="100%" class="table_form">

								<tr>
									<th width="160">网站开启注册：</th>
									<td>
										<div class="layui-input-block">
											<input name="reg_user_stop" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_user_stop']=="1") {?> checked <?php }?> lay-skin="switch"
											 lay-text="开启|关闭" type="checkbox" />
										</div>
									</td>
								</tr>
								<tr class="">
									<th width="160">注册方式：</th>
									<td>
										<div class="layui-input-inline fl">
											<input name="sy_reg_type" value="1" title="先注册，后选身份" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_reg_type']=="1") {?> checked <?php }?> type="radio" />
											<input name="sy_reg_type" value="2" title="先选身份，后注册" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_reg_type']=="2") {?> checked <?php }?> type="radio" />
										</div>
										<span class="admin_web_tip fl ml30">默认保持原有注册方式</span>
									</td>
								</tr>
								<tr>
									<th width="160" class="t_fl">注册类型：</th>
									<td>
										<div class="layui-input-inline">
											<input name="reg_moblie" title="手机注册" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_moblie']=="1") {?> checked <?php }?> />
											<input name="reg_email" title="邮箱注册" type="checkbox" lay-skin="primary"  <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_email']=="1") {?> checked <?php }?> />
											<input id="reg_user" name="reg_user" title="用户名注册" type="checkbox" lay-skin="primary" lay-filter="reg_user"  <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_user']=="1") {?> checked <?php }?>/>
										</div>
									</td>
								</tr>
								<tr>
									<th width="160" class="t_fl">注册设置：</th>
									<td>
										<div class="layui-input-inline">
											<input name="reg_passconfirm" title="密码确认" type="checkbox" lay-skin="primary" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_passconfirm']=="1") {?> checked <?php }?>/>
											<input name="reg_real_name_check" title="实名认证" type="checkbox" lay-skin="primary"  <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_real_name_check']=="1") {?> checked <?php }?>/>
										</div>
									</td>
								</tr>								
								<tr id="namelenDiv" class="admin_table_trbg <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_user']!='1') {?> none<?php }?>">
									<th width="160" class="t_fl">用户名长度：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline">
												<input name="sy_reg_nameminlen" id="sy_reg_nameminlen" autocomplete="off" class="tty_input t_w100" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reg_nameminlen'];?>
"
												 size="63" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">—
												<input name="sy_reg_namemaxlen" id="sy_reg_namemaxlen" autocomplete="off" class="tty_input t_w100" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reg_namemaxlen'];?>
"
												 size="63" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
											</div>&nbsp;&nbsp;位
										</div>
									</td>
								</tr>
								<tr id="namecomplexDiv" class="admin_table_trbg <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_user']!='1') {?> none<?php }?>">
									<th width="160" class="t_fl">用户名复杂度：</th>
									<td>
										<div class="layui-input-block">
										<div class="layui-input-inline">

										    <input type="checkbox" name="reg_name_num" lay-skin="primary" title="数字" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_name_num']=="1") {?> checked <?php }?> >
											<div class="layui-unselect layui-form-checkbox  layui-form-checked" lay-skin="primary">
												<span>数字</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
											<input type="checkbox" name="reg_name_zm" lay-skin="primary" title="字母" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_name_zm']=="1") {?> checked <?php }?>>
											<div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
												<span>字母</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
											<input type="checkbox" name="reg_name_sp" lay-skin="primary" title="其它符号@!#.$-_" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_name_sp']=="1") {?> checked <?php }?>>
											<div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
												<span>其它符号@!#.$-_</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
										</div>
										<span class="admin_web_tip">提示：设置必须包含的项。</span>
										</div>
									</td>

								</tr>
								<tr id="pwcomplexDiv" class="admin_table_trbg">
									<th width="160" class="t_fl">密码复杂度：</th>
									<td>
										<div class="layui-input-block">
										<div class="layui-input-inline">
											
										    <input type="checkbox" name="reg_pw_num" lay-skin="primary" title="数字" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_pw_num']=="1") {?> checked <?php }?> >
											<div class="layui-unselect layui-form-checkbox  layui-form-checked" lay-skin="primary">
												<span>数字</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
											<input type="checkbox" name="reg_pw_zm" lay-skin="primary" title="字母" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_pw_zm']=="1") {?> checked <?php }?>>
											<div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
												<span>字母</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
											<input type="checkbox" name="reg_pw_sp" lay-skin="primary" title="其它符号@!#.$-_" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_pw_sp']=="1") {?> checked <?php }?>>
											<div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin="primary">
												<span>其它符号@!#.$-_</span>
												<i class="layui-icon layui-icon-ok"></i>
											</div>
										</div>
										<span class="admin_web_tip">提示：设置必须包含的项。</span>
										</div>
									</td>

								</tr>


								<tr class="admin_table_trbg">
									<th width="160" class="t_fl">注册赠送优惠券：</th>
									<td>
										<div class="layui-input-block t_w480">
											<select name="reg_coupon" lay-filter="reg_coupon" id="reg_coupon">
												<option value="0">请选择</option>
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['config']->value['reg_coupon']==$_smarty_tpl->tpl_vars['v']->value['id']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>

												</option> <?php } ?> 
											</select> 
										</div> 
										<span class="admin_web_tip">优惠券金额和使用规则在（运营-优惠券-优惠券）里设置和修改</span>
									</td>
								</tr>
								<tr>
									<th width="160" class="t_fl">邮件默认后缀：</th>
									<td>
										<div class="layui-input-block t_w480">
											<textarea name="sy_def_email" id="sy_def_email" rows="3" cols="50" class="web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_def_email'];?>
</textarea>
										</div>
										<span class="admin_web_tip">多个用|(竖线)隔开,例：@qq.com|@163.com</span>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th width="160" class="t_fl">同一IP注册间隔：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_reg_interval" id="sy_reg_interval" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reg_interval'];?>
"
												 size="63" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
											</div>
											&nbsp;&nbsp;小时
										</div>
										<span class="admin_web_tip">提示：0为不限，其他数字为间隔时间。</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="160" class="t_fl">邀请注册限制：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input name="sy_reg_invite" id="sy_reg_invite" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_reg_invite'];?>
"
												 size="63" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
											</div>
											&nbsp;&nbsp;次 
										</div>
										<span class="admin_web_tip">提示：每个账户每天邀请注册上限，0为不限，仅限制邮件邀请，防止恶意利用。</span>

									</td>
								</tr>
								<tr>
									<th width="160" class="t_fl">限制注册用户名：</th>
									<td>
										<div class="layui-input-block t_w480">
											<textarea name="sy_regname" id="sy_regname" rows="3" cols="50" class="admin_comdit_textarea web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_regname'];?>
</textarea>
										</div>
										<span class="admin_web_tip">多个请用,(半角逗号)隔开。</span>
									</td>
								</tr>


								<tr>
									<th width="160" class="t_fl">限制注册手机号：</th>
									<td>
										<div class="layui-input-block">
											<textarea name="sy_web_mobile" id="sy_web_mobile" rows="3" cols="50" class="admin_comdit_textarea web_text_textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['sy_web_mobile'];?>
</textarea>
										</div>
										<span class="admin_web_tip">注册手机号(恶意攻击)用分号隔开,例:13141589203;18261151514</span>
									</td>
								</tr>

								<tr>
									<th>&nbsp;</th>
									<td align="left">
										<input class="tty_sub" id="regconfig" type="button" name="mapconfig" value="提交" />&nbsp;&nbsp;
										<input class="tty_cz" type="reset" value="重置" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
						</div>
					</div>
				</div>
				<?php echo '<script'; ?>
>
					layui.use(['form'], function() {
						var form = layui.form,
							$ = layui.$;

						form.on('checkbox(reg_user)', function(data){
						  
							if(data.elem.checked){
								$('#namelenDiv').fadeIn();
								$('#namecomplexDiv').fadeIn();
								
							}else{
								$('#namelenDiv').fadeOut();
								$('#namecomplexDiv').fadeOut();
							}
						  
						});  
					});

					$(function() {
						var sy_email_set = '<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_email_set'];?>
';
						$("#regconfig").click(function() {
							if ($("input[name=reg_moblie]").is(":checked")) {
								if (!"<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_appkey'];?>
" || !"<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_appsecret'];?>
"  || "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_msg_isopen'];?>
" != '1') {
									layer.msg("还没有配置短信，请先配置！", 2, 8, function() {
										location.reload();
									});
									return false;
								}
							}
							if ($("input[name=reg_email]").is(":checked")) {
								if (sy_email_set != '1') {
									layer.msg("还没有配置邮箱，请先配置！", 2, 8, function() {
										location.reload();
									});
									return false;
								}
							}

							var reg_mobile = $("input[name=reg_moblie]").is(":checked") ? 1 : 0,
								reg_email = $("input[name=reg_email]").is(":checked") ? 1 : 0,
								reg_user = $("input[name=reg_user]").is(":checked") ? 1 : 0,
								reg_user_stop = $("input[name=reg_user_stop]").is(":checked") ? 1 : 0;
							if (reg_user_stop == 1 && reg_user == 0 && reg_mobile == 0 && reg_email == 0) {
								layer.msg('开启网站注册时，‘手机注册’、‘email注册’、‘用户名注册’最少应开启一项!', 5, 8);
								return false;
							}
							if(reg_user){
								var namemaxlen = $("#sy_reg_namemaxlen").val() ? parseInt($("#sy_reg_namemaxlen").val()) : 0;
								var nameminlen = $("#sy_reg_nameminlen").val() ? parseInt($("#sy_reg_nameminlen").val()) : 0;
								if(nameminlen==0 || namemaxlen==0){
									layer.msg('用户名长度需大于0!', 5, 8);return false;
								}else if(namemaxlen <= nameminlen){
									layer.msg('用户名长度最大值应大于最小值!', 5, 8);return false;
								}
							}
							loadlayer();
							$.post("index.php?m=regset&c=save", {
								sy_reg_type: $("input[name=sy_reg_type]:checked").val(),
								reg_moblie: $("input[name=reg_moblie]").is(":checked") ? 1 : 0,
								reg_email: $("input[name=reg_email]").is(":checked") ? 1 : 0,
								reg_user: $("input[name=reg_user]").is(":checked") ? 1 : 0,
								reg_passconfirm: $("input[name=reg_passconfirm]").is(":checked") ? 1 : 0,
								reg_user_stop: $("input[name=reg_user_stop]").is(":checked") ? 1 : 0,
								reg_real_name_check: $("input[name=reg_real_name_check]").is(":checked") ? 1 : 0,
									

								reg_name_num: $("input[name=reg_name_num]").is(":checked") ? 1 : 0,
								reg_name_zm: $("input[name=reg_name_zm]").is(":checked") ? 1 : 0,
								reg_name_sp: $("input[name=reg_name_sp]").is(":checked") ? 1 : 0,
								reg_name_han: $("input[name=reg_name_han]").is(":checked") ? 1 : 0,
								sy_reg_namemaxlen: $("#sy_reg_namemaxlen").val() ? $("#sy_reg_namemaxlen").val() : 0,
								sy_reg_nameminlen: $("#sy_reg_nameminlen").val() ? $("#sy_reg_nameminlen").val() : 0,

								reg_pw_num: $("input[name=reg_pw_num]").is(":checked") ? 1 : 0,
								reg_pw_zm: $("input[name=reg_pw_zm]").is(":checked") ? 1 : 0,
								reg_pw_sp: $("input[name=reg_pw_sp]").is(":checked") ? 1 : 0,

								reg_coupon: $("#reg_coupon").val(),
								sy_regname: $("#sy_regname").val(),
								sy_def_email: $("#sy_def_email").val(),
								sy_web_mobile: $("#sy_web_mobile").val(),
								sy_reg_interval: $("#sy_reg_interval").val(),
								sy_reg_invite: $("#sy_reg_invite").val(),
								config: $("#regconfig").val(),
								pytoken: $("#pytoken").val()
							}, function(data, textStatus) {
								parent.layer.closeAll('loading');
								config_msg(data);
							});
						});

						
					});
				<?php echo '</script'; ?>
>
			</div>
		</form>
	</body>
</html>
<?php }} ?>
