<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 17:28:45
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tongji.htm" */ ?>
<?php /*%%SmartyHeaderCode:1876762d91c4d87f580-74063174%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ea57e1510cf44825f7050fbecb2fb4ab1021e7d' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tongji.htm',
      1 => 1634883866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1876762d91c4d87f580-74063174',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d91c4d8e1204_80050385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d91c4d8e1204_80050385')) {function content_62d91c4d8e1204_80050385($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
" rel="stylesheet" type="text/css" />
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
 src="js/echarts_plain.js?v=<?php echo $_smarty_tpl->tpl_vars['config']->value['cachecode'];?>
"><?php echo '</script'; ?>
>
<title>后台管理</title>
</head>
<body class="body_ifm">
<div class="infoboxp"> 


<div class="tty_table-bom">
<table class="admin_tj_table">
<tr>
<td><a href="index.php?m=admin_tongji&c=reg&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg"><i class="admin_tj_icon admin_tj_icon_zc"></i></div><div class="admin_tj_p">会员注册统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=lookjob&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_b"><i class="admin_tj_icon admin_tj_icon_l"></i></div><div class="admin_tj_p">职位浏览统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=lookresume&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_c"><i class="admin_tj_icon admin_tj_icon_jianli"></i></div><div class="admin_tj_p">简历浏览统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=useridmsg&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_d"><i class="admin_tj_icon admin_tj_icon_ms"></i></div><div class="admin_tj_p">邀请面试统计</div></div></a></td>

</tr>
<tr>
<td><a href="index.php?m=admin_tongji&c=downresume&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_c"><i class="admin_tj_icon admin_tj_icon_xz"></i></div><div class="admin_tj_p">简历下载统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=useridjob&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_d"><i class="admin_tj_icon admin_tj_icon_td"></i></div><div class="admin_tj_p">简历投递统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=order&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_e"><i class="admin_tj_icon admin_tj_icon_cz"></i></div><div class="admin_tj_p">财务统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=ad&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_a"><i class="admin_tj_icon admin_tj_icon_xf"></i></div><div class="admin_tj_p">广告统计</div></div></a></td>

</tr>

<tr>


<td><a href="index.php?m=admin_tongji&c=company&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_b"><i class="admin_tj_icon admin_tj_icon_bl"></i></div><div class="admin_tj_p">企业统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=job&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg"><i class="admin_tj_icon admin_tj_icon_sj"></i></div><div class="admin_tj_p">职位数据统计</div></div></a></td>

<td><a href="index.php?m=admin_tongji&c=resume&days=7" class="admin_tj_list_box"><div class="admin_tj_list"><div class="admin_tj_icon_bg admin_tj_icon_bg_c"><i class="admin_tj_icon admin_tj_icon_sjtj"></i></div><div class="admin_tj_p">简历数据统计</div></div></a></td>
</tr
></table>



</div>




</body>
</html><?php }} ?>
