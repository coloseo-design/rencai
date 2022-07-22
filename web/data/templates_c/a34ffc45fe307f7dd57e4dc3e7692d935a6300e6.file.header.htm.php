<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:10:02
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\member\user\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:1311962d8fbcaedb783-14832076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a34ffc45fe307f7dd57e4dc3e7692d935a6300e6' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\member\\user\\header.htm',
      1 => 1634883848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1311962d8fbcaedb783-14832076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'user_style' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d8fbcaf385e4_30669059',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d8fbcaf385e4_30669059')) {function content_62d8fbcaf385e4_30669059($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>个人用户管理平台 - <?php echo $_smarty_tpl->tpl_vars['config']->value['sy_webname'];?>
</title>
		<meta http-equiv=Content-Type content="text/html;charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<meta content="MSHTML 6.00.6000.16939" name="Generator" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['user_style']->value;?>
/images/m_css.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" rel="stylesheet" />
        <link href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
/style/tips.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" type="text/css" rel="stylesheet"/>
		<?php echo '<script'; ?>
>
			var weburl = "<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
";
			var pricename = "<?php echo $_smarty_tpl->tpl_vars['config']->value['integral_pricename'];?>
";
			var user_sqintegrity = "<?php echo $_smarty_tpl->tpl_vars['config']->value['user_sqintegrity'];?>
";
		<?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/jquery-1.8.1.min.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/css/layui.css?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
" rel="stylesheet" type="text/css" />
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/layui.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/layui/phpyun_layer.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/member_public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/public.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<!--[if IE 6]>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/js/png.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
>
		  DD_belatedPNG.fix('.png');
		<?php echo '</script'; ?>
>
		<![endif]-->
	</head>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['userstyle']->value)."/headnav.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
