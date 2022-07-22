<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 15:29:59
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_tpl_index.htm" */ ?>
<?php /*%%SmartyHeaderCode:257562d90077afd510-48040332%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fedd5df23fde2402f0a67f1804e6ab0702ffbce4' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_tpl_index.htm',
      1 => 1645274794,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '257562d90077afd510-48040332',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'list' => 0,
    'v' => 0,
    'pytoken' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d90077b785b4_44564184',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d90077b785b4_44564184')) {function content_62d90077b785b4_44564184($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
						<div class="admin_new_tip_list">根据节假日或重大节日设置首页主题模板，<a href="https://www.wanxiangku.com"
							 target="_blank" style="color:red;">点击下载主题模板</a>。 </div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="admin_new_search_box" style="padding-bottom:10px;">
					<div class="admin_new_select">
						<a href="index.php?m=admin_tpl_index&c=add" class="admin_new_cz_tj" style="margin-left:0px;">+ 添加主题</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>

			<div class="tty_table-bom">
				<div class="table-list" style="overflow: hidden;">
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<div class="" style="float: left; width: 260px;border:1px solid #ddd; text-align: center; padding: 15px; line-height: 180%; margin-top:10px; margin-right:5px; background:#fff">
						<img width="255" height="125" border="1" alt="<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['v']->value['pic'];?>
">
						<br>
						<strong><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</strong>
						<br>
						状态：<?php if ($_smarty_tpl->tpl_vars['v']->value['status']==1) {?>正在使用<?php } else { ?>已停止<?php }?>
						<br>
						<input name="" value="预览" type="submit" class="admin_button" onClick="window.open('<?php echo $_smarty_tpl->tpl_vars['config']->value['sy_weburl'];?>
/index.php?tpltype=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
')">
						<input name="" value="修改" type="submit" class="admin_button" onClick="location.href='index.php?m=admin_tpl_index&c=add&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
'">
						<input name="" value="删除" type="submit" class="admin_button" onclick="layer_del('确定要删除？', 'index.php?m=admin_tpl_index&c=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
');">
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<input type="hidden" name="pytoken" id='pytoken' value="<?php echo $_smarty_tpl->tpl_vars['pytoken']->value;?>
">
	</body>
</html>
<?php }} ?>
