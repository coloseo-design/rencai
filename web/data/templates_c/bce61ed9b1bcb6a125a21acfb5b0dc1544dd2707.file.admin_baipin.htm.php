<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-06 16:41:15
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_baipin.htm" */ ?>
<?php /*%%SmartyHeaderCode:253262c54aab203791-63987889%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bce61ed9b1bcb6a125a21acfb5b0dc1544dd2707' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_baipin.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '253262c54aab203791-63987889',
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
  'unifunc' => 'content_62c54aab238369_88662653',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c54aab238369_88662653')) {function content_62c54aab238369_88662653($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
		<title></title>
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

	</head>
	<body class="body_ifm">

		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">生成请确保/data/xml/目录有可写权限，否则无法生成。</div>
						<div class="admin_new_tip_list">在百度百聘平台，提交<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/data/xml/baidu.xml网址即可。 </div>
					</div>
				</div>
				<div class="clear"></div>

				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>
				<form target="supportiframe" action="" method="get" class="layui-form">
					<input type="hidden" id="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<input name="m" value="admin_baipin" type="hidden" />
					<input name="c" value="add" type="hidden" />
					<div class="tag_box mt10">
						<table width="100%" class="table_form ">
							<tr>
								<th width="33%">XML保存路径：</th>
								<td>
									<div class="layui-input-block">
										<div class="layui-input-inline">
											<input type="text" placeholder="请输入XML保存路径" value="/data/xml/baidu.xml" size="30" autocomplete="off" readonly="readonly" class="layui-input t_w480">
										</div>
									</div>
								</td>
							</tr>
							<tr class="admin_table_trbg">
								<td class="ud" align="center" colspan="2">
									<input class="layui-btn tty_sub" type="submit" id='madeindex' name="madeall" value="生成XML" />
								</td>
							</tr>
						</table>

					</div>
				</form>
			</div>
		</div>
		<?php echo '<script'; ?>
 language="javascript">
			layui.use(['layer', 'form', 'element', 'laydate'], function() {
				var layer = layui.layer,
					form = layui.form,
					laydate = layui.laydate,
					element = layui.element,
					$ = layui.$;
				//日期
				laydate.render({
					elem: '#time',
					range: '~'
				});
			}); //end layui.use()

			$(document).ready(function() {
				$("#madeindex").click(function() {
					var ii = parent.layer.load("正在生成...", 0);
				});
			})
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
