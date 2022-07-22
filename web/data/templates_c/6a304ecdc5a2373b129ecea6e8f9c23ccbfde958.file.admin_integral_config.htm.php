<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-08 16:22:05
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_integral_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:875362c7e92d440e32-47258194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a304ecdc5a2373b129ecea6e8f9c23ccbfde958' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_integral_config.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '875362c7e92d440e32-47258194',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62c7e92d4e0a15_30053439',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c7e92d4e0a15_30053439')) {function content_62c7e92d4e0a15_30053439($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title>后台管理</title>
	</head>
	<style>
		.tty_input{margin-right: 0;}
	</style>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="tabs_info">
					<ul>
						<li class="curr"><a href="index.php?m=integral"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
设置</a></li>
						<li class=""><a href="index.php?m=integral&c=user">个人<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a></li>
						<li class=""> <a href="index.php?m=integral&c=com">企业<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a></li>
						<li class=""> <a href="index.php?m=integral&c=lt">猎头<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a></li>
						<li class=""> <a href="index.php?m=integral&c=train">培训<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</a></li>
						<li class=""> <a href="index.php?m=integral&c=class"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
优惠</a></li>
					</ul>
				</div>
				<div class="clear"></div>
			<form class="layui-form">
					<div class="tag_box">
						<div>
							<table width="100%" class="table_form">
								<tr class="admin_table_trbg">
									<th width="220" class="t_fr"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
代替词：</th>
									<td>
										<input class="layui-input t_w480" type="text" name="integral_pricename" id="integral_pricename" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
" size="20" maxlength="255" />
										<span class="admin_web_tip">默认为<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
，例：金币</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr">最低充值<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</th>
									<td>
										<input class="layui-input t_w480" type="text" name="integral_min_recharge" id="integral_min_recharge" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_min_recharge'];?>
" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" size="20" maxlength="255" />
										<span class="admin_web_tip">0 表示不限</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr">赏金转换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
次数：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input class="layui-input" type="text" name="paypack_max_recharge" id="paypack_max_recharge" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['paypack_max_recharge'];?>
" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" size="20" maxlength="255" />
											</div> &nbsp;&nbsp;次/日
										</div>
										<span class="admin_web_tip">0 表示不限</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr">赏金转换<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
最低金额：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input class="layui-input" type="text" name="packprice_min_recharge" id="packprice_min_recharge"  value="<?php echo $_smarty_tpl->tpl_vars['config']->value['packprice_min_recharge'];?>
" size="20" maxlength="255" />
											 </div> &nbsp;&nbsp;元
										 </div>
										<span class="admin_web_tip">0 表示不限</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr">最低充值金额：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input class="layui-input" type="text" name="money_min_recharge" id="money_min_recharge" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['money_min_recharge'];?>
" size="20" maxlength="255" />
											</div> &nbsp;&nbsp;元
										</div>
										<span class="admin_web_tip">0 表示不限</span>
									</td>
								</tr>
								<tr class="admin_table_trbg">
									<th width="220" class="t_fr"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
单位：</th>
									<td>
										<input class="layui-input t_w480" type="text" name="integral_priceunit" id="integral_priceunit" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];?>
" size="20" maxlength="255" />
										<span class="admin_web_tip">默认为点，例：个，位</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr"><?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
兑换比例：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input class="layui-input" type="text" name="integral_proportion" id="integral_proportion" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_proportion'];?>
" size="20" maxlength="255" /> 
											</div>  &nbsp;&nbsp;点
										</div>
										<span class="admin_web_tip">例：1元=30点<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
</span>
									</td>
								</tr>
								<tr>
									<th width="220" class="t_fr">每日签到送<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
：</th>
									<td>
										<div class="layui-input-block">
											<div class="layui-input-inline t_w480">
												<input class="layui-input" type="text" name="integral_signin" id="integral_signin" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_signin'];?>
" size="20" maxlength="255"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											</div> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
										<span class="admin_web_tip">第六日起，获得<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
将翻倍。</span>
									</td>
								</tr>
								<tr class="admin_com_td_bg">
									<th width="220" class="t_fr">会员注册：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_reg" id="integral_reg" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_reg'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr>
									<th width="220">每天第一次登录：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_login" id="integral_login" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_login'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>

								<tr class="admin_com_td_bg">
									<th width="220">完善基本资料：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_userinfo" id="integral_userinfo" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_userinfo'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr>
									<th width="220">邮箱认证：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_emailcert" id="integral_emailcert" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_emailcert'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr class="admin_com_td_bg">
									<th width="220">手机认证：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_mobliecert" id="integral_mobliecert" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_mobliecert'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr>
									<th width="220">上传头像：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_avatar" id="integral_avatar" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_avatar'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr class="admin_com_td_bg">
									<th width="220">发布问题：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_question" id="integral_question" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_question'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>

								<tr>
									<th width="220">回答问题：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_answer" id="integral_answer" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_answer'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" /> &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr class="admin_com_td_bg">
									<th width="220">评论回答：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_answerpl" id="integral_answerpl" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_answerpl'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>
								<tr>
									<th width="220">邀请注册：</th>
									<td>
										<div class="layui-input-block">
											<input class="tty_input t_w480" type="text" name="integral_invite_reg" id="integral_invite_reg" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_invite_reg'];?>
" size="13" maxlength="255" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
											&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_priceunit'];
echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>

										</div>
									</td>
								</tr>

								<tr class="admin_table_trbg">
									<th>&nbsp;</th>
									<td align="left">
										<input class="tty_sub" id="integral" type="button" name="config" value="提交" />&nbsp;&nbsp;
										<input class="tty_cz" type="reset" value="重置" />
									</td>
								</tr>
							</table>
						</div>

					</div>
				</div>
		</div>
		<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
		<?php echo '<script'; ?>
>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			$(function() {
				$("#integral").click(function() {
					loadlayer();
					$.post("index.php?m=integral&c=save", {
						config: $("#integral").val(),
						integral_pricename: $("#integral_pricename").val(),
						integral_priceunit: $("#integral_priceunit").val(),
						integral_min_recharge: $("#integral_min_recharge").val(),
						money_min_recharge: $("#money_min_recharge").val(),
						paypack_max_recharge: $("#paypack_max_recharge").val(),
						packprice_min_recharge: $("#packprice_min_recharge").val(),
						integral_proportion: $("#integral_proportion").val(),
						integral_signin: $("#integral_signin").val(),
 						integral_reg: $("#integral_reg").val(),
 						integral_login: $("#integral_login").val(),
 						integral_userinfo: $("#integral_userinfo").val(),
						integral_emailcert: $("#integral_emailcert").val(),
						integral_mobliecert: $("#integral_mobliecert").val(),
						integral_avatar: $("#integral_avatar").val(),
 						integral_question: $("#integral_question").val(),
 						integral_answer: $("#integral_answer").val(),
 						integral_answerpl: $("#integral_answerpl").val(),
 						integral_invite_reg: $("#integral_invite_reg").val(),
						pytoken: $("#pytoken").val()
					}, function(data, textStatus) {
						parent.layer.closeAll('loading');
						config_msg(data);
					});
				});
			})
		<?php echo '</script'; ?>
>
		</form>
	</body>
</html>
<?php }} ?>
