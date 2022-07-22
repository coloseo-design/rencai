<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:14:09
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_member_useradd.htm" */ ?>
<?php /*%%SmartyHeaderCode:3003062d8fcc1711931-63642159%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee4b635a2a70f7b9b4c34a9140e0675ac596b608' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_member_useradd.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3003062d8fcc1711931-63642159',
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
  'unifunc' => 'content_62d8fcc1799c67_67582277',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fcc1799c67_67582277')) {function content_62d8fcc1799c67_67582277($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<div class="infoboxp">


			<div class="tty-tishi_top"> 
				<div style="padding:0px 0 20px 0;">
					<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
					<form class="layui-form" action="index.php?m=user_member&c=save" method="post" target="supportiframe" onsubmit="return checkForm()" autocomplete="off">
						<div class="admin_bold_box">
							<div class="admin_bold">会员信息</div>
						</div>
						
						<div class="admin_add_list">
							<div class="admin_add_list_name">用&nbsp;户&nbsp; 名</div>
							<div class="admin_add_list_right">
								<input type="text" value="" id="username" name="username" class="layui-input t_w480">
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">设置密码</div>

							<div class="admin_add_list_right">
								<input type="password" value="" id="password" name="password" class="layui-input t_w480">
								<font color="gray"></font>
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">联系邮箱</div>

							<div class="admin_add_list_right">
								<input type="text" value="" name="email" class="layui-input t_w480">
								<font color="gray"></font>
							</div>
						</div>
						<div class="admin_add_list">
							<div class="admin_add_list_name">联系手机</div>

							<div class="admin_add_list_right">
								<input type="text" value="" id="moblie" name="moblie" class="layui-input t_w480">
								<font color="gray"></font>
							</div>
						</div>
						<div class="admin_add_list">
							<input class="tty_sub" type="submit" name="submit" value="&nbsp;添 加&nbsp;" />
							<input class="tty_cz" type="reset" name="reset" value="&nbsp;重 置 &nbsp;" /></td>

						</div>
						<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					</form>
				</div>
			</div>
		</div>
		<?php echo '<script'; ?>
 type="text/javascript">
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					form = layui.form,
					$ = layui.$;

			});
			
			function checkForm(){
				if($.trim($("#username").val()) == ''){
					parent.layer.msg("用户名不能为空！", 2, 8);
					return false;
				}else if($.trim($("#password").val()) == ''){
					parent.layer.msg("密码不能为空！", 2, 8);
					return false;
				}else if($.trim($("#moblie").val()) == ''){
					parent.layer.msg("手机号不能为空！", 2, 8);
					return false;
				}
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
