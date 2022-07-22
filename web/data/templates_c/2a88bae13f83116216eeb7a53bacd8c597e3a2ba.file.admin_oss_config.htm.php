<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:28:48
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_oss_config.htm" */ ?>
<?php /*%%SmartyHeaderCode:487462d91c504f17e0-23493568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a88bae13f83116216eeb7a53bacd8c597e3a2ba' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_oss_config.htm',
      1 => 1645276390,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '487462d91c504f17e0-23493568',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'oss_data' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91c50554704_70548078',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91c50554704_70548078')) {function content_62d91c50554704_70548078($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<link href="../js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
 src="../js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="../js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/javascript"><?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">

				<div class="clear"></div>

				<style type="text/css">
					.layui-form-switch {
						margin-top: 0;
					}
				</style>

				<div>
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form method="post" target="supportiframe" action="index.php?m=admin_oss_config&c=save" onsubmit="return checkForm();"
					 class="layui-form">
						<table width="100%" class="table_form">

							<tr>
								<th width="160">阿里云OSS存储：</th>
								<td>
									<div class="layui-input-block">
										<input type="checkbox" name="sy_oss" lay-skin="switch" lay-text="开启|关闭" lay-filter="oss" <?php if ($_smarty_tpl->tpl_vars['config']->value['sy_oss']=="1") {?>checked<?php }?>/> <span class="admin_web_tip" style="margin-left: 10px;">关闭时文件上传到网站服务器，开启后网站文件将上传到阿里云OSS</span>
									</div>
								</td>
							</tr>
							<tr>
								<th width="160" class="t_fr">OSS存储地址：</th>
								<td>
									<div class="layui-input-block t_w480">
										<input name="sy_ossurl" id="sy_ossurl" autocomplete="off" class="layui-input" type="text" value="<?php if ($_smarty_tpl->tpl_vars['oss_data']->value['userdomain']) {
echo $_smarty_tpl->tpl_vars['oss_data']->value['userdomain'];
} else {
echo $_smarty_tpl->tpl_vars['config']->value['sy_ossurl'];
}?>" size="50" />
									</div>
									<span class="admin_web_tip">提示：阿里云OSS远程存储地址, 如https://img.weitenet.com</span>
								</td>
							</tr>

							<tr>
								<th width="160">Access Key ID：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input name="access_id" id="access_id" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['oss_data']->value['access_id'];?>
"
											 size="50" />
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<th width="160">Access Key Secret：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input name="access_key" id="access_key" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['oss_data']->value['access_key'];?>
"
											 size="50" />
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th width="160">EndPoint：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline t_w480">
											<input name="endpoint" id="endpoint" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['oss_data']->value['endpoint'];?>
"
											 size="50" />
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th width="160" class="t_fr">Bucket：</th>
								<td>
									<div class="layui-input-block t_w480">
										<input name="bucket" id="bucket" autocomplete="off" class="layui-input" type="text" value="<?php echo $_smarty_tpl->tpl_vars['oss_data']->value['bucket'];?>
"
										 size="50" />
									</div>
									<span class="admin_web_tip">提示：存储空间名称</span>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<th>&nbsp;</th>
								<td>
									<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
									<input class="layui-btn tty_sub" name="oss_config" type="submit" value="提交" />&nbsp;&nbsp;
									<input class="layui-btn tty_cz" type="reset" value="重置" />
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;
			});

			function checkForm() {
				var sy_oss = $("input[name=sy_oss]").is(":checked") ? 1 : 2;
				var sy_ossurl = $("#sy_ossurl").val();
				if (sy_oss == 1 && sy_ossurl == '') {
					parent.layer.msg('请填写阿里云OSS地址', 2, 8);
					return false;
				}
				loadlayer();
			}
		<?php echo '</script'; ?>
>

	</body>
</html>
<?php }} ?>
