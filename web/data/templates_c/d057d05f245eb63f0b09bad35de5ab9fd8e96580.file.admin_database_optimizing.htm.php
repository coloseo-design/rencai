<?php /* Smarty version Smarty-3.1.21-dev, created on 2022-07-21 16:10:04
         compiled from "D:\wwwroot\rencai_lygki7\web\app\template\admin\admin_database_optimizing.htm" */ ?>
<?php /*%%SmartyHeaderCode:2818862d909dc37e082-57026956%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd057d05f245eb63f0b09bad35de5ab9fd8e96580' => 
    array (
      0 => 'D:\\wwwroot\\rencai_lygki7\\web\\app\\template\\admin\\admin_database_optimizing.htm',
      1 => 1634883865,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2818862d909dc37e082-57026956',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'list' => 0,
    'key' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_62d909dc3d5892_46504018',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d909dc3d5892_46504018')) {function content_62d909dc3d5892_46504018($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
				<div class="tabs_info">
					<ul>
						<li> <a href="index.php?m=database">备份数据</a></li>
						<li><a href="index.php?m=database&c=backin">恢复数据</a></li>
						<li class="curr"> <a href="index.php?m=database&c=optimizing">优化数据</a></li>
						<li><a href="index.php?m=database&c=clearList">数据清理</a></li>
					</ul>
				</div>
				<div class="admin_new_tip">
					<a href="javascript:;" class="admin_new_tip_close"></a>
					<a href="javascript:;" class="admin_new_tip_open" style="display:none;"></a>
					<div class="admin_new_tit"><i class="admin_new_tit_icon"></i>操作提示</div>
					<div class="admin_new_tip_list_cont">
						<div class="admin_new_tip_list">手动清理数据表碎片。</div>
						<div class="admin_new_tip_list">定期清理数据表碎片可以提升数据库的查询速度。</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="table-list mt10">
					<div class="admin_table_border">
						<table width="100%">
							<thead>
								<tr class="admin_table_top">
									<th align="left">数据表</th>
									<th align="left">数据表类型</th>
									<th align="left">数量</th>
									<th align="left">数据</th>
									<th align="left">碎片</th>
									<th align="left">字符集</th>
									<th align="left">操作</th>
								</tr>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
								<tr align="center" <?php if (($_smarty_tpl->tpl_vars['key']->value+1)%2=='0') {?>class="admin_com_td_bg"<?php }?>> <td width="300" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
									<td width="100" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
</td>
									<td width="100" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['num'];?>
条</td>
									<td width="100" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['size'];?>
</td>
									<td width="100" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['chip'];?>
</td>
									<td width="100" align="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['charset'];?>
</td>
									<td width="150" align="left">
										<a href="javascript:;" class="admin_new_c_bth" onclick="layer_del('','index.php?m=database&c=sql&name=<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
&type=2');">修复</a>
										<a href="javascript:;" class="admin_new_c_bth" onclick="layer_del('','index.php?m=database&c=sql&name=<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
&type=3');">优化</a>
									</td>

								</tr>
								<?php } ?>
							</tbody>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
