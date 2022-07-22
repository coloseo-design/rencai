<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:09:17
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_excel.htm" */ ?>
<?php /*%%SmartyHeaderCode:1429262d909ad5f3e30-84375201%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78eb46b8c9a0af1604e608a5164d8b71af60d4e5' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_excel.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1429262d909ad5f3e30-84375201',
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
  'unifunc' => 'content_62d909ad67a0e8_16754452',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d909ad67a0e8_16754452')) {function content_62d909ad67a0e8_16754452($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
 src="js/admin_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" language="javascript"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="js/show_pub.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<title>后台管理</title>
	</head>
	<body class="body_ifm">
		<div class="infoboxp">
			<div class="tty-tishi_top">
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">请按照范本格式上传 xls文件，其他文件无法读取。</div>
					</div>
				</div>
				<div class="clear"></div>

				<iframe id="supportiframe" name="supportiframe" onload="returnmessage('supportiframe');" style="display:none"></iframe>

				<form name="resume" action="index.php?m=excel&c=resume" method="post" target="supportiframe" encType="multipart/form-data"
				 onSubmit="return tcdiv('resume');">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table width="100%" class="table_form">

						<tr id="photo">
							<th width="160">上传个人简历数据：</th>
							<td>
								<input type="file" name="excel" value="" class="">
								<input class="subbut" type="submit" name="link_add" value="&nbsp;开始导入&nbsp;" />
							</td>
						</tr>
					</table>
				</form>
				<form name="comexcel" action="index.php?m=excel&c=comexcel" target="supportiframe" method="post" encType="multipart/form-data"
				 onSubmit="return tcdiv('comexcel');">
					<input type="hidden" name="pytoken" value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
					<table width="100%" class="table_form">
						<tr id="photo">
							<th width="160">上传企业职位数据：</th>
							<td>
								<input type="file" name="excel" value="" class="">
								<input class="subbut" type="submit" name="link_add" value="&nbsp;开始导入&nbsp;" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

		<?php echo '<script'; ?>
>
			function tcdiv(name) {
				parent.layer.load('执行中，请稍后...', 0);
			}
		<?php echo '</script'; ?>
>
	</body>
</html>
<?php }} ?>
